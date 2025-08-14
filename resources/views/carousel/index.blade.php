<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400..700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&family=Zen+Maru+Gothic:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <link rel="icon" href="{{ asset('Image/Logo New.png') }}" type="image/png">
    <title>Manage Home Content</title>
</head>

<body class="font-elMessiri bg-gray-50">
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                {{-- Logo / Brand --}}
                <div class="flex-shrink-0 flex items-center space-x-2">
                    {{-- Jika Anda punya file logo: --}}
                    {{-- <img class="h-10 w-auto" src="{{ asset('Image/Logo New.png') }}" alt="ORVÉ Salon Logo"> --}}
                    <div class="text-2xl font-bold text-gray-900 tracking-tight">
                        <span class="text-orange-500">ORVÉ</span> Salon
                    </div>
                    <span
                        class="bg-orange-100 text-orange-600 text-xs px-2.5 py-1 rounded-full font-semibold">Admin</span>
                </div>

                {{-- Menu Desktop --}}
                <div class="hidden lg:flex lg:items-center lg:space-x-6">
                    <a href="{{ route('carousel.index') }}"
                        class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('carousel.index') ? 'bg-orange-50 text-orange-600' : 'text-gray-700 hover:bg-gray-100 hover:text-orange-500' }} transition-colors duration-200 relative group">
                        Home Content
                        {{-- Active state underline (optional, as background is also an indicator) --}}
                        {{-- <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full {{ request()->routeIs('carousel.index') ? 'w-full' : '' }}"></span> --}}
                    </a>
                    <a href="{{ route('schedules.index') }}"
                        class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('schedules.index') ? 'bg-orange-50 text-orange-600' : 'text-gray-700 hover:bg-gray-100 hover:text-orange-500' }} transition-colors duration-200 relative group">
                        Booking Settings
                    </a>
                    <a href="{{ route('admin.bookings.paid') }}"
                        class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.bookings.paid') ? 'bg-orange-50 text-orange-600' : 'text-gray-700 hover:bg-gray-100 hover:text-orange-500' }} transition-colors duration-200 relative group">
                        Booking Lunas
                    </a>
                    <a href="/homecare" {{-- Asumsi ini adalah route atau link yang valid --}}
                        class="px-3 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100 hover:text-orange-500 transition-colors duration-200 relative group">
                        Homecare
                    </a>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center space-x-1.5 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors duration-200 shadow-sm text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>

                {{-- Tombol Hamburger Menu Mobile --}}
                <div class="lg:hidden flex items-center">
                    <button id="mobile-menu-button" type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-orange-500"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Buka menu utama</span>
                        {{-- Ikon hamburger (garis tiga) --}}
                        <svg class="block h-6 w-6" id="icon-open" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        {{-- Ikon close (X) - awalnya tersembunyi --}}
                        <svg class="hidden h-6 w-6" id="icon-close" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Menu Mobile (awalnya tersembunyi) --}}
        <div class="lg:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-gray-200">
                <a href="{{ route('carousel.index') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('carousel.index') ? 'bg-orange-50 text-orange-600' : 'text-gray-700 hover:bg-gray-100 hover:text-orange-500' }} transition-colors duration-200">Home
                    Content</a>
                <a href="{{ route('schedules.index') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('schedules.index') ? 'bg-orange-50 text-orange-600' : 'text-gray-700 hover:bg-gray-100 hover:text-orange-500' }} transition-colors duration-200">Booking
                    Settings</a>
                <a href="{{ route('admin.bookings.paid') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.bookings.paid') ? 'bg-orange-50 text-orange-600' : 'text-gray-700 hover:bg-gray-100 hover:text-orange-500' }} transition-colors duration-200">Booking
                    Lunas</a>
                <a href="/homecare" {{-- Asumsi ini adalah route atau link yang valid --}}
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-orange-500 transition-colors duration-200">Homecare</a>
            </div>
            <div class="pt-3 pb-3 border-t border-gray-200 px-2 sm:px-3">
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center space-x-1.5 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors duration-200 shadow-sm text-base font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto p-4 sm:p-6 mt-8 mb-10 bg-white border border-gray-200 rounded-lg shadow-xl">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Manage Image Halaman Offline Salon</h1>
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 shadow"
                role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('carousel.store') }}" method="POST" enctype="multipart/form-data"
            class="mb-8 p-6 bg-gray-50 rounded-lg shadow-md space-y-4">
            @csrf
            <h2 class="text-xl font-semibold text-gray-700">Manage Image Service 1</h2>
            <div>
                <label for="title_service1" class="block text-sm font-medium text-gray-700 mb-1">Title - service
                    1</label>
                <input type="text" name="title" id="title_service1" required
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div>
                <label for="image_service1" class="block text-sm font-medium text-gray-700 mb-1">Image - service
                    1</label>
                <input type="file" name="image" id="image_service1"
                    class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
            </div>
            <button type="submit"
                class="px-6 py-2.5 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Add
                Image - Service 1</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($carousels as $carousel)
                <div
                    class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-lg p-4 flex flex-col space-y-4">
                    <img src="{{ asset('storage/' . $carousel->image) }}" alt="{{ $carousel->title }}"
                        class="h-56 w-full object-cover rounded-lg">

                    <form action="{{ route('carousel.update', $carousel->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="title_update_{{ $carousel->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Edit Title</label>
                            <input type="text" name="title" id="title_update_{{ $carousel->id }}"
                                value="{{ $carousel->title }}"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="image_update_{{ $carousel->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Change Image</label>
                            <input type="file" name="image" id="image_update_{{ $carousel->id }}"
                                class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                        <button type="submit"
                            class="w-full px-4 py-2 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Update</button>
                    </form>

                    <form action="{{ route('carousel.destroy', $carousel->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-500 text-white px-4 py-2 font-semibold rounded-lg hover:bg-red-700 transition duration-200 transform hover:scale-95 shadow-md">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
        <div class="border-t border-gray-300 my-10"></div>

        <form action="{{ route('carousel.storeCarouselSecond') }}" method="POST" enctype="multipart/form-data"
            class="mb-8 p-6 bg-gray-50 rounded-lg shadow-md space-y-4">
            @csrf
            <h2 class="text-xl font-semibold text-gray-700">Manage Image Service 2</h2>
            <div>
                <label for="title_service2" class="block text-sm font-medium text-gray-700 mb-1">Title - Service
                    2</label>
                <input type="text" name="title" id="title_service2" required
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div>
                <label for="description_service2" class="block text-sm font-medium text-gray-700 mb-1">Description -
                    Service 2</label>
                <input type="text" name="description" id="description_service2" required
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div>
                <label for="image_service2" class="block text-sm font-medium text-gray-700 mb-1">Image - Service
                    2</label>
                <input type="file" name="image" id="image_service2"
                    class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
            </div>
            <button type="submit"
                class="px-6 py-2.5 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Add
                Image - Service 2</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($carouselsSecond as $carouselSecond)
                <div
                    class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-lg p-4 flex flex-col space-y-4">
                    <img src="{{ asset('storage/' . $carouselSecond->image) }}" alt="{{ $carouselSecond->title }}"
                        class="h-56 w-full object-cover rounded-lg">

                    <form action="{{ route('carousel.updateCarouselSecond', $carouselSecond->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="title_update_s2_{{ $carouselSecond->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Edit Title - Service 2</label>
                            <input type="text" name="title" id="title_update_s2_{{ $carouselSecond->id }}"
                                value="{{ $carouselSecond->title }}"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="desc_update_s2_{{ $carouselSecond->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Edit Description - Service
                                2</label>
                            <input type="text" name="description" id="desc_update_s2_{{ $carouselSecond->id }}"
                                value="{{ $carouselSecond->description }}"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="image_update_s2_{{ $carouselSecond->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Change Image</label>
                            <input type="file" name="image" id="image_update_s2_{{ $carouselSecond->id }}"
                                class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                        <button type="submit"
                            class="w-full px-4 py-2 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Update</button>
                    </form>

                    <form action="{{ route('carousel.destroyCarouselSecond', $carouselSecond->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-500 text-white px-4 py-2 font-semibold rounded-lg hover:bg-red-700 transition duration-200 transform hover:scale-95 shadow-md">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <div class="max-w-5xl mx-auto p-4 sm:p-6 mt-8 mb-10 bg-white border border-gray-200 rounded-lg shadow-xl">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Manage Image Halaman Homecare Salon</h1>
        <form action="{{ route('carousel.storeHomecare') }}" method="POST" enctype="multipart/form-data"
            class="mb-8 p-6 bg-gray-50 rounded-lg shadow-md space-y-4">
            @csrf
            <h2 class="text-xl font-semibold text-gray-700">Manage Hairdresser</h2>
            <div>
                <label for="title_hairdresser" class="block text-sm font-medium text-gray-700 mb-1">Title
                    (Hairdresser)</label>
                <input type="text" name="title" id="title_hairdresser" required
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div>
                <label for="image_hairdresser" class="block text-sm font-medium text-gray-700 mb-1">Image -
                    Hairdresser</label>
                <input type="file" name="image" id="image_hairdresser"
                    class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
            </div>
            <button type="submit"
                class="px-6 py-2.5 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Add
                Image - Hairdresser</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($homecareCarousels as $homecareCarousel)
                <div
                    class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-lg p-4 flex flex-col space-y-4">
                    <img src="{{ asset('storage/' . $homecareCarousel->image) }}"
                        alt="{{ $homecareCarousel->title }}" class="h-56 w-full object-cover rounded-lg">

                    <form action="{{ route('carousel.homeCareUpdate', $homecareCarousel->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="title_update_hc1_{{ $homecareCarousel->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Edit Title - Hairdresser</label>
                            <input type="text" name="title" id="title_update_hc1_{{ $homecareCarousel->id }}"
                                value="{{ $homecareCarousel->title }}"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="image_update_hc1_{{ $homecareCarousel->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Change Image</label>
                            <input type="file" name="image" id="image_update_hc1_{{ $homecareCarousel->id }}"
                                class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                        <button type="submit"
                            class="w-full px-4 py-2 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Update</button>
                    </form>

                    <form action="{{ route('carousel.homeCareDestroy', $homecareCarousel->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-500 text-white px-4 py-2 font-semibold rounded-lg hover:bg-red-700 transition duration-200 transform hover:scale-95 shadow-md">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="border-t border-gray-300 my-10"></div>
        <form action="{{ route('carousel.storeSecondHomeCare') }}" method="POST" enctype="multipart/form-data"
            class="mb-8 p-6 bg-gray-50 rounded-lg shadow-md space-y-4">
            @csrf
            <h2 class="text-xl font-semibold text-gray-700">Manage Testimoni</h2>
            <div>
                <label for="title_testimoni" class="block text-sm font-medium text-gray-700 mb-1">Testimoni
                    Title</label>
                <input type="text" name="title" id="title_testimoni" required
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div>
                <label for="testimoni_text" class="block text-sm font-medium text-gray-700 mb-1">Testimoni</label>
                <input type="text" name="testimoni" id="testimoni_text" required
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div>
                <label for="nama_testimoni" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="nama" id="nama_testimoni" required
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div>
                <label for="lokasi_testimoni"
                    class="block text-sm font-medium text-gray-700 mb-1">Alamat/Lokasi</label>
                <input type="text" name="lokasi" id="lokasi_testimoni" required
                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div>
                <label for="image_testimoni" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                <input type="file" name="image" id="image_testimoni"
                    class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
            </div>
            <button type="submit"
                class="px-6 py-2.5 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Add
                Image Testimoni</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($homecareCarouselsSecond as $homecareCarouselSecond)
                <div
                    class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-lg p-4 flex flex-col space-y-4">
                    <img src="{{ asset('storage/' . $homecareCarouselSecond->image) }}"
                        alt="{{ $homecareCarouselSecond->title }}" class="h-56 w-full object-cover rounded-lg">

                    <form action="{{ route('carousel.updateHomecareCarouselSecond', $homecareCarouselSecond->id) }}"
                        method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="title_update_hc2_{{ $homecareCarouselSecond->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Edit Testimoni Title</label>
                            <input type="text" name="title"
                                id="title_update_hc2_{{ $homecareCarouselSecond->id }}"
                                value="{{ $homecareCarouselSecond->title }}"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="testimoni_update_hc2_{{ $homecareCarouselSecond->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Edit Testimoni</label>
                            <input type="text" name="testimoni"
                                id="testimoni_update_hc2_{{ $homecareCarouselSecond->id }}"
                                value="{{ $homecareCarouselSecond->testimoni }}"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="nama_update_hc2_{{ $homecareCarouselSecond->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Edit Nama</label>
                            <input type="text" name="nama"
                                id="nama_update_hc2_{{ $homecareCarouselSecond->id }}"
                                value="{{ $homecareCarouselSecond->nama }}"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="lokasi_update_hc2_{{ $homecareCarouselSecond->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Edit Lokasi</label>
                            <input type="text" name="lokasi"
                                id="lokasi_update_hc2_{{ $homecareCarouselSecond->id }}"
                                value="{{ $homecareCarouselSecond->lokasi_tinggal }}"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="image_update_hc2_{{ $homecareCarouselSecond->id }}"
                                class="block text-sm font-medium text-gray-700 mb-1">Change Image</label>
                            <input type="file" name="image"
                                id="image_update_hc2_{{ $homecareCarouselSecond->id }}"
                                class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                        <button type="submit"
                            class="w-full px-4 py-2 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Update
                        </button>
                    </form>

                    <form action="{{ route('carousel.destroyHomeCareCarouselSecond', $homecareCarouselSecond->id) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-500 text-white px-4 py-2 font-semibold rounded-lg hover:bg-red-700 transition duration-200 transform hover:scale-95 shadow-md">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="border-t border-gray-300 my-10"></div>
        <div class="space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800">Manage Banner</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($banners as $banner)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-4 space-y-4">
                            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Current Desktop Image</p>
                                    <img src="{{ $banner->desktop_image_url }}"
                                        alt="Desktop Banner - {{ $banner->alt_text }}"
                                        class="w-full sm:w-40 h-auto sm:h-24 object-cover rounded border border-gray-200">
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Current Mobile Image</p>
                                    <img src="{{ $banner->mobile_image_url }}"
                                        alt="Mobile Banner - {{ $banner->alt_text }}"
                                        class="w-24 h-24 object-cover rounded border border-gray-200">
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium">
                                    @if ($banner->is_active)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                                viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Active
                                        </span>
                                    @else
                                        <form action="{{ route('banners.set-active', $banner) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline">Set
                                                Active</button>
                                        </form>
                                    @endif
                                </span>

                                <form action="{{ route('banners.destroy', $banner) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 text-sm font-medium hover:underline"
                                        onclick="return confirm('Are you sure you want to delete this banner?')">Delete</button>
                                </form>
                            </div>

                            <form action="{{ route('banners.update', $banner) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label for="alt_text_banner_{{ $banner->id }}"
                                        class="block text-xs font-medium text-gray-600 mb-0.5">Description</label>
                                    <input type="text" name="alt_text" id="alt_text_banner_{{ $banner->id }}"
                                        value="{{ old('alt_text', $banner->alt_text) }}"
                                        class="w-full p-2 border border-gray-300 rounded-md text-sm shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                </div>
                                <div class="grid grid-cols-1 gap-3">
                                    <div>
                                        <label for="desktop_image_banner_{{ $banner->id }}"
                                            class="block text-xs font-medium text-gray-600 mb-0.5">Change Desktop
                                            Image</label>
                                        <input type="file" name="desktop_image"
                                            id="desktop_image_banner_{{ $banner->id }}"
                                            class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer border border-gray-300 rounded-md p-1.5 focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                                    </div>
                                    <div>
                                        <label for="mobile_image_banner_{{ $banner->id }}"
                                            class="block text-xs font-medium text-gray-600 mb-0.5">Change Mobile
                                            Image</label>
                                        <input type="file" name="mobile_image"
                                            id="mobile_image_banner_{{ $banner->id }}"
                                            class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer border border-gray-300 rounded-md p-1.5 focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                                    </div>
                                </div>
                                <div class="flex items-center pt-1">
                                    <input type="checkbox" id="is_active_banner_{{ $banner->id }}"
                                        name="is_active" value="1" {{ $banner->is_active ? 'checked' : '' }}
                                        class="h-4 w-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500 mr-2">
                                    <label for="is_active_banner_{{ $banner->id }}"
                                        class="text-sm font-medium text-gray-700">Make Active Banner</label>
                                </div>
                                <button type="submit"
                                    class="w-full mt-1 px-4 py-2 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Update
                                    Banner</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Add New Banner</h3>
                <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="desktop_image_new_banner"
                                class="block text-sm font-medium text-gray-700 mb-1">Desktop Image<span
                                    class="text-red-500">*</span></label>
                            <input type="file" name="desktop_image" id="desktop_image_new_banner" required
                                class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                            <p class="text-xs text-gray-500 mt-1">Recommended size: 1200x400px</p>
                        </div>
                        <div>
                            <label for="mobile_image_new_banner"
                                class="block text-sm font-medium text-gray-700 mb-1">Mobile Image<span
                                    class="text-red-500">*</span></label>
                            <input type="file" name="mobile_image" id="mobile_image_new_banner" required
                                class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                            <p class="text-xs text-gray-500 mt-1">Recommended size: 600x600px</p>
                        </div>
                        <div class="md:col-span-2">
                            <label for="alt_text_new_banner"
                                class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <input type="text" name="alt_text" id="alt_text_new_banner"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>

                    <div class="flex items-center pt-2">
                        <input type="checkbox" id="is_active_new_banner_check" name="is_active" value="1"
                            class="h-4 w-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500 mr-2">
                        <label for="is_active_new_banner_check" class="text-sm font-medium text-gray-700">Set as
                            active banner</label>
                    </div>

                    <button type="submit"
                        class="px-6 py-2.5 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Add
                        Banner</button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-300 my-10"></div>
        <div class="space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800">Manage Partnership</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($partners as $partner)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-4 space-y-4">
                            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Current Desktop Image</p>
                                    <img src="{{ $partner->desktop_image_url }}"
                                        alt="Desktop Partner - {{ $partner->alt_text }}"
                                        class="w-full sm:w-40 h-auto sm:h-24 object-cover rounded border border-gray-200">
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Current Mobile Image</p>
                                    <img src="{{ $partner->mobile_image_url }}"
                                        alt="Mobile Partner - {{ $partner->alt_text }}"
                                        class="w-24 h-24 object-cover rounded border border-gray-200">
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium">
                                    @if ($partner->is_active)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                                viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Active
                                        </span>
                                    @else
                                        <form action="{{ route('partners.set-active', $partner) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline">Set
                                                Active</button>
                                        </form>
                                    @endif
                                </span>
                                <form action="{{ route('partners.destroy', $partner) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 text-sm font-medium hover:underline"
                                        onclick="return confirm('Are you sure you want to delete this partnership?')">Delete</button>
                                </form>
                            </div>

                            <form action="{{ route('partners.update', $partner) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label for="alt_text_partner_{{ $partner->id }}"
                                        class="block text-xs font-medium text-gray-600 mb-0.5">Description</label>
                                    <input type="text" name="alt_text" id="alt_text_partner_{{ $partner->id }}"
                                        value="{{ old('alt_text', $partner->alt_text) }}"
                                        class="w-full p-2 border border-gray-300 rounded-md text-sm shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                </div>
                                <div class="grid grid-cols-1 gap-3">
                                    <div>
                                        <label for="desktop_image_partner_{{ $partner->id }}"
                                            class="block text-xs font-medium text-gray-600 mb-0.5">Change Desktop
                                            Image</label>
                                        <input type="file" name="desktop_image"
                                            id="desktop_image_partner_{{ $partner->id }}"
                                            class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer border border-gray-300 rounded-md p-1.5 focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                                    </div>
                                    <div>
                                        <label for="mobile_image_partner_{{ $partner->id }}"
                                            class="block text-xs font-medium text-gray-600 mb-0.5">Change Mobile
                                            Image</label>
                                        <input type="file" name="mobile_image"
                                            id="mobile_image_partner_{{ $partner->id }}"
                                            class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer border border-gray-300 rounded-md p-1.5 focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                                    </div>
                                </div>
                                <div class="flex items-center pt-1">
                                    <input type="checkbox" id="is_active_partner_{{ $partner->id }}"
                                        name="is_active" value="1" {{ $partner->is_active ? 'checked' : '' }}
                                        class="h-4 w-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500 mr-2">
                                    <label for="is_active_partner_{{ $partner->id }}"
                                        class="text-sm font-medium text-gray-700">Make Active Partnership</label>
                                </div>
                                <button type="submit"
                                    class="w-full mt-1 px-4 py-2 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Update
                                    Partnership</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Add New Partnership</h3>
                <form action="{{ route('partners.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="desktop_image_new_partner"
                                class="block text-sm font-medium text-gray-700 mb-1">Desktop Image<span
                                    class="text-red-500">*</span></label>
                            <input type="file" name="desktop_image" id="desktop_image_new_partner" required
                                class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                            <p class="text-xs text-gray-500 mt-1">Recommended size: 1200x400px</p>
                        </div>
                        <div>
                            <label for="mobile_image_new_partner"
                                class="block text-sm font-medium text-gray-700 mb-1">Mobile Image<span
                                    class="text-red-500">*</span></label>
                            <input type="file" name="mobile_image" id="mobile_image_new_partner" required
                                class="w-full p-2.5 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                            <p class="text-xs text-gray-500 mt-1">Recommended size: 600x600px</p>
                        </div>
                        <div class="md:col-span-2">
                            <label for="alt_text_new_partner"
                                class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <input type="text" name="alt_text" id="alt_text_new_partner"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>

                    <div class="flex items-center pt-2">
                        <input type="checkbox" id="is_active_new_partner_check" name="is_active" value="1"
                            class="h-4 w-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500 mr-2">
                        <label for="is_active_new_partner_check" class="text-sm font-medium text-gray-700">Set as
                            active Partnership</label>
                    </div>

                    <button type="submit"
                        class="px-6 py-2.5 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 shadow-md">Add
                        Partnership</button>
                </form>
            </div>
        </div>
    </div>
    <footer class="text-center py-8 text-sm text-gray-500">
        ORVÉ Salon Admin Panel &copy; {{ date('Y') }}
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('icon-open');
            const iconClose = document.getElementById('icon-close');

            if (menuButton && mobileMenu && iconOpen && iconClose) {
                menuButton.addEventListener('click', () => {
                    const isExpanded = menuButton.getAttribute('aria-expanded') === 'true' || false;
                    menuButton.setAttribute('aria-expanded', !isExpanded);
                    mobileMenu.classList.toggle('hidden');
                    iconOpen.classList.toggle('hidden');
                    iconClose.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>

</html>
