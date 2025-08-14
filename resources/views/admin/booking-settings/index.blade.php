<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- Pastikan Vite terkonfigurasi dengan benar untuk memuat app.css --}}
    {{-- @vite('resources/css/app.css') --}}
    <script src="https://cdn.tailwindcss.com"></script> {{-- Menggunakan CDN Tailwind untuk kemudahan --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400;500;600;700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&family=Zen+Maru+Gothic:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'El Messiri', sans-serif;
            background-color: #f7fafc;
            /* Light gray background */
        }

        .form-section {
            background-color: white;
            padding: 2rem;
            /* Increased padding */
            border-radius: 0.75rem;
            /* More rounded corners */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            /* Softer shadow */
            margin-bottom: 2.5rem;
            /* Increased margin bottom */
        }

        .form-section h2,
        .form-section h3 {
            color: #2d3748;
            /* Darker gray for titles */
            border-bottom: 1px solid #e2e8f0;
            /* Lighter border */
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .form-input,
        .form-select {
            width: 100%;
            border-width: 1px;
            border-color: #cbd5e0;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            box-shadow: inset 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.3);
        }

        .form-select {
            background-color: white;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }

        .btn {
            padding: 0.625rem 1.25rem;
            font-weight: 600;
            border-radius: 0.375rem;
            transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background-color: #dd6b20;
            color: white;
        }

        .btn-primary:hover {
            background-color: #c05621;
        }

        .btn-danger {
            background-color: #e53e3e;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c53030;
        }

        .btn-secondary {
            background-color: #4a5568;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #2d3748;
        }

        .table-wrapper {
            overflow-x: auto;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .table th,
        .table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom-width: 1px;
            border-color: #e2e8f0;
        }

        .table th {
            background-color: #f7fafc;
            font-weight: 600;
            color: #4a5568;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        .table td {
            color: #2d3748;
            font-size: 0.875rem;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-width: 1px;
            border-radius: 0.375rem;
        }

        .alert-success {
            background-color: #f0fff4;
            border-color: #9ae6b4;
            color: #2f855a;
        }

        .alert-danger {
            background-color: #fff5f5;
            border-color: #feb2b2;
            color: #c53030;
        }

        .alert-warning {
            background-color: #fffaf0;
            border-color: #fbd38d;
            color: #975a16;
        }

        .checkbox-label {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }

        .checkbox-label input {
            height: 1rem;
            width: 1rem;
            border-radius: 0.25rem;
            border-color: #cbd5e0;
            color: #dd6b20;
            margin-right: 0.5rem;
        }

        .checkbox-label input:focus {
            ring: #dd6b20;
        }
    </style>
    <link rel="icon" href="{{ asset('Image/Logo New.png') }}" type="image/png">
    <title>Admin Panel - ORVÉ Salon</title>
</head>

<body>
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

    <main class="container mx-auto mt-8 p-4 sm:p-6 lg:p-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 text-center">Pengaturan Booking & Jadwal</h1>

        @if (session('success'))
            <div class="alert alert-success" role="alert"><strong class="font-bold">Sukses!</strong> <span
                    class="block sm:inline">{{ session('success') }}</span></div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning" role="alert"><strong class="font-bold">Perhatian!</strong> <span
                    class="block sm:inline">{!! session('warning') !!}</span></div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong class="font-bold">Oops! Ada beberapa masalah:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-8">
                <section class="form-section">
                    <h2 class="text-xl font-semibold">Kelola Lokasi</h2>
                    <form method="POST" action="{{ route('locations.store') }}">
                        @csrf
                        <label for="location_name_input" class="block mb-1 font-medium text-gray-700">Tambah Lokasi
                            Baru:</label>
                        <div class="flex space-x-2">
                            <input type="text" name="name" id="location_name_input"
                                class="form-input flex-grow" placeholder="Nama Lokasi" required>
                            <button type="submit" class="btn btn-primary whitespace-nowrap">Tambah</button>
                        </div>
                        @error('name', 'storeLocation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </form>
                    <div class="mt-6 space-y-2">
                        <h3 class="text-md font-medium text-gray-600 mb-2">Daftar Lokasi:</h3>
                        @forelse ($locationsAll as $location)
                            <div
                                class="flex justify-between items-center border p-3 rounded-md bg-gray-50 hover:bg-gray-100 transition-colors">
                                <span class="text-gray-700">{{ $location->name }}</span>
                                <form action="{{ route('locations.destroy', $location->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus lokasi ini? Semua jadwal & kaitan hairdresser di lokasi ini juga akan terpengaruh.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada lokasi.</p>
                        @endforelse
                        @if ($errors->has('error_location'))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('error_location') }}</p>
                        @endif
                        @if ($locationsAll->hasPages())
                            <div class="mt-4">
                                {{ $locationsAll->links('vendor.pagination.tailwind') }}
                            </div>
                        @endif
                    </div>
                </section>

                <section class="form-section">
                    <h2 class="text-xl font-semibold">Kelola Layanan</h2>
                    <form method="POST" action="{{ route('services.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="service_name_input" class="block mb-1 font-medium text-gray-700">Nama
                                Layanan:</label>
                            <input type="text" name="name" id="service_name_input" class="form-input"
                                required>
                            @error('name', 'storeService')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="service_price_input" class="block mb-1 font-medium text-gray-700">Harga
                                    (Rp):</label>
                                <input type="number" name="price" id="service_price_input" class="form-input"
                                    required min="0">
                                @error('price')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="service_promo_price_input"
                                    class="block mb-1 font-medium text-gray-700">Harga Promo (Rp):</label>
                                <input type="number" name="promo_price" id="service_promo_price_input"
                                    class="form-input" min="0">
                                @error('promo_price')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Layanan</button>
                    </form>
                    <div class="mt-6 space-y-2">
                        <h3 class="text-md font-medium text-gray-600 mb-2">Daftar Layanan:</h3>
                        @forelse($services as $service_item)
                            <div
                                class="flex justify-between items-center border p-3 rounded-md bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div>
                                    <span class="text-gray-700">{{ $service_item->name }} -
                                        Rp{{ number_format($service_item->price) }}</span>
                                    @if ($service_item->promo_price)
                                        <span class="text-sm text-red-500 ml-2">(Promo:
                                            Rp{{ number_format($service_item->promo_price) }})</span>
                                    @endif
                                </div>
                                <form action="{{ route('services.destroy', $service_item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus layanan ini? Semua jadwal & kaitan hairdresser dengan layanan ini juga akan terpengaruh.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada layanan.</p>
                        @endforelse
                        @if ($errors->has('error_service'))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('error_service') }}</p>
                        @endif
                        @if ($services->hasPages())
                            <div class="mt-4">
                                {{ $services->links('vendor.pagination.tailwind') }}
                            </div>
                        @endif
                    </div>
                </section>

                <section class="form-section">
                    <h2 class="text-xl font-semibold">Kelola Testimonial</h2>
                    <form method="POST" action="{{ route('testimonial.store') }}" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        <div><label for="testimonial_name_input" class="block mb-1 font-medium text-gray-700">Nama
                                Klien:</label><input type="text" name="name" id="testimonial_name_input"
                                class="form-input" required></div>
                        <div><label for="testimonial_role_input"
                                class="block mb-1 font-medium text-gray-700">Posisi/Role:</label><input type="text"
                                name="role" id="testimonial_role_input" class="form-input" required></div>
                        <div><label for="testimonial_content_input"
                                class="block mb-1 font-medium text-gray-700">Testimonial:</label>
                            <textarea name="content" id="testimonial_content_input" rows="3" class="form-input" required></textarea>
                        </div>
                        <div>
                            <label for="testimonial_image_input" class="block mb-1 font-medium text-gray-700">Foto
                                (Max 2MB):</label>
                            <input type="file" name="image" id="testimonial_image_input" accept="image/*"
                                class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                                required>
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Testimonial</button>
                    </form>
                    <div class="mt-6 space-y-3">
                        <h3 class="text-md font-medium text-gray-600 mb-2">Daftar Testimonial:</h3>
                        @forelse ($testimonials as $testimonial)
                            <div
                                class="flex items-center border p-3 rounded-md bg-gray-50 hover:bg-gray-100 transition-colors">
                                <img src="{{ asset('storage/' . $testimonial->image_path) }}"
                                    alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full object-cover mr-3">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-700">{{ $testimonial->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $testimonial->role }}</p>
                                </div>
                                <form action="{{ route('testimonial.destroy', $testimonial->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada testimoni.</p>
                        @endforelse
                    </div>
                </section>
            </div>

            <div class="space-y-8">
                <section class="form-section" id="hairdresser-section"> {{-- ID untuk anchor link --}}
                    <h2 class="text-xl font-semibold">Kelola Hairdresser</h2>
                    @php $isEditingHairdresser = isset($editingHairdresser) && $editingHairdresser; @endphp
                    @if ($isEditingHairdresser)
                        <h3 class="text-lg font-medium text-gray-700 mb-3">Edit Hairdresser: <span
                                class="text-orange-600">{{ $editingHairdresser->name }}</span></h3>
                        <form action="{{ route('hairdressers.update', $editingHairdresser->id) }}" method="POST"
                            class="space-y-4 mb-6">
                            @csrf @method('PUT') <input type="hidden" name="from_main_page" value="1">
                            <div><label for="edit_hairdresser_name_input"
                                    class="block text-sm font-medium text-gray-700 mb-1">Nama Hairdresser <span
                                        class="text-red-500">*</span></label><input type="text" name="name"
                                    id="edit_hairdresser_name_input"
                                    value="{{ old('name', $editingHairdresser->name) }}" required
                                    class="form-input @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex space-x-2"><button type="submit" class="btn btn-primary">Update
                                    Nama</button><a href="{{ route('schedules.index') }}"
                                    class="btn btn-secondary !py-2.5 !px-3 !text-xs !font-normal !normal-case !tracking-normal">Batal
                                    Edit</a></div>
                        </form>
                        <form action="{{ route('hairdressers.updateLocations', $editingHairdresser->id) }}"
                            method="POST" class="space-y-3 mt-4 border-t pt-4">
                            @csrf @method('PUT') <input type="hidden" name="from_main_page" value="1">
                            <h4 class="text-md font-medium text-gray-600">Lokasi Penugasan:</h4>
                            <div
                                class="max-h-32 overflow-y-auto border border-gray-200 rounded-md p-3 space-y-1 bg-gray-50">
                                @foreach ($locationsAll as $location)
                                    <div><label class="checkbox-label"><input type="checkbox" name="location_ids[]"
                                                value="{{ $location->id }}"
                                                {{ in_array($location->id, $assignedLocationIds ?? []) ? 'checked' : '' }}>
                                            {{ $location->name }}</label></div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-secondary text-xs">Update Lokasi</button>
                        </form>
                        <form action="{{ route('hairdressers.updateServices', $editingHairdresser->id) }}"
                            method="POST" class="space-y-3 mt-4 border-t pt-4">
                            @csrf @method('PUT') <input type="hidden" name="from_main_page" value="1">
                            <h4 class="text-md font-medium text-gray-600">Layanan Dikuasai:</h4>
                            <div
                                class="max-h-32 overflow-y-auto border border-gray-200 rounded-md p-3 space-y-1 bg-gray-50">
                                @foreach ($servicesAll as $service_item)
                                    <div><label class="checkbox-label"><input type="checkbox" name="service_ids[]"
                                                value="{{ $service_item->id }}"
                                                {{ in_array($service_item->id, $assignedServiceIds ?? []) ? 'checked' : '' }}>
                                            {{ $service_item->name }}</label></div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-secondary text-xs">Update Layanan</button>
                        </form>
                    @else
                        <h3 class="text-lg font-medium text-gray-700 mb-3">Tambah Hairdresser Baru</h3>
                        <form action="{{ route('hairdressers.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div><label for="hairdresser_name_input"
                                    class="block text-sm font-medium text-gray-700 mb-1">Nama Hairdresser <span
                                        class="text-red-500">*</span></label><input type="text" name="name"
                                    id="hairdresser_name_input" value="{{ old('name') }}" required
                                    class="form-input @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-1">Lokasi Penugasan Awal (Opsional):
                                </h4>
                                <div
                                    class="max-h-32 overflow-y-auto border border-gray-200 rounded-md p-2 space-y-1 bg-gray-50">
                                    @foreach ($locations as $location)
                                        <div><label class="checkbox-label"><input type="checkbox"
                                                    name="location_ids[]" value="{{ $location->id }}"
                                                    {{ is_array(old('location_ids')) && in_array($location->id, old('location_ids')) ? 'checked' : '' }}>
                                                {{ $location->name }}</label></div>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-1">Layanan Dikuasai Awal (Opsional):
                                </h4>
                                <div
                                    class="max-h-32 overflow-y-auto border border-gray-200 rounded-md p-2 space-y-1 bg-gray-50">
                                    @foreach ($servicesAll as $service_item)
                                        <div><label class="checkbox-label"><input type="checkbox"
                                                    name="service_ids[]" value="{{ $service_item->id }}"
                                                    {{ is_array(old('service_ids')) && in_array($service_item->id, old('service_ids')) ? 'checked' : '' }}>
                                                {{ $service_item->name }}</label></div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Hairdresser</button>
                        </form>
                    @endif
                    <div class="mt-6">
                        <h3 class="text-md font-medium text-gray-600 mb-2">Daftar Hairdresser:</h3>
                        <div class="table-wrapper">
                            <table class="min-w-full table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        <th>Layanan</th>
                                        <th>Jadwal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($hairdressersAll as $hairdresser_item)
                                        <tr>
                                            <td class="font-medium">{{ $hairdresser_item->name }}</td>
                                            <td>{{ $hairdresser_item->locations_count ?? $hairdresser_item->locations->count() }}
                                            </td>
                                            <td>{{ $hairdresser_item->services_count ?? $hairdresser_item->services->count() }}
                                            </td>
                                            <td>{{ $hairdresser_item->schedules_count ?? $hairdresser_item->schedules->count() }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                <a href="{{ route('schedules.index', ['edit_hairdresser_id' => $hairdresser_item->id]) }}#hairdresser-section"
                                                    class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mr-2">Edit</a>
                                                <form
                                                    action="{{ route('hairdressers.destroy', $hairdresser_item->id) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('Yakin ingin menghapus hairdresser ini? Semua jadwal terkait akan dihapus.')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-gray-500 py-3">Belum ada
                                                hairdresser.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <section class="form-section" id="schedule-form-section">
                    @php $isEditingSchedule = isset($editingSchedule) && $editingSchedule; @endphp
                    @if ($isEditingSchedule)
                        <h2 class="text-xl font-semibold">Edit Jadwal untuk <span
                                class="text-orange-600">{{ $editingSchedule->hairdresser->name ?? 'N/A' }}</span></h2>
                        <form action="{{ route('admin.schedules.update', $editingSchedule->id) }}" method="POST"
                            class="space-y-4">
                            @csrf @method('PUT')
                        @else
                            <h2 class="text-xl font-semibold">Tambah Jadwal Baru</h2>
                            <form action="{{ route('admin.schedules.store') }}" method="POST" class="space-y-4">
                                @csrf
                    @endif
                    <div>
                        <label for="schedule_hairdresser_id"
                            class="block text-sm font-medium text-gray-700 mb-1">Hairdresser <span
                                class="text-red-500">*</span></label>
                        <select name="hairdresser_id" id="schedule_hairdresser_id" required
                            class="form-select @error('hairdresser_id') border-red-500 @enderror">
                            <option value="" disabled
                                {{ old('hairdresser_id', $editingSchedule->hairdresser_id ?? ($selectedHairdresserIdForSchedule ?? '')) == '' ? 'selected' : '' }}>
                                -- Pilih Hairdresser --</option>
                            @foreach ($hairdressersAll as $hd)
                                <option value="{{ $hd->id }}" data-hairdresser-id="{{ $hd->id }}"
                                    {{ old('hairdresser_id', $editingSchedule->hairdresser_id ?? ($selectedHairdresserIdForSchedule ?? '')) == $hd->id ? 'selected' : '' }}>
                                    {{ $hd->name }}</option>
                            @endforeach
                        </select>
                        @error('hairdresser_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="schedule_service_id" class="block text-sm font-medium text-gray-700 mb-1">Layanan
                            <span class="text-red-500">*</span></label>
                        <select name="service_id" id="schedule_service_id" required
                            class="form-select @error('service_id') border-red-500 @enderror"
                            {{ !$isEditingSchedule && empty(old('hairdresser_id', $selectedHairdresserIdForSchedule ?? '')) ? 'disabled' : '' }}>
                            <option value="" disabled
                                {{ old('service_id', $editingSchedule->service_id ?? '') == '' ? 'selected' : '' }}>--
                                Pilih Layanan --</option>
                            @if ($isEditingSchedule && $editingSchedule->hairdresser)
                                @foreach ($editingSchedule->hairdresser->services()->orderBy('name')->get() as $serv)
                                    <option value="{{ $serv->id }}"
                                        {{ old('service_id', $editingSchedule->service_id ?? '') == $serv->id ? 'selected' : '' }}>
                                        {{ $serv->name }}</option>
                                @endforeach
                            @elseif(isset($selectedHairdresserIdForSchedule) &&
                                    $selectedHairdresserIdForSchedule &&
                                    ($prefillHd = $hairdressersAll->firstWhere('id', $selectedHairdresserIdForSchedule)))
                                @foreach ($prefillHd->services()->orderBy('name')->get() as $serv)
                                    <option value="{{ $serv->id }}"
                                        {{ old('service_id') == $serv->id ? 'selected' : '' }}>{{ $serv->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <p id="schedule_service_loading" class="text-xs text-gray-500 mt-1 hidden">Memuat layanan...
                        </p>
                        @error('service_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="schedule_location_id" class="block text-sm font-medium text-gray-700 mb-1">Lokasi
                            <span class="text-red-500">*</span></label>
                        <select name="location_id" id="schedule_location_id" required
                            class="form-select @error('location_id') border-red-500 @enderror"
                            {{ !$isEditingSchedule && empty(old('hairdresser_id', $selectedHairdresserIdForSchedule ?? '')) ? 'disabled' : '' }}>
                            <option value="" disabled
                                {{ old('location_id', $editingSchedule->location_id ?? '') == '' ? 'selected' : '' }}>
                                -- Pilih Lokasi --</option>
                            @if ($isEditingSchedule && $editingSchedule->hairdresser)
                                @foreach ($editingSchedule->hairdresser->locations()->orderBy('name')->get() as $loc)
                                    <option value="{{ $loc->id }}"
                                        {{ old('location_id', $editingSchedule->location_id ?? '') == $loc->id ? 'selected' : '' }}>
                                        {{ $loc->name }}</option>
                                @endforeach
                            @elseif(isset($selectedHairdresserIdForSchedule) &&
                                    $selectedHairdresserIdForSchedule &&
                                    ($prefillHd = $hairdressersAll->firstWhere('id', $selectedHairdresserIdForSchedule)))
                                @foreach ($prefillHd->locations()->orderBy('name')->get() as $loc)
                                    <option value="{{ $loc->id }}"
                                        {{ old('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <p id="schedule_location_loading" class="text-xs text-gray-500 mt-1 hidden">Memuat lokasi...
                        </p>
                        @error('location_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="schedule_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                <span class="text-red-500">*</span></label>
                            <input type="date" name="date" id="schedule_date"
                                value="{{ old('date', $editingSchedule->date ?? '') }}" required
                                min="{{ $isEditingSchedule ? '' : now()->format('Y-m-d') }}"
                                class="form-input @error('date') border-red-500 @enderror">
                            @error('date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="schedule_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu
                                Mulai <span class="text-red-500">*</span></label>
                            <input type="time" name="time" id="schedule_time"
                                value="{{ old('time', $editingSchedule->time ?? '') }}" required
                                class="form-input @error('time') border-red-500 @enderror">
                            @error('time')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="submit" class="btn btn-primary">
                            {{ $isEditingSchedule ? 'Update Jadwal' : 'Simpan Jadwal' }}
                        </button>
                        @if ($isEditingSchedule)
                            <a href="{{ route('schedules.index', ['page' => request('schedules_page', 1)]) }}#schedule-list-section"
                                class="btn btn-secondary !py-2.5 !px-3 !text-xs !font-normal !normal-case !tracking-normal">Batal
                                Edit</a>
                        @endif
                    </div>
                    </form>
                </section>

                <section class="form-section">
                    <h2 class="text-xl font-semibold">Import Jadwal dari Excel</h2>
                    <form action="{{ route('schedules.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4"><label for="file_import_schedule"
                                class="block text-sm font-medium text-gray-700 mb-1">Pilih File Excel (.xlsx, .xls,
                                .csv):</label><input type="file" name="file" id="file_import_schedule"
                                accept=".xlsx, .xls, .csv" required
                                class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                        </div>
                        <button type="submit" class="btn btn-secondary">Upload & Import</button>
                    </form>
                </section>
            </div>
        </div>

        <section class="form-section mt-10" id="schedule-list-section">
            <h2 class="text-xl font-semibold">Daftar Jadwal Tersedia</h2>
            <form method="GET" action="{{ route('schedules.index') }}#schedule-list-section"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6 p-4 border rounded-md bg-gray-50">
                <div>
                    <label for="filter_location_id" class="block text-sm font-medium text-gray-700">Lokasi:</label>
                    <select name="location_id" id="filter_location_id" class="form-select text-sm mt-1">
                        <option value="">Semua Lokasi</option>
                        @foreach ($locations as $loc)
                            <option value="{{ $loc->id }}"
                                {{ $locationIdFilter == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter_hairdresser_id_schedule"
                        class="block text-sm font-medium text-gray-700">Hairdresser:</label>
                    <select name="hairdresser_id_filter" id="filter_hairdresser_id_schedule"
                        class="form-select text-sm mt-1">
                        <option value="">Semua Hairdresser</option>
                        @foreach ($hairdressersAll as $hd)
                            <option value="{{ $hd->id }}"
                                {{ $hairdresserIdFilter == $hd->id ? 'selected' : '' }}>{{ $hd->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter_service_id_schedule"
                        class="block text-sm font-medium text-gray-700">Layanan:</label>
                    <select name="service_id_filter" id="filter_service_id_schedule"
                        class="form-select text-sm mt-1">
                        <option value="">Semua Layanan</option>
                        @foreach ($servicesAll as $serv)
                            <option value="{{ $serv->id }}"
                                {{ $serviceIdFilter == $serv->id ? 'selected' : '' }}>{{ $serv->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter_date_schedule" class="block text-sm font-medium text-gray-700">Tanggal:</label>
                    <input type="date" name="date_filter" id="filter_date_schedule" value="{{ $dateFilter }}"
                        class="form-input text-sm mt-1">
                </div>
                <div class="col-span-1 sm:col-span-2 md:col-span-4 flex items-end space-x-2">
                    <button type="submit" class="btn btn-primary text-sm">Filter</button>
                    <a href="{{ route('schedules.index') }}#schedule-list-section"
                        class="btn btn-secondary text-sm">Reset</a>
                </div>
            </form>
            <div class="table-wrapper">
                <table class="min-w-full table">
                    <thead>
                        <tr>
                            <th>Tanggal & Waktu</th>
                            <th>Hairdresser</th>
                            <th>Layanan</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($schedules as $schedule)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($schedule->available_at)->format('d M Y, H:i') }}</td>
                                <td>{{ $schedule->hairdresser->name ?? 'N/A' }}</td>
                                <td>{{ $schedule->service->name ?? 'N/A' }}</td>
                                <td>{{ $schedule->location->name ?? 'N/A' }}</td>
                                <td class="whitespace-nowrap">
                                    <a href="{{ route('schedules.index', ['edit_schedule_id' => $schedule->id, 'schedules_page' => request('schedules_page', 1)]) }}#schedule-form-section"
                                        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mr-2">Edit</a>
                                    <form action="{{ route('admin.schedules.destroy', $schedule->id) }}"
                                        method="POST" class="inline-block"
                                        onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada jadwal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($schedules->hasPages())
                <div class="mt-6">{{ $schedules->links('vendor.pagination.tailwind') }}</div>
            @endif
        </section>
    </main>

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
        // Definisikan URL dasar untuk AJAX request. Pastikan route 'hairdressers.getDetails' ada.
        // Kita akan mengganti ':hairdresserIdPlaceholder' dengan ID hairdresser yang sebenarnya.
        const hairdresserDetailsUrlTemplate =
            "{{ route('admin.hairdressers.getDetails', ['hairdresser' => ':hairdresserIdPlaceholder']) }}";

        document.addEventListener('DOMContentLoaded', function() {
            const scheduleHairdresserSelect = document.getElementById('schedule_hairdresser_id');
            const scheduleServiceSelect = document.getElementById('schedule_service_id');
            const scheduleLocationSelect = document.getElementById('schedule_location_id');
            const serviceLoadingText = document.getElementById('schedule_service_loading');
            const locationLoadingText = document.getElementById('schedule_location_loading');

            // Ambil nilai awal jika dalam mode edit atau prefill
            // Variabel ini di-pass dari PHP ke JS melalui tag <script> di atas (tidak ada di snippet ini, tapi harus ada di Blade Anda)
            // atau kita bisa ambil langsung dari value select jika sudah di-set oleh old() atau $editingSchedule
            const initialSelectedHairdresserId = scheduleHairdresserSelect ? scheduleHairdresserSelect.value : null;

            @php
                // Ini akan dieksekusi di server dan nilainya akan di-hardcode ke JS saat halaman dirender
                $currentEditingScheduleServiceId = null;
                $currentEditingScheduleLocationId = null;
                if (isset($editingSchedule) && $editingSchedule && $editingSchedule->hairdresser_id == old('hairdresser_id', $editingSchedule->hairdresser_id ?? ($selectedHairdresserIdForSchedule ?? ''))) {
                    $currentEditingScheduleServiceId = old('service_id', $editingSchedule->service_id ?? '');
                    $currentEditingScheduleLocationId = old('location_id', $editingSchedule->location_id ?? '');
                }
            @endphp

            const currentEditingScheduleServiceId = @json($currentEditingScheduleServiceId);
            const currentEditingScheduleLocationId = @json($currentEditingScheduleLocationId);


            function populateDropdown(selectElement, optionsArray, placeholderText, selectedValue = null) {
                selectElement.innerHTML = '';
                const placeholderOption = document.createElement('option');
                placeholderOption.value = '';
                placeholderOption.textContent = placeholderText;
                placeholderOption.disabled = true;
                selectElement.appendChild(placeholderOption);

                if (optionsArray && optionsArray.length > 0) {
                    optionsArray.forEach(function(optionData) {
                        const option = document.createElement('option');
                        option.value = optionData.id;
                        option.textContent = optionData.name;
                        if (selectedValue && optionData.id == selectedValue) {
                            option.selected = true;
                        }
                        selectElement.appendChild(option);
                    });
                    selectElement.disabled = false;
                    if (selectedValue && selectElement.querySelector('option[value="' + selectedValue + '"]')) {
                        selectElement.value = selectedValue;
                    } else {
                        selectElement.value =
                            ''; // Default ke placeholder jika selectedValue tidak ada atau tidak ditemukan
                    }
                } else {
                    const noDataOption = document.createElement('option');
                    noDataOption.value = '';
                    noDataOption.textContent = 'Tidak ada data relevan';
                    noDataOption.disabled = true;
                    selectElement.appendChild(noDataOption);
                    selectElement.disabled = true;
                    selectElement.value = '';
                }
                selectElement.dispatchEvent(new Event('change')); // Untuk update styling warna teks
            }

            function fetchAndPopulateDetails(hairdresserId) {
                if (!hairdresserId) {
                    populateDropdown(scheduleServiceSelect, [], '-- Pilih Layanan --');
                    scheduleServiceSelect.disabled = true;
                    populateDropdown(scheduleLocationSelect, [], '-- Pilih Lokasi --');
                    scheduleLocationSelect.disabled = true;
                    if (serviceLoadingText) serviceLoadingText.classList.add('hidden');
                    if (locationLoadingText) locationLoadingText.classList.add('hidden');
                    return;
                }

                if (serviceLoadingText) serviceLoadingText.classList.remove('hidden');
                if (locationLoadingText) locationLoadingText.classList.remove('hidden');
                scheduleServiceSelect.disabled = true;
                scheduleLocationSelect.disabled = true;

                const url = hairdresserDetailsUrlTemplate.replace(':hairdresserIdPlaceholder', hairdresserId);

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response error');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (serviceLoadingText) serviceLoadingText.classList.add('hidden');
                        if (locationLoadingText) locationLoadingText.classList.add('hidden');

                        // Tentukan selectedValue untuk service dan location JIKA hairdresser yang dipilih
                        // adalah sama dengan hairdresser pada $editingSchedule (atau prefill)
                        // DAN kita memang sedang dalam mode edit (atau prefill dengan data lama).
                        let serviceToSelect = null;
                        let locationToSelect = null;

                        const isEditingThisHairdresserSchedule =
                            {{ isset($editingSchedule) && $editingSchedule ? 'true' : 'false' }} &&
                            hairdresserId ==
                            {{ isset($editingSchedule) && $editingSchedule ? $editingSchedule->hairdresser_id : 'null' }};

                        const isPrefillingHairdresser =
                            {{ isset($selectedHairdresserIdForSchedule) && $selectedHairdresserIdForSchedule ? 'true' : 'false' }} &&
                            hairdresserId == {{ $selectedHairdresserIdForSchedule ?? 'null' }};


                        if (isEditingThisHairdresserSchedule) {
                            serviceToSelect = currentEditingScheduleServiceId;
                            locationToSelect = currentEditingScheduleLocationId;
                        } else if (isPrefillingHairdresser && !
                            {{ isset($editingSchedule) && $editingSchedule ? 'true' : 'false' }}) {
                            // Jika prefill untuk jadwal BARU, jangan auto-select service/location lama, biarkan user memilih dari yang tersedia
                            serviceToSelect =
                                '{{ old('service_id') }}'; // Ambil dari old input jika ada (misal setelah validation error)
                            locationToSelect = '{{ old('location_id') }}';
                        }


                        populateDropdown(scheduleServiceSelect, data.services, '-- Pilih Layanan --',
                            serviceToSelect);
                        populateDropdown(scheduleLocationSelect, data.locations, '-- Pilih Lokasi --',
                            locationToSelect);
                    })
                    .catch(error => {
                        console.error('Error fetching hairdresser details:', error);
                        if (serviceLoadingText) serviceLoadingText.classList.add('hidden');
                        if (locationLoadingText) locationLoadingText.classList.add('hidden');
                        populateDropdown(scheduleServiceSelect, [], 'Gagal memuat layanan');
                        populateDropdown(scheduleLocationSelect, [], 'Gagal memuat lokasi');
                    });
            }

            if (scheduleHairdresserSelect) {
                scheduleHairdresserSelect.addEventListener('change', function() {
                    fetchAndPopulateDetails(this.value);
                });

                // Initial population if a hairdresser is already selected (e.g., on edit form load or prefill)
                if (initialSelectedHairdresserId) {
                    fetchAndPopulateDetails(initialSelectedHairdresserId);
                } else {
                    // Jika tidak ada hairdresser terpilih awalnya (misal form tambah baru tanpa prefill)
                    scheduleServiceSelect.disabled = true;
                    scheduleLocationSelect.disabled = true;
                }
            }

            // Styling untuk select option yang terpilih (agar tidak abu-abu)
            document.querySelectorAll('.form-select').forEach(selectElement => {
                function updateTextColor() {
                    if (selectElement.value === "" || selectElement.value === null) {
                        selectElement.classList.add('text-gray-400');
                        selectElement.classList.remove('text-black');
                    } else {
                        selectElement.classList.add('text-black');
                        selectElement.classList.remove('text-gray-400');
                    }
                }
                selectElement.addEventListener('change', updateTextColor);
                updateTextColor(); // Panggil saat load
            });
        });
    </script>
</body>

</html>
