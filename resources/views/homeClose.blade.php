<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=390, initial-scale=1.0" />
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
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" href="{{ asset('Image/Logo New.png') }}" type="image/png">
    <title>ORVÉ Salon</title>
</head>

<body class="w-full flex flex-col min-h-screen font-elMessiri overflow-x-hidden">
    <div class="flex-grow flex flex-col">
        <div class="flex-grow">
            <div class="min-h-screen bg-cover bg-center bg-no-repeat">
                <div class="relative flex items-center justify-center min-h-screen w-full px-4 md:px-10 z-10 overflow-hidden"
                    id="home"
                    style="background-image: url('{{ asset('Image/Background.webp') }}');
               background-size: cover;
               background-position: center;">

                    <div class="absolute inset-0 bg-black opacity-70"></div>

                    <!-- Bagian Kiri (Teks) -->
                    <div
                        class="w-full z-30 md:pl-10 flex flex-col justify-center items-center md:mt-0 px-4 md:px-0 md:text-left md:mr-20">
                        <h1 class="text-3xl md:text-5xl lg:text-6xl font-semibold text-white text-center">Oops! Layanan
                            Belum
                            Tersedia</h1>

                        <p class="text-white text-lg md:text-3xl mt-2 text-center md:px-8 px-2">
                            Kami sedang menyusun pengalaman yang lebih lengkap untuk kamu. Waktu terbaik akan datang—dan
                            kami ingin memastikan kamu merasakannya saat itu tiba.
                        </p>
                        <a href="{{ route('homecare') }}">
                            <button
                                class="flex items-center justify-center px-4 pt-[9px] pb-[6px] bg-orangeBtn text-white font-semibold text-center leading-normal rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 mt-4 text-lg">
                                Kembali ke Halaman Awal
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-black text-white py-4 px-4">
            <div class="flex flex-col md:flex-row justify-center items-center text-center">
                <!-- Copyright -->
                <div class="text-white text-lg">
                    ORVÉ Salon
                </div>
            </div>
    </div>
    </footer>
</body>

</html>
