<?php

namespace App\Http\Controllers;

use App\Mail\AdminNotificationMail;
use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\Hairdresser;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{

    public function __construct()
    {
        // Set konfigurasi Midtrans dari file config/midtrans.php
        // yang seharusnya mengambil dari .env
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }
    public function index(Request $request)
    {
        $previousUrl = url()->previous();
        $fromHomeOrHomecare = null;
        $services = Service::all();
        $locations = Location::all(); // ambil semua lokasi
        $testimonials = Testimonial::latest()->get();

        if (Str::endsWith($previousUrl, 'homecare')) {
            $fromHomeOrHomecare = 'homecare';
        } else if (Str::endsWith($previousUrl, 'home')) {
            $fromHomeOrHomecare = 'home';
        }

        return view('booking.index', compact('fromHomeOrHomecare', 'services', 'locations', 'testimonials'));
    }

    public function getHairdressers(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'location_id' => 'required|integer|exists:locations,id',
        ]);

        $serviceId = $validated['service_id'];
        $locationId = $validated['location_id'];

        try {
            $hairdressers = Hairdresser::whereHas('services', function ($query) use ($serviceId) {
                $query->where('services.id', $serviceId);
            })->whereHas('locations', function ($query) use ($locationId) {
                $query->where('locations.id', $locationId);
            })
                ->orderBy('name', 'asc')
                ->get(['id', 'name']);

            return response()->json(['hairdressers' => $hairdressers]);
        } catch (\Exception $e) {
            Log::error("Error fetching hairdressers for service {$serviceId} and location {$locationId}: " . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil data hairdresser.'], 500);
        }
    }

    // public function getAvailableDates(Request $request)
    // {
    //     $validated = $request->validate([
    //         'hairdresser_id' => 'required|integer|exists:hairdressers,id',
    //         'service_id' => 'required|integer|exists:services,id',
    //     ]);

    //     try {
    //         // Mengambil semua jadwal yang cocok
    //         $schedules = Schedule::where('hairdresser_id', $validated['hairdresser_id'])
    //             ->where('service_id', $validated['service_id'])
    //             ->whereDate('available_at', '>=', Carbon::today())
    //             ->orderBy('available_at', 'asc')
    //             ->get(['available_at']);

    //         // Memetakan ke format tanggal Y-m-d dan mengambil yang unik
    //         $availableDates = $schedules->map(function ($schedule) {
    //             return Carbon::parse($schedule->available_at)->format('Y-m-d');
    //         })
    //             ->unique()
    //             ->values(); // Mengembalikan array biasa tanpa key asosiatif

    //         return response()->json(['available_dates' => $availableDates]);
    //     } catch (\Exception $e) {
    //         Log::error("Error fetching available dates for hairdresser {$validated['hairdresser_id']} and service {$validated['service_id']}: " . $e->getMessage());
    //         return response()->json(['error' => 'Gagal mengambil tanggal tersedia.'], 500);
    //     }
    // }


    // public function getAvailableTimes(Request $request)
    // {
    //     $validated = $request->validate([
    //         'hairdresser_id' => 'required|integer|exists:hairdressers,id',
    //         'service_id' => 'required|integer|exists:services,id',
    //         'date' => 'required|date_format:Y-m-d',
    //     ]);

    //     try {
    //         $selectedDate = Carbon::parse($validated['date'])->startOfDay();

    //         $schedules = Schedule::where('hairdresser_id', $validated['hairdresser_id'])
    //             ->where('service_id', $validated['service_id'])
    //             ->whereDate('available_at', $selectedDate)
    //             ->when($selectedDate->isToday(), function ($query) {
    //                 // Filter waktu yang sudah lewat HANYA jika tanggal yang dipilih adalah hari ini
    //                 $query->whereTime('available_at', '>', Carbon::now()->format('H:i:s'));
    //             })
    //             ->orderBy('available_at', 'asc')
    //             ->get(); // Ambil seluruh objek schedule untuk mendapatkan ID jika perlu

    //         $availableTimes = $schedules->map(function ($schedule) {
    //             $time = Carbon::parse($schedule->available_at);
    //             return [
    //                 // Penting: Jika Anda ingin mengirim schedule_id ke frontend untuk disubmit
    //                 // 'schedule_id' => $schedule->id,
    //                 'time' => $time->format('H:i'), // Format untuk value, misal 09:00
    //                 'formatted_time' => $time->format('h:i A') // Format untuk display, misal 09:00 AM
    //             ];
    //         })
    //             ->unique('time') // Pastikan slot waktu unik
    //             ->values();

    //         return response()->json(['available_times' => $availableTimes]);
    //     } catch (\Exception $e) {
    //         Log::error("Error fetching available times for hairdresser {$validated['hairdresser_id']}, service {$validated['service_id']}, date {$validated['date']}: " . $e->getMessage());
    //         return response()->json(['error' => 'Gagal mengambil jam tersedia.'], 500);
    //     }
    // }

    public function getAvailableDates(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|integer|exists:services,id',
        ]);
        try {
            $availableDates = Schedule::where('service_id', $validated['service_id'])
                ->whereDate('available_at', '>=', Carbon::today())
                ->whereDoesntHave('bookings', function ($q) { // Filter jadwal yang sudah di-booking
                    $q->whereIn('status', ['paid']);
                })
                ->select(DB::raw('DATE(available_at) as schedule_date'))
                ->distinct()
                ->orderBy('schedule_date', 'asc')
                ->pluck('schedule_date')
                ->map(function ($date) {
                    return Carbon::parse($date)->format('Y-m-d');
                });
            return response()->json(['available_dates' => $availableDates]);
        } catch (\Exception $e) {
            Log::error("Error fetching available dates by service: " . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil tanggal tersedia.'], 500);
        }
    }

    // public function getAvailableTimes(Request $request)
    // {
    //     $validated = $request->validate([
    //         'service_id' => 'required|integer|exists:services,id',
    //         'date' => 'required|date_format:Y-m-d',
    //     ]);
    //     try {
    //         $selectedDate = Carbon::parse($validated['date'])->startOfDay();
    //         $serviceId = $validated['service_id']; // Simpan ke variabel agar mudah di-log

    //         $query = Schedule::where('service_id', $serviceId)
    //             ->whereDate('available_at', $selectedDate)
    //             ->when($selectedDate->isToday(), function ($query) {
    //                 $nowTime = Carbon::now(config('app.timezone'))->format('H:i:s'); // Pastikan timezone konsisten
    //                 Log::info("[getAvailableTimes] Filtering for today. Current time: {$nowTime}");
    //                 $query->whereTime('available_at', '>', $nowTime);
    //             })
    //             ->whereDoesntHave('bookings', function ($q) {
    //                 $q->whereIn('status', ['paid']);
    //             })
    //             ->orderBy('available_at', 'asc');

    //         $schedules = $query->get(['id', 'available_at']);

    //         $availableTimes = $schedules->map(function ($schedule) {
    //             $time = Carbon::parse($schedule->available_at); // Sebaiknya gunakan timezone aplikasi
    //             return [
    //                 'schedule_id' => $schedule->id,
    //                 'time' => $time->format('H:i'),
    //                 'formatted_time' => $time->format('h:i A')
    //             ];
    //         })->values();

    //         return response()->json(['available_times' => $availableTimes]);
    //     } catch (\Exception $e) {
    //         Log::error("[getAvailableTimes] Error: " . $e->getMessage());
    //         return response()->json(['error' => 'Gagal mengambil jam tersedia.'], 500);
    //     }
    // }

    public function getAvailableTimes(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'date' => 'required|date_format:Y-m-d',
        ]);
        try {
            $selectedDate = Carbon::parse($validated['date'])->startOfDay();

            $schedules = Schedule::where('service_id', $validated['service_id'])
                ->whereDate('available_at', $selectedDate)
                ->when($selectedDate->isToday(), function ($query) {
                    $query->whereTime('available_at', '>', Carbon::now(config('app.timezone'))->format('H:i:s'));
                })
                ->whereDoesntHave('bookings', function ($q) {
                    $q->whereIn('status', ['paid']);
                })
                ->orderBy('available_at', 'asc')
                ->get(['id', 'available_at']); // Ambil ID schedule dan waktunya

            // Kelompokkan jadwal berdasarkan jam (HH:MM)
            $groupedByTime = $schedules->groupBy(function ($schedule) {
                return Carbon::parse($schedule->available_at)->format('H:i');
            });

            $availableTimes = new Collection(); // Gunakan Illuminate\Support\Collection
            foreach ($groupedByTime as $timeSlot => $scheduleGroup) {
                if ($scheduleGroup->count() > 0) {
                    // Ambil waktu dari jadwal pertama di grup untuk format tampilan
                    $firstScheduleInGroup = $scheduleGroup->first();
                    $timeCarbon = Carbon::parse($firstScheduleInGroup->available_at);

                    $availableTimes->push([
                        'time' => $timeCarbon->format('H:i'), // Value untuk dropdown "HH:MM"
                        'formatted_time' => $timeCarbon->format('h:i A'),
                        'slot_count' => $scheduleGroup->count() // Jumlah slot tersedia untuk jam ini
                    ]);
                }
            }

            return response()->json(['available_times' => $availableTimes->values()]);
        } catch (\Exception $e) {
            Log::error("[getAvailableTimes] Error: " . $e->getMessage() . " - Trace: " . $e->getTraceAsString());
            return response()->json(['error' => 'Gagal mengambil jam tersedia.'], 500);
        }
    }

    public function finish(Request $request, $uuid)
    {
        DB::beginTransaction();
        try {
            $booking = Booking::where('uuid', $uuid)->firstOrFail();

            if ($booking->status === 'pending') {
                // SANGAT DISARANKAN: Verifikasi status transaksi ke Midtrans sebelum update
                // $status = \Midtrans\Transaction::status($booking->uuid);
                // if ($status->transaction_status == 'capture' || $status->transaction_status == 'settlement') {
                //    $booking->update(['status' => 'paid']);
                // } // else handle status lain

                // Untuk sekarang, asumsikan paid jika sampai sini (perlu webhook untuk akurasi)
                $booking->update(['status' => 'paid']);

                // Tidak perlu decrement 'available_hairdressers' lagi
                // Jadwal yang terkait dengan booking ini sekarang dianggap terisi.

                try {
                    Mail::to($booking->email)->send(new BookingConfirmationMail($booking));
                    // Mail::to(config('mail.admin_address', 'orvesalon@gmail.com'))->send(new AdminNotificationMail($booking));
                } catch (\Exception $mailException) {
                    Log::error("Failed to send booking emails for booking UUID {$uuid}: " . $mailException->getMessage());
                }
            }

            DB::commit();
            return redirect()->route('booking.success', ['uuid' => $booking->uuid]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error in booking finish for UUID {$uuid}: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('booking.failed')->with('error', 'Konfirmasi pembayaran gagal: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'service_id' => 'required|integer|exists:services,id',
            'location_id' => 'required|integer|exists:locations,id', // Lokasi yang dipilih pelanggan
            'booking_date' => 'required|date_format:Y-m-d',
            'booking_time' => 'required|date_format:H:i', // Ini adalah string waktu "HH:MM" dari dropdown jam
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            $selectedService = Service::findOrFail($validatedData['service_id']);
            $priceToCharge = $selectedService->promo_price ?? $selectedService->price;
            $serviceName = $selectedService->name;

            $exactBookingDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['booking_date'] . ' ' . $validatedData['booking_time'], config('app.timezone'))
                ->format('Y-m-d H:i:s');

            // Cari SATU schedule_id yang tersedia yang cocok dengan service, location, dan waktu yang dipilih
            $schedule = Schedule::with('hairdresser')
                ->where('service_id', $validatedData['service_id'])
                ->where('available_at', $exactBookingDateTime)
                ->whereDoesntHave('bookings', function ($q) {
                    $q->whereIn('status', ['paid']);
                })
                ->orderBy('id', 'asc') // Atau strategi lain untuk memilih satu dari beberapa slot yang mungkin cocok
                ->first();



            if (!$schedule) {
                Log::warning('Tidak ada schedule spesifik yang cocok ditemukan saat store:', array_merge($validatedData, ['target_datetime' => $exactBookingDateTime]));
                return response()->json(['success' => false, 'message' => 'Maaf, slot waktu yang dipilih tidak lagi tersedia untuk kombinasi layanan dan lokasi ini. Silakan coba jam lain atau refresh halaman.'], 422);
            }

            $booking = Booking::create([
                'uuid' => Str::uuid()->toString(),
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
                'schedule_id' => $schedule->id,
                'service_id' => $validatedData['service_id'],
                'location_id' => $validatedData['location_id'],
                'notes' => $validatedData['notes'],
                'price' => $priceToCharge,
                'status' => 'pending',
                'booking_time' => $schedule->available_at,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'booking' => [
                    'id' => $booking->id,
                    'uuid' => $booking->uuid,
                    'price' => $booking->price,
                    'service_name' => $serviceName,
                    'customer_name' => $booking->name,
                    'address' => $booking->address,
                    'phone' => $booking->phone,
                    'schedule' => $booking->booking_time->toIso8601String(), // Kirim sebagai ISO 8601 UTC
                    'email' => $booking->email
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error during booking (store): ', $e->errors());
            return response()->json(['success' => false, 'message' => 'Data tidak valid.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating booking (store): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Booking gagal: Terjadi kesalahan internal. ' . $e->getMessage()], 500);
        }
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' => 'required|string|max:20',
    //         'email' => 'required|email|max:255',
    //         'address' => 'required|string|max:500',
    //         'service_id' => 'required|integer|exists:services,id',
    //         'location_id' => 'required|integer|exists:locations,id', // Lokasi yang dipilih pelanggan
    //         'schedule_id' => 'required|integer|exists:schedules,id', // Ini adalah ID schedule dari dropdown jam
    //         'notes' => 'nullable|string|max:1000',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         $selectedService = Service::findOrFail($validatedData['service_id']);
    //         $priceToCharge = $selectedService->promo_price ?? $selectedService->price;
    //         $serviceName = $selectedService->name;

    //         // Ambil detail schedule berdasarkan schedule_id yang dipilih
    //         $schedule = Schedule::with('hairdresser') // Eager load hairdresser
    //             ->where('id', $validatedData['schedule_id'])
    //             // Validasi tambahan untuk memastikan integritas data
    //             ->where('service_id', $validatedData['service_id'])
    //             ->whereDoesntHave('bookings', function ($q) {
    //                 $q->whereIn('status', ['paid']);
    //             })
    //             ->first();

    //         if (!$schedule) {
    //             Log::warning('Jadwal (ID: ' . $validatedData['schedule_id'] . ') tidak valid atau sudah di-booking saat proses store:', $validatedData);
    //             return response()->json(['success' => false, 'message' => 'Jadwal yang dipilih tidak lagi tersedia atau tidak valid. Silakan pilih jadwal lain.'], 422);
    //         }

    //         $exactBookingTime = $schedule->available_at; // Ambil waktu pasti dari schedule

    //         $booking = Booking::create([
    //             'uuid' => Str::uuid()->toString(),
    //             'name' => $validatedData['name'],
    //             'phone' => $validatedData['phone'],
    //             'email' => $validatedData['email'],
    //             'address' => $validatedData['address'],
    //             'schedule_id' => $schedule->id,
    //             'service_id' => $validatedData['service_id'],
    //             'location_id' => $validatedData['location_id'], // Simpan lokasi yang dipilih user
    //             'notes' => $validatedData['notes'],
    //             'price' => $priceToCharge, // Sesuai kolom 'price' di tabel bookings Anda
    //             'status' => 'pending',
    //             'booking_time' => $exactBookingTime, // Simpan waktu aktual dari schedule
    //         ]);

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'booking' => [
    //                 'id' => $booking->id,
    //                 'uuid' => $booking->uuid,
    //                 'price' => $booking->price,
    //                 'service_name' => $serviceName,
    //                 'customer_name' => $booking->name,
    //                 'address' => $booking->address,
    //                 'phone' => $booking->phone,
    //                 'schedule' => $booking->booking_time->toIso8601String(), // Kirim sebagai ISO 8601 UTC
    //                 'email' => $booking->email
    //             ]
    //         ]);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         DB::rollBack();
    //         Log::error('Validation error during booking (store): ', $e->errors());
    //         return response()->json(['success' => false, 'message' => 'Data tidak valid.', 'errors' => $e->errors()], 422);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error creating booking (store): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
    //         return response()->json(['success' => false, 'message' => 'Booking gagal: Terjadi kesalahan internal. ' . $e->getMessage()], 500);
    //     }
    // }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' => 'required|string|max:20',
    //         'email' => 'required|email|max:255',
    //         'address' => 'required|string|max:500',
    //         'service_id' => 'required|integer|exists:services,id',
    //         'location_id' => 'required|integer|exists:locations,id',
    //         'hairdresser_id' => 'required|integer|exists:hairdressers,id',
    //         'booking_date' => 'required|date_format:Y-m-d',
    //         'booking_time' => 'required|date_format:H:i',
    //         'notes' => 'nullable|string|max:1000',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         $selectedService = Service::findOrFail($validatedData['service_id']);
    //         // Menggunakan nama kolom 'price' dari tabel services Anda
    //         $priceToCharge = $selectedService->promo_price ?? $selectedService->price;
    //         $serviceName = $selectedService->name;

    //         $availableAtDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['booking_date'] . ' ' . $validatedData['booking_time'])->format('Y-m-d H:i:s');

    //         $schedule = Schedule::where('hairdresser_id', $validatedData['hairdresser_id'])
    //             ->where('service_id', $validatedData['service_id'])
    //             ->where('location_id', $validatedData['location_id'])
    //             ->where('available_at', $availableAtDateTime)
    //             ->whereDoesntHave('bookings', function ($q) { // Pastikan jadwal belum di-booking
    //                 $q->whereIn('status', ['paid']);
    //             })
    //             ->first();

    //         if (!$schedule) {
    //             Log::warning('Percobaan booking untuk jadwal tidak valid/tersedia (store):', $validatedData);
    //             return response()->json(['success' => false, 'message' => 'Jadwal yang dipilih tidak tersedia atau tidak valid. Silakan pilih jadwal lain.'], 422);
    //         }

    //         $booking = Booking::create([
    //             'uuid' => Str::uuid()->toString(),
    //             'name' => $validatedData['name'],             // Sesuai dengan kolom 'name' di tabel bookings Anda
    //             'phone' => $validatedData['phone'],           // Sesuai dengan kolom 'phone'
    //             'email' => $validatedData['email'],           // Sesuai dengan kolom 'email'
    //             'address' => $validatedData['address'],
    //             'schedule_id' => $schedule->id,
    //             'service_id' => $validatedData['service_id'],
    //             'location_id' => $validatedData['location_id'],
    //             'hairdresser_id' => $validatedData['hairdresser_id'], // Kolom baru
    //             'notes' => $validatedData['notes'],
    //             'price' => $priceToCharge,                     // Sesuai dengan kolom 'price' di tabel bookings Anda
    //             'status' => 'pending',
    //             'booking_time' => $availableAtDateTime,       // Kolom baru
    //         ]);

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'booking' => [
    //                 'id' => $booking->id,
    //                 'uuid' => $booking->uuid,
    //                 'price' => $booking->price, // Menggunakan 'price' dari booking yang baru dibuat
    //                 'service_name' => $serviceName,
    //                 'customer_name' => $booking->name, // Menggunakan 'name' dari booking
    //                 'address' => $booking->address,
    //                 'phone' => $booking->phone,     // Menggunakan 'phone' dari booking
    //                 'schedule' => $booking->booking_time,
    //                 'email' => $booking->email      // Menggunakan 'email' dari booking
    //             ]
    //         ]);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         DB::rollBack();
    //         Log::error('Validation error during booking (store): ', $e->errors());
    //         return response()->json(['success' => false, 'message' => 'Data tidak valid.', 'errors' => $e->errors()], 422);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error creating booking (store): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
    //         return response()->json(['success' => false, 'message' => 'Booking gagal: Terjadi kesalahan internal.'], 500);
    //     }
    // }

    public function generatePaymentToken(Request $request, $bookingId)
    {
        try {
            $booking = Booking::with('service', 'location')->findOrFail($bookingId);

            if ($booking->status === 'paid' || $booking->status === 'completed') {
                return response()->json(['error' => 'Booking ini sudah dibayar.'], 400);
            }

            // Pastikan kunci API sudah di-set di constructor atau di sini jika perlu
            if (empty(Config::$serverKey) || empty(Config::$clientKey)) {
                Log::critical('Midtrans API keys are not configured properly.');
                return response()->json(['error' => 'Konfigurasi pembayaran tidak lengkap.'], 500);
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $booking->uuid,
                    'gross_amount' => (int) $booking->price,
                ],
                'item_details' => [
                    [
                        'id' => 'SRV-' . $booking->service_id,
                        'price' => (int) $booking->price,
                        'quantity' => 1,
                        'name' => $booking->service->name, // Pastikan relasi service ada
                    ]
                ],
                'customer_details' => [
                    'first_name' => $booking->name, // Sesuai kolom tabel bookings
                    'email' => $booking->email,
                    'phone' => $booking->phone,
                    'billing_address' => [
                        'first_name' => $booking->name,
                        'address' => $booking->address,
                        'phone' => $booking->phone
                    ]
                ],
                'callbacks' => [
                    'finish' => route('booking.finish', $booking->uuid)
                ],
                'promo_code' => true,
            ];

            $snapToken = Snap::getSnapToken($params);
            $booking->payment_token = $snapToken;
            $booking->save();

            return response()->json(['snap_token' => $snapToken, 'uuid' => $booking->uuid]);
        } catch (\Exception $e) {
            Log::error("Error generating payment token for booking ID {$bookingId}: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Gagal generate payment token: ' . $e->getMessage()], 500);
        }
    }

    public function success($uuid)
    {
        $booking = Booking::where('uuid', $uuid)->firstOrFail();

        return view('booking.success', compact('booking'));
    }

    public function failed()
    {
        return view('booking.failed');
    }

    public function getSchedulesByLocation($locationId)
    {
        // Ambil jadwal berdasarkan lokasi yang dipilih
        $schedules = Schedule::where('location_id', $locationId)
            ->withCount('bookings')  // Hitung jumlah pemesanan untuk setiap jadwal
            ->get();

        // Ambil ID jadwal yang sudah dipesan (booking)
        $bookedScheduleIds = Booking::whereIn('schedule_id', $schedules->pluck('id'))->pluck('schedule_id')->toArray();

        // Ambil ID jadwal yang dipilih sebelumnya (untuk old value)
        $oldScheduleId = old('schedule_id');

        // Kembalikan data dalam format JSON untuk dikirim ke front-end
        return response()->json([
            'schedules' => $schedules,
            'bookedScheduleIds' => $bookedScheduleIds,
            'oldScheduleId' => $oldScheduleId,
            'hairdresser_limit' => $schedules->pluck('available_hairdressers', 'id'),  // Menambahkan batasan hairdresser
        ]);
    }
}
