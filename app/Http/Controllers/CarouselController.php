<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Carousel;
use App\Models\CarouselSecond;
use App\Models\homecareCarouselImage;
use App\Models\HomecareCarouselSecond;
use App\Models\Partnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class CarouselController extends Controller
{
    public function showHome()
    {
        // Ambil semua data carousel pertama
        $carousels = Carousel::all();
        // Ambil semua data carousel kedua
        $carouselsSecond = CarouselSecond::all();

        // Kirim data ke view home.blade.php
        return view('home', compact('carousels', 'carouselsSecond'));
    }

    public function showHomeTemp()
    {
        // Ambil semua data carousel pertama
        $carousels = Carousel::all();
        // Ambil semua data carousel kedua
        $carouselsSecond = CarouselSecond::all();

        // Kirim data ke view home.blade.php
        return view('homeClose', compact('carousels', 'carouselsSecond'));
    }

    public function showHomecare()
    {
        // Ambil semua data carousel pertama
        $carousels = homecareCarouselImage::all();
        // Ambil semua data carousel kedua
        $carouselsSecond = HomecareCarouselSecond::all();

        // Kirim data ke view home.blade.php
        return view('homecare', compact('carousels', 'carouselsSecond'));
    }


    public function index()
    {
        // Ambil semua data carousel pertama
        $carousels = Carousel::all();
        // Ambil semua data carousel kedua
        $carouselsSecond = CarouselSecond::all();

        // Ambil semua data carousel pertama
        $homecareCarousels = homecareCarouselImage::all();
        // Ambil semua data carousel kedua
        $homecareCarouselsSecond = HomecareCarouselSecond::all();

        //Banner
        $banners = Banner::latest()->get();

        //Partnership
        $partners = Partnership::latest()->get();

        // Ambil satu data pertama untuk diedit carousel pertama
        $carousel = Carousel::first();
        $carouselSecond = CarouselSecond::first(); // Ambil satu data pertama untuk carousel kedua
        // Ambil satu data pertama untuk diedit carousel pertama
        $homecareCarousel = homecareCarouselImage::first();
        $homecareCarouselSecond = HomecareCarouselSecond::first(); // Ambil satu data pertama untuk carousel kedua


        return view('carousel.index', compact('carousels', 'carousel', 'carouselsSecond', 'carouselSecond', 'homecareCarousels', 'homecareCarousel', 'homecareCarouselsSecond', 'homecareCarouselSecond', 'banners', 'partners'));
    }

    public function store(Request $request)
    {
        // Validasi input untuk carousel pertama
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'title' => 'required|string|max:255',
        ]);

        // Menyimpan data untuk carousel pertama
        $carousel = new Carousel();
        // if ($request->hasFile('image')) {
        //     $path = $request->file('image')->store('carousel_images', 'public');
        //     $carousel->image = $path;
        // }
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Buat instance manager dengan driver 'gd'
            $manager = new ImageManager(new GdDriver());

            // Resize / compress image
            $resizedImage = $manager->read($image)->scaleDown(1200); // max width 1200px

            $filename = $image->hashName('carousel_images');
            $path = storage_path("app/public/" . $filename);

            $resizedImage->save($path);

            $carousel->image = $filename;
        }
        $carousel->title = $request->title;
        $carousel->save();

        return redirect()->route('carousel.index')->with('success', 'Gambar berhasil ditambahkan.');
    }

    // Menambahkan store untuk carousel kedua
    public function storeCarouselSecond(Request $request)
    {
        // Validasi input untuk carousel kedua
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // Menyimpan data untuk carousel kedua
        $carouselSecond = new CarouselSecond();
        // if ($request->hasFile('image')) {
        //     $path = $request->file('image')->store('carousel_second_images', 'public');
        //     $carouselSecond->image = $path;
        // }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Buat instance manager dengan driver 'gd'
            $manager = new ImageManager(new GdDriver());

            // Resize / compress image
            $resizedImage = $manager->read($image)->scaleDown(1200); // max width 1200px

            $filename = $image->hashName('carousel_second_images');
            $path = storage_path("app/public/" . $filename);

            $resizedImage->save($path);

            $carouselSecond->image = $filename;
        }
        $carouselSecond->title = $request->title;
        $carouselSecond->description = $request->description;
        $carouselSecond->save();

        return redirect()->route('carousel.index')->with('success', 'Gambar carousel kedua berhasil ditambahkan.');
    }

    public function storeHomeCare(Request $request)
    {
        // Validasi input untuk carousel pertama
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'title' => 'required|string|max:255',
        ]);

        // Menyimpan data untuk carousel pertama
        $carousel = new homecareCarouselImage();
        // if ($request->hasFile('image')) {
        //     $path = $request->file('image')->store('homecare_carousel_images', 'public');
        //     $carousel->image = $path;
        // }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Buat instance manager dengan driver 'gd'
            $manager = new ImageManager(new GdDriver());

            // Resize / compress image
            $resizedImage = $manager->read($image)->scaleDown(1200); // max width 1200px

            $filename = $image->hashName('homecare_carousel_images');
            $path = storage_path("app/public/" . $filename);

            $resizedImage->save($path);

            $carousel->image = $filename;
        }
        $carousel->title = $request->title;
        $carousel->save();

        return redirect()->route('carousel.index')->with('success', 'Gambar homecare berhasil ditambahkan.');
    }

    public function storeSecondHomeCare(Request $request)
    {
        // Validasi input untuk carousel pertama
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'title' => 'required|string|max:255',
            'testimoni' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        // Menyimpan data untuk carousel pertama
        $carousel = new HomecareCarouselSecond();
        // if ($request->hasFile('image')) {
        //     $path = $request->file('image')->store('homecare_second_carousel_images', 'public');
        //     $carousel->image = $path;
        // }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Buat instance manager dengan driver 'gd'
            $manager = new ImageManager(new GdDriver());

            // Resize / compress image
            $resizedImage = $manager->read($image)->scaleDown(1200); // max width 1200px

            $filename = $image->hashName('homecare_second_carousel_images');
            $path = storage_path("app/public/" . $filename);

            $resizedImage->save($path);

            $carousel->image = $filename;
        }
        $carousel->title = $request->title;
        $carousel->testimoni = $request->testimoni;
        $carousel->nama = $request->nama;
        $carousel->lokasi_tinggal = $request->lokasi;
        $carousel->save();

        return redirect()->route('carousel.index')->with('success', 'Gambar Homecare kedua berhasil ditambahkan.');
    }

    // Update method untuk carousel pertama
    public function update(Request $request, $id)
    {
        $carousel = Carousel::findOrFail($id);

        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

        // Update title
        $carousel->title = $request->title;

        // Update image jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($carousel->image && Storage::disk('public')->exists($carousel->image)) {
                Storage::disk('public')->delete($carousel->image);
            }

            // Simpan gambar baru di folder public
            $image = $request->file('image');

            // Gunakan ImageManager dan driver GD
            $manager = new ImageManager(new GdDriver());

            // Resize / compress image
            $resizedImage = $manager->read($image)->scaleDown(1200); // Resize kalau lebih dari 1200px

            $filename = $image->hashName('carousel_images');
            $path = storage_path("app/public/" . $filename);

            // Simpan hasil kompresi ke storage
            $resizedImage->save($path);

            // Simpan path ke database
            $carousel->image = $filename;
        }

        $carousel->save();

        return redirect()->route('carousel.index')->with('success', 'Gambar berhasil diperbarui.');
    }

    // Update method untuk carousel kedua
    public function updateCarouselSecond(Request $request, $id)
    {
        $carouselSecond = CarouselSecond::findOrFail($id);

        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

        // Update title
        $carouselSecond->title = $request->title;
        $carouselSecond->description = $request->description;

        // Update image jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($carouselSecond->image && Storage::disk('public')->exists($carouselSecond->image)) {
                Storage::disk('public')->delete($carouselSecond->image);
            }

            // Simpan gambar baru
            $image = $request->file('image');

            // Gunakan ImageManager dan driver GD
            $manager = new ImageManager(new GdDriver());

            // Resize / compress image
            $resizedImage = $manager->read($image)->scaleDown(1200); // Resize kalau lebih dari 1200px

            $filename = $image->hashName('carousel_second_images');
            $path = storage_path("app/public/" . $filename);

            // Simpan hasil kompresi ke storage
            $resizedImage->save($path);

            // Simpan path ke database
            $carouselSecond->image = $filename;
        }

        $carouselSecond->save();

        return redirect()->route('carousel.index')->with('success', 'Gambar carousel kedua berhasil diperbarui.');
    }

    // Update method untuk homecare carousel pertama
    public function updateHomecare(Request $request, $id)
    {
        $carousel = homecareCarouselImage::findOrFail($id);

        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

        // Update title
        $carousel->title = $request->title;

        // Update image jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($carousel->image && Storage::disk('public')->exists($carousel->image)) {
                Storage::disk('public')->delete($carousel->image);
            }

            // Simpan gambar baru di folder public
            $image = $request->file('image');

            // Gunakan ImageManager dan driver GD
            $manager = new ImageManager(new GdDriver());

            // Resize / compress image
            $resizedImage = $manager->read($image)->scaleDown(1200); // Resize kalau lebih dari 1200px

            $filename = $image->hashName('homecare_carousel_images');
            $path = storage_path("app/public/" . $filename);

            // Simpan hasil kompresi ke storage
            $resizedImage->save($path);

            // Simpan path ke database
            $carousel->image = $filename;
        }

        $carousel->save();

        return redirect()->route('carousel.index')->with('success', 'Gambar berhasil diperbarui.');
    }

    public function updateSecondHomecare(Request $request, $id)
    {
        $carousel = HomecareCarouselSecond::findOrFail($id);

        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image',
            'testimoni' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        // Update title
        $carousel->title = $request->title;
        $carousel->testimoni = $request->testimoni;
        $carousel->nama = $request->nama;
        $carousel->lokasi_tinggal = $request->lokasi;

        // Update image jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($carousel->image && Storage::disk('public')->exists($carousel->image)) {
                Storage::disk('public')->delete($carousel->image);
            }

            // Simpan gambar baru di folder public
            $image = $request->file('image');

            // Gunakan ImageManager dan driver GD
            $manager = new ImageManager(new GdDriver());

            // Resize / compress image
            $resizedImage = $manager->read($image)->scaleDown(1200); // Resize kalau lebih dari 1200px

            $filename = $image->hashName('homecare_second_carousel_images');
            $path = storage_path("app/public/" . $filename);

            // Simpan hasil kompresi ke storage
            $resizedImage->save($path);

            // Simpan path ke database
            $carousel->image = $filename;
        }

        $carousel->save();

        return redirect()->route('carousel.index')->with('success', 'Gambar berhasil diperbarui.');
    }

    // Menghapus gambar carousel pertama
    public function destroy(Carousel $carousel)
    {

        // Hapus file gambar dari storage jika ada
        if ($carousel->image) {
            Storage::disk('public')->delete($carousel->image);
        }

        // Hapus data dari database
        $carousel->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }

    // Menghapus gambar carousel kedua
    public function destroyCarouselSecond(CarouselSecond $carouselSecond)
    {
        // Hapus file gambar dari storage jika ada
        if ($carouselSecond->image) {
            Storage::disk('public')->delete($carouselSecond->image);
        }

        // Hapus data dari database
        $carouselSecond->delete();

        return redirect()->back()->with('success', 'Gambar carousel kedua berhasil dihapus.');
    }

    public function destroyHomeCare(homecareCarouselImage $homeCareCarousel)
    {

        // Hapus file gambar dari storage jika ada
        if ($homeCareCarousel->image) {
            Storage::disk('public')->delete($homeCareCarousel->image);
        }

        // Hapus data dari database
        $homeCareCarousel->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }

    public function destroySecondHomeCare(HomecareCarouselSecond $homeCareSecondCarousel)
    {
        // Hapus file gambar dari storage jika ada
        if ($homeCareSecondCarousel->image) {
            Storage::disk('public')->delete($homeCareSecondCarousel->image);
        }

        // Hapus data dari database
        $homeCareSecondCarousel->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }


    //Banner
    public function storeBanner(Request $request)
    {
        $request->validate([
            'desktop_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'mobile_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'alt_text' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean'
        ]);

        $desktopPath = $request->file('desktop_image')->store('banners/desktop', 'public');
        $mobilePath = $request->file('mobile_image')->store('banners/mobile', 'public');

        $bannerData = [
            'desktop_image_path' => $desktopPath,
            'mobile_image_path' => $mobilePath,
            'alt_text' => $request->alt_text,
            'is_active' => $request->boolean('is_active')
        ];

        // The booted() method in model will handle deactivating others
        Banner::create($bannerData);

        return redirect()->route('carousel.index')->with('success', 'Banner added successfully.');
    }

    public function updateBanner(Request $request, Banner $banner)
    {
        $request->validate([
            'desktop_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'mobile_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'alt_text' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean'
        ]);

        $updateData = [
            'alt_text' => $request->alt_text,
            'is_active' => $request->boolean('is_active')
        ];

        if ($request->hasFile('desktop_image')) {
            Storage::disk('public')->delete($banner->desktop_image_path);
            $updateData['desktop_image_path'] = $request->file('desktop_image')
                ->store('banners/desktop', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            Storage::disk('public')->delete($banner->mobile_image_path);
            $updateData['mobile_image_path'] = $request->file('mobile_image')
                ->store('banners/mobile', 'public');
        }

        $banner->update($updateData);

        return redirect()->route('carousel.index')->with('success', 'Banner updated successfully.');
    }

    public function destroyBanner(Banner $banner)
    {
        $banner->deleteWithFile();
        return redirect()->route('carousel.index')->with('success', 'Banner deleted successfully.');
    }

    public function setActiveBanner(Banner $banner)
    {
        Banner::query()->update(['is_active' => false]);
        $banner->update(['is_active' => true]);

        return back()->with('success', 'Banner activated successfully.');
    }



    //Partnership
    public function storePartner(Request $request)
    {
        $request->validate([
            'desktop_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'mobile_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'alt_text' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean'
        ]);

        $desktopPath = $request->file('desktop_image')->store('partnership/desktop', 'public');
        $mobilePath = $request->file('mobile_image')->store('partnership/mobile', 'public');

        $partnershipData = [
            'desktop_image_path' => $desktopPath,
            'mobile_image_path' => $mobilePath,
            'alt_text' => $request->alt_text,
            'is_active' => $request->boolean('is_active')
        ];

        if ($partnershipData['is_active']) {
            Partnership::query()->update(['is_active' => false]);
        }

        Partnership::create($partnershipData);

        return redirect()->route('carousel.index')->with('success', 'Partnership added successfully.');
    }

    public function updatePartner(Request $request, Partnership $partner)
    {
        $request->validate([
            'desktop_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'mobile_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'alt_text' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean'
        ]);

        // Prepare update data
        $updateData = [
            'alt_text' => $request->alt_text,
            'is_active' => $request->boolean('is_active') // Use boolean() to properly convert checkbox value
        ];

        if ($request->hasFile('desktop_image')) {
            Storage::disk('public')->delete($partner->desktop_image_path);
            $updateData['desktop_image_path'] = $request->file('desktop_image')
                ->store('partnership/desktop', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            Storage::disk('public')->delete($partner->mobile_image_path);
            $updateData['mobile_image_path'] = $request->file('mobile_image')
                ->store('partnership/mobile', 'public');
        }

        // Update the partnership
        $partner->update($updateData);

        // If this partnership was set as active, deactivate others
        if ($request->boolean('is_active')) {
            Partnership::where('id', '!=', $partner->id)->update(['is_active' => false]);
        }

        return redirect()->route('carousel.index')->with('success', 'Partnership updated successfully.');
    }

    public function destroyPartner(Partnership $partner)
    {
        $partner->deleteWithFile();
        return redirect()->route('carousel.index')->with('success', 'Partnership deleted successfully.');
    }

    public function setActivePartner(Partnership $partner)
    {
        Partnership::query()->update(['is_active' => false]);
        $partner->update(['is_active' => true]);

        return back()->with('success', 'Partnership activated successfully.');
    }
}
