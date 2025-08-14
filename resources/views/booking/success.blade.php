<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400..700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&family=Zen+Maru+Gothic:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">
    <title>Booking Sukses</title>
    <link rel="icon" href="{{ asset('Image/Logo New.png') }}" type="image/png">
</head>

<body class="font-elMessiri bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Success Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-green-100">
            <!-- Header with decorative element -->
            <div class="bg-[#B29100] py-4 px-6">
                <div class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h1 class="ml-3 text-3xl font-bold text-white">Booking Status</h1>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 md:p-8">
                <div class="space-y-4 text-gray-700">
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#B29100] mt-1 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="ml-3 text-lg">
                            <span class="font-semibold">ID Booking:</span>
                            <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $booking->id }}</span>
                        </p>
                    </div>

                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#B29100] mt-1 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <p class="ml-3 text-lg">
                            <span class="font-semibold">Nama Customer:</span>
                            <span class="font-mono px-2 py-1 rounded">{{ $booking->name }}</span>
                        </p>
                    </div>

                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#B29100] mt-1 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <p class="ml-3 text-lg">
                            <span class="font-semibold">Layanan:</span>
                            {{ $booking->service->name }}
                        </p>
                    </div>

                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#B29100] mt-1 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="ml-3 text-lg">
                            <span class="font-semibold">Total Pembayaran:</span>
                            Rp {{ number_format($booking->price, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#B29100] mt-1 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <p class="ml-3 text-lg">
                            <span class="font-semibold">Status:</span>
                            <span
                                class="px-3 py-1 rounded-full text-sm font-medium
                                {{ $booking->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Additional decorative elements -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-center">
                    <p class="text-gray-500 text-center">
                        Terima kasih telah menggunakan layanan kami. Kami akan menghubungi Anda segera.
                    </p>
                </div>
            </div>
        </div>

        <!-- Back button -->
        <div class="mt-8 text-center">
            <a href="{{ route('homecare') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-[#B29100] hover:bg-[#9a7d00] transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B29100]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Kembali ke Home
            </a>
        </div>

    </div>
</body>

</html>
