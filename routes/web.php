<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BookingSettingsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarouselController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [CarouselController::class, 'showHome'])->name('home');
Route::get('/', [CarouselController::class, 'showHomeTemp'])->name('homeTemp');
Route::get('/homecare', [CarouselController::class, 'showHomecare'])->name('homecare');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/image', [CarouselController::class, 'index'])->name('carousel.index');
    Route::post('/admin/image', [CarouselController::class, 'store'])->name('carousel.store');
    Route::post('/carousel/second', [CarouselController::class, 'storeCarouselSecond'])->name('carousel.storeCarouselSecond');
    Route::put('/carousel/{carousel}', [CarouselController::class, 'update'])->name('carousel.update');
    Route::put('/carousel/second/{carouselSecond}', [CarouselController::class, 'updateCarouselSecond'])->name('carousel.updateCarouselSecond');
    Route::delete('/carousel/{carousel}', [CarouselController::class, 'destroy'])->name('carousel.destroy');
    Route::delete('/carousel/second/{carouselSecond}', [CarouselController::class, 'destroyCarouselSecond'])->name('carousel.destroyCarouselSecond');

    //homecare
    Route::post('/carousel/homecare', [CarouselController::class, 'storeHomeCare'])->name('carousel.storeHomecare');
    Route::post('/carousel/secondHomecare', [CarouselController::class, 'storeSecondHomeCare'])->name('carousel.storeSecondHomeCare');
    Route::put('/carousel/homecare/{carousel}', [CarouselController::class, 'updateHomecare'])->name('carousel.homeCareUpdate');
    Route::put('/carousel/homecare-second/{carouselSecond}', [CarouselController::class, 'updateSecondHomecare'])->name('carousel.updateHomecareCarouselSecond');
    Route::delete('/carousel/homecare/{homeCareCarousel}', [CarouselController::class, 'destroyHomeCare'])->name('carousel.homeCareDestroy');
    Route::delete('/carousel/homecareSecond/{homeCareSecondCarousel}', [CarouselController::class, 'destroySecondHomeCare'])->name('carousel.destroyHomeCareCarouselSecond');


    //banner
    Route::post('/banners', [CarouselController::class, 'storeBanner'])->name('banners.store');
    Route::put('/banners/{banner}', [CarouselController::class, 'updateBanner'])->name('banners.update');
    Route::delete('/banners/{banner}', [CarouselController::class, 'destroyBanner'])->name('banners.destroy');
    Route::post('/banners/{banner}/activate', [CarouselController::class, 'setActiveBanner'])->name('banners.set-active');

    //partnership
    Route::post('/partners', [CarouselController::class, 'storePartner'])->name('partners.store');
    Route::put('/partners/{partner}', [CarouselController::class, 'updatePartner'])->name('partners.update');
    Route::delete('/partners/{partner}', [CarouselController::class, 'destroyPartner'])->name('partners.destroy');
    Route::post('/partners/{partner}/activate', [CarouselController::class, 'setActivePartner'])->name('partners.set-active');

    //admin
    // Admin Booking Settings - Gabungan Jadwal dan Layanan
    // Rute utama untuk pengaturan jadwal (BookingSettingsController@index)
    // Sesuai dengan route Anda: /admin/schedules -> BookingSettingsController@index
    Route::get('/admin/schedules', [BookingSettingsController::class, 'index'])->name('schedules.index');
    // Rute untuk Locations (menggunakan BookingSettingsController)
    Route::post('/admin/locations', [BookingSettingsController::class, 'storeLocation'])->name('locations.store');
    Route::delete('/admin/locations/{id}', [BookingSettingsController::class, 'destroyLocation'])->name('locations.destroy');

    // Jadwal
    Route::post('/admin/schedules', [BookingSettingsController::class, 'storeSchedule'])->name('admin.schedules.store');
    Route::delete('/admin/schedules/{id}', [BookingSettingsController::class, 'destroySchedule'])->name('admin.schedules.destroy');
    Route::put('/admin/schedules/{schedule}', [BookingSettingsController::class, 'updateSchedule'])->name('admin.schedules.update');
    // Rute untuk Import Schedules (menggunakan BookingSettingsController)
    Route::post('/admin/schedules/import', [BookingSettingsController::class, 'import'])->name('schedules.import');

    // Rute untuk Services (menggunakan BookingSettingsController)
    Route::post('/admin/services', [BookingSettingsController::class, 'storeService'])->name('services.store');
    Route::delete('/admin/services/{id}', [BookingSettingsController::class, 'destroyService'])->name('services.destroy');

    // Rute untuk Testimonials (menggunakan BookingSettingsController, nama disesuaikan)
    Route::post('/admin/testimonials', [BookingSettingsController::class, 'storeTestimonial'])->name('testimonial.store'); // Disesuaikan menjadi singular
    Route::delete('/admin/testimonials/{testimonial}', [BookingSettingsController::class, 'destroyTestimonial'])->name('testimonial.destroy'); // Disesuaikan menjadi singular

    // --- RUTE UNTUK HAIRDRESSER (menggunakan BookingSettingsController) ---
    Route::post('/admin/hairdressers', [BookingSettingsController::class, 'storeHairdresser'])->name('hairdressers.store');
    Route::put('/admin/hairdressers/{hairdresser}', [BookingSettingsController::class, 'updateHairdresser'])->name('hairdressers.update');
    Route::put('/admin/hairdressers/{hairdresser}/update-locations', [BookingSettingsController::class, 'updateHairdresserLocations'])->name('hairdressers.updateLocations');
    Route::put('/admin/hairdressers/{hairdresser}/update-services', [BookingSettingsController::class, 'updateHairdresserServices'])->name('hairdressers.updateServices');
    Route::delete('/admin/hairdressers/{hairdresser}', [BookingSettingsController::class, 'destroyHairdresser'])->name('hairdressers.destroy');
    Route::get('hairdressers/{hairdresser}/details', [BookingSettingsController::class, 'getHairdresserDetails'])->name('admin.hairdressers.getDetails');

    //Paid booking
    Route::get('/admin/paid-bookings', [BookingSettingsController::class, 'listPaidBookings'])->name('admin.bookings.paid');
});
//Payment & Booking
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/finish/{uuid}', [BookingController::class, 'finish'])->name('booking.finish');
Route::get('/booking/success/{uuid}', [BookingController::class, 'success'])->name('booking.success');
Route::get('/booking/failed', [BookingController::class, 'failed'])->name('booking.failed');
Route::post('/booking/{bookingId}/generate-payment-token', [BookingController::class, 'generatePaymentToken'])
    ->name('booking.generate-payment-token');

//booking
Route::get('/jadwal/lokasi/{locationId}', [BookingController::class, 'getSchedulesByLocation']);
// Route untuk mengambil data hairdresser berdasarkan service dan lokasi
Route::get('/get-hairdressers-for-booking', [BookingController::class, 'getHairdressers'])
    ->name('hairdressers.getForBooking');

// Route untuk mengambil tanggal yang tersedia berdasarkan hairdresser dan service
Route::get('/get-available-dates', [BookingController::class, 'getAvailableDates'])
    ->name('dates.getAvailable');

// Route untuk mengambil slot waktu yang tersedia berdasarkan hairdresser, service, dan tanggal
Route::get('/get-available-times', [BookingController::class, 'getAvailableTimes'])
    ->name('times.getAvailable');

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('auth.login.view');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// Tambahkan route untuk reset password
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');
