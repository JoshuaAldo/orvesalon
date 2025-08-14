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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{
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

    // public function getAvailableTimes(Request $request)
    // {
    //     $date = $request->query('date');
    //     $locationId = $request->query('location_id');

    //     $times = Schedule::whereDate('available_at', $date)
    //         ->where('location_id', $locationId)
    //         ->get()
    //         ->filter(function ($schedule) {
    //             return $schedule->bookings()->count() < $schedule->capacity;
    //         })
    //         ->pluck('available_at')
    //         ->map(function ($item) {
    //             return $item->format('H:i');
    //         });

    //     return response()->json(['times' => $times]);
    // }

    public function getAvailableDates(Request $request)
    {
        $validated = $request->validate([
            'hairdresser_id' => 'required|integer|exists:hairdressers,id',
            'service_id' => 'required|integer|exists:services,id',
        ]);

        try {
            // Mengambil semua jadwal yang cocok
            $schedules = Schedule::where('hairdresser_id', $validated['hairdresser_id'])
                ->where('service_id', $validated['service_id'])
                ->whereDate('available_at', '>=', Carbon::today())
                ->orderBy('available_at', 'asc')
                ->get(['available_at']);

            // Memetakan ke format tanggal Y-m-d dan mengambil yang unik
            $availableDates = $schedules->map(function ($schedule) {
                return Carbon::parse($schedule->available_at)->format('Y-m-d');
            })
                ->unique()
                ->values(); // Mengembalikan array biasa tanpa key asosiatif

            return response()->json(['available_dates' => $availableDates]);
        } catch (\Exception $e) {
            Log::error("Error fetching available dates for hairdresser {$validated['hairdresser_id']} and service {$validated['service_id']}: " . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil tanggal tersedia.'], 500);
        }
    }

    public function getAvailableTimes(Request $request)
    {
        $validated = $request->validate([
            'hairdresser_id' => 'required|integer|exists:hairdressers,id',
            'service_id' => 'required|integer|exists:services,id',
            'date' => 'required|date_format:Y-m-d',
        ]);

        try {
            $selectedDate = Carbon::parse($validated['date'])->startOfDay();

            $schedules = Schedule::where('hairdresser_id', $validated['hairdresser_id'])
                ->where('service_id', $validated['service_id'])
                ->whereDate('available_at', $selectedDate)
                ->when($selectedDate->isToday(), function ($query) {
                    // Filter waktu yang sudah lewat HANYA jika tanggal yang dipilih adalah hari ini
                    $query->whereTime('available_at', '>', Carbon::now()->format('H:i:s'));
                })
                ->orderBy('available_at', 'asc')
                ->get(); // Ambil seluruh objek schedule untuk mendapatkan ID jika perlu

            $availableTimes = $schedules->map(function ($schedule) {
                $time = Carbon::parse($schedule->available_at);
                return [
                    // Penting: Jika Anda ingin mengirim schedule_id ke frontend untuk disubmit
                    // 'schedule_id' => $schedule->id,
                    'time' => $time->format('H:i'), // Format untuk value, misal 09:00
                    'formatted_time' => $time->format('h:i A') // Format untuk display, misal 09:00 AM
                ];
            })
                ->unique('time') // Pastikan slot waktu unik
                ->values();

            return response()->json(['available_times' => $availableTimes]);
        } catch (\Exception $e) {
            Log::error("Error fetching available times for hairdresser {$validated['hairdresser_id']}, service {$validated['service_id']}, date {$validated['date']}: " . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil jam tersedia.'], 500);
        }
    }

    public function finish($uuid)
    {
        DB::beginTransaction();

        try {
            $booking = Booking::findOrFail($uuid);

            // Hanya update jika status masih pending
            if ($booking->status === 'pending') {
                // 1. Update status booking
                $booking->update(['status' => 'paid']);

                // 2. Kurangi available_hairdressers
                $schedule = Schedule::find($booking->schedule_id);
                $schedule->decrement('available_hairdressers');

                // Send emails
                Mail::to($booking->email)
                    ->send(new BookingConfirmationMail($booking));

                Mail::to('orvesalon@gmail.com')
                    ->send(new AdminNotificationMail($booking));
            }

            DB::commit();
            return redirect()->route('booking.success', $booking->uuid);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('booking.failed')
                ->with('error', 'Konfirmasi pembayaran gagal: ' . $e->getMessage());
        }
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
            'schedule_id' => 'required|exists:schedules,id',
            'location_id' => 'required|exists:locations,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $schedule = Schedule::findOrFail($validated['schedule_id']);
        // $price = $service->price;
        $price = $service->promo_price && $service->promo_price < $service->price
            ? $service->promo_price
            : $service->price;

        DB::beginTransaction();

        try {
            $booking = Booking::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'service_id' => $validated['service_id'],
                'price' => $price,
                'status' => 'pending',
                'schedule_id' => $validated['schedule_id'],
                'location_id' => $validated['location_id'],
                'notes' => $validated['notes'],
            ]);

            DB::commit();

            // Kembalikan data booking saja tanpa snap token
            return response()->json([
                'success' => true,
                'booking' => [
                    'id' => $booking->id,
                    'price' => $price,
                    'service_name' => $service->name,
                    'customer_name' => $validated['name'],
                    'address' => $validated['address'],
                    'phone' => $validated['phone'],
                    'schedule' => $schedule->available_at,
                    'email' => $validated['email']
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Booking gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generatePaymentToken(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'BOOK-' . $booking->id . '-' . time(),
                'gross_amount' => $booking->price,
            ],
            'item_details' => [
                [
                    'id' => 'SRV-' . $booking->service_id,
                    'price' => $booking->price,
                    'quantity' => '1',
                    'name' => $booking->service->name,
                    'brand' => 'Orve',
                    'category' => 'Home Care Service',
                    'merchant_name' => 'Orve Salon'
                ]
            ],
            'customer_details' => [
                'first_name' => $booking->name,
                'email' => $booking->email,
                'phone' => $booking->phone,
                'address' => $booking->address,
                'billing_address' => [
                    'first_name' => $booking->name,
                    'address' => $booking->address,
                    'phone' => $booking->phone
                ]
            ],
            'metadata' => [
                'booking_id' => $booking->id,
                'service_type' => $booking->service->name,
                'location' => $booking->location->name
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken, 'uuid' => $booking->uuid]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal generate payment token'], 500);
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
