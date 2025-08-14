{{-- resources/views/admin/bookings/paid_list.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400;500;600;700&family=Zen+Maru+Gothic:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'El Messiri', sans-serif;
            background-color: #f7fafc;
        }

        .form-section {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            margin-bottom: 2.5rem;
        }

        .form-section h2 {
            color: #2d3748;
            border-bottom: 1px solid #e2e8f0;
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

        .btn-primary {
            background-color: #dd6b20;
            color: white;
        }

        .btn-primary:hover {
            background-color: #c05621;
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
            font-size: 0.875rem;
        }

        .table th {
            background-color: #f7fafc;
            font-weight: 600;
            color: #4a5568;
            text-transform: uppercase;
            font-size: 0.75rem;
        }
    </style>
    <link rel="icon" href="{{ asset('Image/Logo New.png') }}" type="image/png">
    <title>Daftar Booking Lunas - ORVÉ Salon Admin</title>
</head>

<body>
    {{-- Anda bisa include navigasi admin yang sudah ada di sini --}}
    {{-- Contoh: @include('admin.partials.navbar') --}}
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
        <section class="form-section">
            <h2 class="text-2xl font-semibold">Daftar Booking Lunas (Paid)</h2>

            <form method="GET" action="{{ route('admin.bookings.paid') }}"
                class="mb-6 p-4 border rounded-md bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="location_id" class="block text-sm font-medium text-gray-700">Filter Berdasarkan
                            Lokasi:</label>
                        <select name="location_id" id="location_id" class="form-select mt-1">
                            <option value="">Semua Lokasi</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}"
                                    {{ $selectedLocationId == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-1 flex space-x-2">
                        <button type="submit" class="btn btn-primary w-full md:w-auto">Filter</button>
                        @if ($selectedLocationId)
                            <a href="{{ route('admin.bookings.paid') }}"
                                class="btn btn-secondary w-full md:w-auto">Reset</a>
                        @endif
                    </div>
                </div>
            </form>

            @if ($paidBookings->isEmpty())
                <p class="text-gray-600">Tidak ada data booking lunas yang ditemukan.</p>
            @else
                <div class="table-wrapper">
                    <table class="min-w-full table">
                        <thead>
                            <tr>
                                <th>ID Booking</th>
                                <th>Pelanggan</th>
                                <th>Kontak</th>
                                <th>Layanan</th>
                                <th>Hairdresser</th>
                                <th>Lokasi</th>
                                <th>Waktu Booking</th>
                                <th>Total (Rp)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paidBookings as $booking)
                                <tr>
                                    <td class="font-mono text-xs">{{ $booking->uuid }}</td>
                                    <td>{{ $booking->name }}</td>
                                    <td>{{ $booking->phone }} <br> <span
                                            class="text-xs text-gray-500">{{ $booking->email }}</span></td>
                                    <td>{{ $booking->service->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->hairdresser->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->location->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->booking_time)->format('d M Y, H:i') }} WIB
                                    </td>
                                    <td class="text-right">{{ number_format($booking->price, 0, ',', '.') }}</td>
                                    <td><span
                                            class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">{{ ucfirst($booking->status) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($paidBookings->hasPages())
                    <div class="mt-6">
                        {{ $paidBookings->links('vendor.pagination.tailwind') }} {{-- Menggunakan view pagination default Laravel untuk Tailwind CSS --}}
                    </div>
                @endif
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
    </script>
</body>

</html>
