<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Imports\SchedulesImport;
use App\Models\Hairdresser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BookingSettingsController extends Controller
{

    public function index(Request $request)
    {
        // PAGINASI UNTUK LAYANAN
        $services = Service::orderBy('name')->paginate(5, ['*'], 'services_page')->appends($request->except('services_page'));
        $servicesAll = Service::all();
        // PAGINASI UNTUK LOKASI
        $locationsAll = Location::orderBy('name')->paginate(5, ['*'], 'locations_page')->appends($request->except('locations_page'));
        $locations = Location::all();
        $testimonials = Testimonial::latest()->get();
        $hairdressersAll = Hairdresser::orderBy('name')->get();
        $hairdressersPaginated = Hairdresser::withCount(['locations', 'services', 'schedules'])
            ->latest()
            ->paginate(5, ['*'], 'hairdressers_page') // Parameter paginasi unik
            ->appends($request->except('hairdressers_page'));


        $locationIdFilter = $request->input('location_id');
        $hairdresserIdFilter = $request->input('hairdresser_id_filter');
        $serviceIdFilter = $request->input('service_id_filter');
        $dateFilter = $request->input('date_filter');

        $schedulesQuery = Schedule::with(['hairdresser', 'service', 'location'])->orderBy('available_at', 'asc');
        if ($locationIdFilter) {
            $schedulesQuery->where('location_id', $locationIdFilter);
        }
        if ($hairdresserIdFilter) {
            $schedulesQuery->where('hairdresser_id', $hairdresserIdFilter);
        }
        if ($serviceIdFilter) {
            $schedulesQuery->where('service_id', $serviceIdFilter);
        }
        if ($dateFilter) {
            $schedulesQuery->whereDate('available_at', $dateFilter);
        }
        $schedules = $schedulesQuery->paginate(10, ['*'], 'schedules_page') // Parameter paginasi unik
            ->appends($request->except('schedules_page'));

        // Variabel untuk form edit hairdresser
        $editingHairdresser = null;
        $assignedLocationIds = [];
        $assignedServiceIds = [];
        $hairdresserSchedulesForEdit = null; // Ganti nama agar lebih jelas

        // Cek apakah ada parameter 'edit_hairdresser_id' di request
        if ($request->has('edit_hairdresser_id') && $request->edit_hairdresser_id) {
            $editingHairdresser = Hairdresser::with(['locations', 'services'])->find($request->edit_hairdresser_id);
            if ($editingHairdresser) {
                $assignedLocationIds = $editingHairdresser->locations()->pluck('locations.id')->toArray();
                $assignedServiceIds = $editingHairdresser->services()->pluck('services.id')->toArray();
                // Ambil jadwal khusus untuk hairdresser yang diedit, dengan paginasi sendiri
                $hairdresserSchedulesForEdit = $editingHairdresser->schedules()
                    ->with(['service', 'location'])
                    ->orderBy('available_at', 'desc')
                    ->paginate(5, ['*'], 'hd_schedules_page'); // Parameter paginasi unik
            }
        }

        // Variabel untuk form edit schedule
        $editingSchedule = null;
        if ($request->has('edit_schedule_id') && $request->edit_schedule_id) {
            $editingSchedule = Schedule::with('hairdresser')->find($request->edit_schedule_id);
            if ($editingSchedule) {
                $editingSchedule->date = Carbon::parse($editingSchedule->available_at)->format('Y-m-d');
                $editingSchedule->time = Carbon::parse($editingSchedule->available_at)->format('H:i');
            }
        }

        // Variabel untuk pre-fill form tambah jadwal
        $selectedHairdresserIdForSchedule = $request->query('prefill_hairdresser_id');

        return view('admin.booking-settings.index', compact(
            'services',
            'servicesAll',
            'schedules',
            'locationsAll',
            'locations',
            'testimonials',
            'hairdressersAll',
            'hairdressersPaginated',
            'locationIdFilter',
            'hairdresserIdFilter',
            'serviceIdFilter',
            'dateFilter',
            'editingHairdresser',
            'assignedLocationIds',
            'assignedServiceIds',
            'hairdresserSchedulesForEdit',
            'editingSchedule',
            'selectedHairdresserIdForSchedule'
        ));
    }

    public function listPaidBookings(Request $request)
    {
        $locations = Location::orderBy('name')->get();
        $selectedLocationId = $request->input('location_id');

        $paidBookingsQuery = \App\Models\Booking::with(['service', 'location', 'hairdresser', 'schedule'])
            ->where('status', 'paid')
            ->orderBy('booking_time', 'asc'); // Urutkan berdasarkan waktu booking terbaru

        if ($selectedLocationId) {
            $paidBookingsQuery->where('location_id', $selectedLocationId);
        }

        $paidBookings = $paidBookingsQuery->paginate(10)->appends($request->except('page'));

        return view('admin.bookings.paid_list', compact('paidBookings', 'locations', 'selectedLocationId'));
    }

    // --- Locations ---
    public function storeLocation(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:locations,name']);
        Location::create(['name' => $request->name]);
        return redirect()->route('schedules.index')->with('success', 'Lokasi berhasil ditambahkan!');
    }

    public function destroyLocation($id)
    {
        $location = Location::findOrFail($id);
        if ($location->schedules()->exists() || $location->hairdressers()->exists()) {
            return back()->withErrors(['error_location' => 'Tidak bisa menghapus lokasi yang sudah memiliki jadwal atau terhubung dengan hairdresser.'])->withInput();
        }
        $location->delete();
        return redirect()->route('schedules.index')->with('success', 'Lokasi berhasil dihapus!');
    }

    // --- Services ---
    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'price' => 'required|numeric|min:0',
            'promo_price' => 'nullable|numeric|min:0|lt:price',
        ]);
        Service::create($request->only('name', 'price', 'promo_price'));
        return redirect()->route('schedules.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function destroyService($id)
    {
        $service = Service::findOrFail($id);
        if ($service->schedules()->exists() || $service->hairdressers()->exists()) {
            return back()->withErrors(['error_service' => 'Tidak bisa menghapus layanan yang sudah memiliki jadwal atau terhubung dengan hairdresser.'])->withInput();
        }
        $service->delete();
        return redirect()->route('schedules.index')->with('success', 'Layanan berhasil dihapus!');
    }

    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'hairdresser_id' => 'required|integer|exists:hairdressers,id',
            'service_id' => 'required|integer|exists:services,id',
            'location_id' => 'required|integer|exists:locations,id',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);
        try {
            $availableAt = Carbon::createFromFormat('Y-m-d H:i', $validated['date'] . ' ' . $validated['time'])->format('Y-m-d H:i:s');
            $hairdresser = Hairdresser::with(['services', 'locations'])->find($validated['hairdresser_id']);
            if (!$hairdresser || !$hairdresser->services->contains($validated['service_id'])) {
                return back()->withInput()->with('error', 'Hairdresser ini tidak menyediakan layanan yang dipilih.');
            }
            if (!$hairdresser->locations->contains($validated['location_id'])) {
                return back()->withInput()->with('error', 'Hairdresser ini tidak bertugas di lokasi yang dipilih.');
            }
            $existingSchedule = Schedule::where('hairdresser_id', $validated['hairdresser_id'])
                ->where('service_id', $validated['service_id'])
                ->where('location_id', $validated['location_id'])
                ->where('available_at', $availableAt)->first();
            if ($existingSchedule) {
                return back()->withInput()->with('error', 'Jadwal identik sudah ada.');
            }
            Schedule::create([
                'hairdresser_id' => $validated['hairdresser_id'],
                'service_id' => $validated['service_id'],
                'location_id' => $validated['location_id'],
                'available_at' => $availableAt,
            ]);

            // Cek apakah request datang dari halaman edit hairdresser
            $redirectReferer = $request->headers->get('referer');
            if ($redirectReferer && str_contains($redirectReferer, 'hairdressers/' . $validated['hairdresser_id'] . '/edit')) {
                return redirect()->route('schedules.index', ['edit_hairdresser_id' => $validated['hairdresser_id']])->with('success', 'Jadwal berhasil ditambahkan ke hairdresser.');
            }
            return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error storing schedule: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan jadwal. ' . $e->getMessage());
        }
    }


    public function updateSchedule(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'hairdresser_id' => 'required|integer|exists:hairdressers,id',
            'service_id' => 'required|integer|exists:services,id',
            'location_id' => 'required|integer|exists:locations,id',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
        ]);
        try {
            $availableAt = Carbon::createFromFormat('Y-m-d H:i', $validated['date'] . ' ' . $validated['time'])->format('Y-m-d H:i:s');
            $hairdresser = Hairdresser::with(['services', 'locations'])->find($validated['hairdresser_id']);
            if (!$hairdresser || !$hairdresser->services->contains($validated['service_id'])) {
                return back()->withInput()->with('error', 'Hairdresser ini tidak menyediakan layanan yang dipilih.');
            }
            if (!$hairdresser->locations->contains($validated['location_id'])) {
                return back()->withInput()->with('error', 'Hairdresser ini tidak bertugas di lokasi yang dipilih.');
            }
            $existingSchedule = Schedule::where('hairdresser_id', $validated['hairdresser_id'])
                ->where('service_id', $validated['service_id'])
                ->where('location_id', $validated['location_id'])
                ->where('available_at', $availableAt)
                ->where('id', '!=', $schedule->id)->first();
            if ($existingSchedule) {
                return back()->withInput()->with('error', 'Jadwal identik sudah ada.');
            }
            $schedule->update([
                'hairdresser_id' => $validated['hairdresser_id'],
                'service_id' => $validated['service_id'],
                'location_id' => $validated['location_id'],
                'available_at' => $availableAt,
            ]);
            return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Error updating schedule {$schedule->id}: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui jadwal. ' . $e->getMessage());
        }
    }

    public function destroySchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        try {
            $schedule->delete();
            return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error("Error deleting schedule {$id}: " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus jadwal.');
        }
    }

    // --- Testimonials ---
    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|string|max:100',
            'content' => 'required|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp'
        ]);

        $imagePath = $request->file('image')->store('testimonials', 'public');

        Testimonial::create([
            'name' => $request->name,
            'role' => $request->role,
            'content' => $request->content,
            'image_path' => $imagePath
        ]);

        return back()->with('success', 'Testimonial berhasil ditambahkan!');
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        Storage::disk('public')->delete($testimonial->image_path);
        $testimonial->delete();

        return back()->with('success', 'Testimonial berhasil dihapus!');
    }

    public function import(Request $request)
    {
        // 1. Validasi file yang diunggah
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv', // Hanya terima file Excel atau CSV
        ]);

        try {
            // 2. Buat instance dari class SchedulesImport Anda
            $import = new SchedulesImport();

            // 3. Panggil metode import dari Laravel Excel
            // Ini akan memicu metode `collection()` dan `registerEvents()` di dalam SchedulesImport
            Excel::import($import, $request->file('file'));

            // 4. Kumpulkan pesan feedback dari hasil proses import
            $messages = [];
            $hasErrorsOrWarnings = false;

            if ($import->createdSchedules > 0) {
                $messages[] = $import->createdSchedules . ' entri jadwal berhasil dibuat.';
            }

            // Cek dan tambahkan pesan untuk lokasi yang tidak ditemukan
            if (!empty($import->notFoundLocations)) {
                $hasErrorsOrWarnings = true;
                foreach ($import->notFoundLocations as $name => $count) {
                    $messages[] = "Lokasi '{$name}' dari nama sheet tidak ditemukan ({$count}x).";
                }
            }
            // Cek dan tambahkan pesan untuk hairdresser yang tidak ditemukan
            if (!empty($import->notFoundHairdressers)) {
                $hasErrorsOrWarnings = true;
                foreach ($import->notFoundHairdressers as $name => $count) {
                    $messages[] = "Hairdresser '{$name}' dari nama sheet tidak ditemukan ({$count}x).";
                }
            }
            // Cek dan tambahkan pesan untuk layanan yang tidak ditemukan
            if (!empty($import->notFoundServices)) {
                $hasErrorsOrWarnings = true;
                foreach ($import->notFoundServices as $error) {
                    $messages[] = "Layanan '{$error['service_name']}' tidak ditemukan (Sheet: {$error['sheet']}, Baris: {$error['row']}).";
                }
            }
            // Cek dan tambahkan pesan untuk jadwal duplikat
            if (!empty($import->duplicateSchedules)) {
                $hasErrorsOrWarnings = true;
                foreach ($import->duplicateSchedules as $dup) {
                    $messages[] = "Jadwal duplikat dilewati (Sheet: {$dup['sheet']}, Baris: {$dup['row']}, Detail: {$dup['details']}).";
                }
            }
            // Cek dan tambahkan pesan untuk asosiasi yang tidak valid
            if (!empty($import->invalidAssociations)) {
                $hasErrorsOrWarnings = true;
                foreach ($import->invalidAssociations as $error) {
                    $messages[] = "Asosiasi tidak valid (Sheet: {$error['sheet']}, Baris: {$error['row']}): {$error['reason']}";
                }
            }
            // Cek dan tambahkan pesan untuk format data yang tidak valid
            if (!empty($import->invalidDataFormat)) {
                $hasErrorsOrWarnings = true;
                foreach ($import->invalidDataFormat as $error) {
                    $reason = is_array($error['errors']) ? implode(', ', $error['errors']) : $error['errors'];
                    $details = isset($error['details']) ? " ({$error['details']})" : "";
                    $messages[] = "Format data tidak valid (Sheet: {$error['sheet']}, Baris: {$error['row']}$details): " . $reason;
                }
            }

            // Pesan untuk entri yang dilewati secara umum
            if ($import->skippedEntries > 0) {
                $messages[] = $import->skippedEntries . ' entri jadwal individual dilewati karena error atau duplikasi.';
            }

            // Jika tidak ada yang diproses sama sekali
            if ($import->createdSchedules === 0 && $import->skippedEntries === 0 && empty($messages)) {
                return redirect()->route('schedules.index')->with('warning', 'Tidak ada data yang diproses dari file Excel. Pastikan format file dan nama sheet sudah benar, dan ada data jadwal di dalamnya.');
            }

            // Tentukan tipe pesan akhir (success, warning, atau error)
            $messageType = 'success';
            $messageTitle = "Proses import selesai!";
            if ($hasErrorsOrWarnings || $import->skippedEntries > 0) {
                $messageType = 'warning';
                $messageTitle = "Proses import selesai dengan beberapa catatan:";
            }
            if ($import->createdSchedules === 0 && $import->skippedEntries > 0) { // Jika tidak ada yang berhasil tapi ada yang error
                $messageType = 'error';
                $messageTitle = "Proses import gagal membuat jadwal baru, periksa catatan berikut:";
            }

            // Redirect kembali dengan pesan feedback
            return redirect()->route('schedules.index')->with($messageType, $messageTitle . " " . implode('<br>', $messages));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Tangani error validasi dari Laravel Excel (jika Anda menggunakan WithValidation concern)
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris " . $failure->row() . ": " . implode(', ', $failure->errors()) . " (Nilai: " . print_r($failure->values(), true) . ")";
            }
            Log::error('Excel ValidationException during import: ', $failures);
            return redirect()->route('schedules.index')->with('error', 'Error validasi saat import: <br>' . implode('<br>', $errorMessages));
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            Log::error('General error during schedule import: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return redirect()->route('schedules.index')->with('error', 'Terjadi kesalahan umum saat mengimpor jadwal. Silakan cek log untuk detail. Pesan: ' . $e->getMessage());
        }
    }

    // --- Hairdresser CRUD ---
    public function storeHairdresser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:hairdressers,name',
            'location_ids' => 'nullable|array',
            'location_ids.*' => 'integer|exists:locations,id',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'integer|exists:services,id',
        ]);
        try {
            $hairdresser = Hairdresser::create(['name' => $validated['name']]);
            if (!empty($validated['location_ids'])) {
                $hairdresser->locations()->sync($validated['location_ids']);
            }
            if (!empty($validated['service_ids'])) {
                $hairdresser->services()->sync($validated['service_ids']);
            }
            return redirect()->route('schedules.index')->with('success', 'Hairdresser berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storing hairdresser: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan hairdresser. ' . $e->getMessage());
        }
    }

    public function updateHairdresser(Request $request, Hairdresser $hairdresser)
    {
        $validated = $request->validate(['name' => 'required|string|max:255|unique:hairdressers,name,' . $hairdresser->id]);
        try {
            $hairdresser->update($validated);
            return redirect()->route('schedules.index', $hairdresser->id)->with('success', 'Nama hairdresser berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Error updating hairdresser name {$hairdresser->id}: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui nama hairdresser.');
        }
    }

    public function updateHairdresserLocations(Request $request, Hairdresser $hairdresser)
    {
        $validated = $request->validate(['location_ids' => 'nullable|array', 'location_ids.*' => 'integer|exists:locations,id']);
        try {
            $hairdresser->locations()->sync($validated['location_ids'] ?? []);
            return redirect()->route('schedules.index', $hairdresser->id)->with('success', 'Lokasi hairdresser berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Error updating locations for hairdresser {$hairdresser->id}: " . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui lokasi hairdresser.');
        }
    }

    public function updateHairdresserServices(Request $request, Hairdresser $hairdresser)
    {
        $validated = $request->validate(['service_ids' => 'nullable|array', 'service_ids.*' => 'integer|exists:services,id']);
        try {
            $hairdresser->services()->sync($validated['service_ids'] ?? []);
            return redirect()->route('schedules.index', $hairdresser->id)->with('success', 'Layanan hairdresser berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Error updating services for hairdresser {$hairdresser->id}: " . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui layanan hairdresser.');
        }
    }

    public function destroyHairdresser(Hairdresser $hairdresser)
    {
        try {
            $hairdresser->delete(); // onDelete('cascade') akan menangani jadwal terkait
            return redirect()->route('schedules.index')->with('success', 'Hairdresser berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Error deleting hairdresser {$hairdresser->id}: " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus hairdresser.');
        }
    }

    public function getHairdresserDetails(Hairdresser $hairdresser)
    {
        try {
            $hairdresser->load(['services:id,name', 'locations:id,name']);
            $services = $hairdresser->services()->orderBy('name')->get(['services.id', 'services.name']);
            $locations = $hairdresser->locations()->orderBy('name')->get(['locations.id', 'locations.name']);
            return response()->json(['services' => $services, 'locations' => $locations]);
        } catch (\Exception $e) {
            Log::error("Error fetching details for hairdresser {$hairdresser->id}: " . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil detail hairdresser.'], 500);
        }
    }
}
