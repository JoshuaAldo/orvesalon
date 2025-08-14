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
use Maatwebsite\Excel\Facades\Excel;

class BookingSettingsController extends Controller
{
    // public function index()
    // {
    //     $services = Service::all();
    //     $schedules = Schedule::orderBy('available_at')->get();
    //     $locations = Location::all();
    //     $testimonials = Testimonial::latest()->get();
    //     $editingSchedule = null;

    //     return view('admin.booking-settings.index', compact('services', 'schedules', 'locations', 'testimonials', 'editingSchedule'));
    // }

    public function index(Request $request)
    {
        $services = Service::all();
        $locations = Location::all();
        $testimonials = Testimonial::latest()->get();
        $editingSchedule = null;

        // Ambil schedules berdasarkan location_id dan paginasi
        $locationId = $request->input('location_id');
        $schedulesQuery = Schedule::orderBy('available_at');

        if ($locationId) {
            $schedulesQuery->where('location_id', $locationId);
        }

        $schedules = $schedulesQuery->get();

        return view('admin.booking-settings.index', compact(
            'services',
            'schedules',
            'locations',
            'testimonials',
            'editingSchedule',
            'locationId' // buat referensi filter di blade
        ));
    }

    public function storeLocation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Location::create(['name' => $request->name]);

        return redirect()->route('admin.schedules.index')->with('success', 'Lokasi berhasil ditambahkan!');
    }

    public function destroyLocation($id)
    {
        $location = Location::findOrFail($id);

        // Optional: Cek jika lokasi punya booking/schedule terkait sebelum hapus
        if ($location->schedules()->exists()) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus lokasi yang sudah memiliki jadwal.']);
        }

        $location->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Lokasi berhasil dihapus!');
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'available_at' => 'required|date',
            'location_id' => 'required|exists:locations,id',
            'available_hairdressers' => 'required|integer|min:1',
        ]);

        Schedule::create([
            'available_at' => $request->available_at,
            'location_id' => $request->location_id,
            'available_hairdressers' => $request->available_hairdressers,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function destroySchedule($id)
    {
        Schedule::destroy($id);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dihapus!');
    }

    public function updateSchedule(Request $request, Schedule $schedule)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'available_at' => 'required|date',
            'available_hairdressers' => 'required|integer|min:0',
        ]);

        // Langsung update model yang sudah didapat dari route model binding
        $schedule->update($validated);

        // Redirect balik dengan pesan sukses
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function storeService(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'promo_price' => 'nullable|numeric|min:0|lt:price', // promo_price harus lebih kecil dari price jika ada
        ]);

        // Menyimpan layanan
        Service::create($request->only('name', 'price', 'promo_price'));

        return redirect()->route('admin.schedules.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function destroyService($id)
    {
        Service::destroy($id);

        return redirect()->route('admin.schedules.index')->with('success', 'Layanan berhasil dihapus!');
    }


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
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new SchedulesImport();
        Excel::import($import, $request->file('file'));

        $messages = [];

        // Handle lokasi tidak ditemukan
        if (count($import->notFoundLocations) > 0) {
            $messages[] = 'Lokasi tidak ditemukan: ' . implode(', ', array_unique($import->notFoundLocations));
        }

        // Handle jadwal duplikat
        if (count($import->duplicateSchedules) > 0) {
            $duplicates = array_map(function ($item) {
                return $item['date'] . ' - ' . $item['location'];
            }, $import->duplicateSchedules);

            $messages[] = 'Jadwal duplikat ditemukan dan di-skip: ' . implode('; ', array_unique($duplicates));
        }

        $redirect = redirect()->route('admin.schedules.index');

        if (empty($messages)) {
            return $redirect->with('success', 'Jadwal berhasil diimpor tanpa duplikat!');
        }

        return $redirect->with('warning', implode('<br>', $messages));
    }
}
