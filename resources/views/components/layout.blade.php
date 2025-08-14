@props(['fromHomeOrHomecare' => 'default'])
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/css/splide.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" href="{{ asset('Image/Logo New.png') }}" type="image/png">
    <title>ORVÉ Salon</title>
</head>

<body class="w-full flex flex-col min-h-screen font-elMessiri overflow-x-hidden">
    <div class="flex-grow flex flex-col">
        <!-- Header -->
        <x-navbar :fromHomeOrHomecare="$fromHomeOrHomecare" />
        <!-- Main Content -->
        <div class="flex-grow">
            {{ $slot }}
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
    <script>
        if (window.location.pathname === '/') {
            const button = document.getElementById('dropdownButton');
            const menu = document.getElementById('dropdownMenu');

            button.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }
    </script>
    <script>
        const navbar = document.getElementById('navbar');
        const screenHeight = window.innerWidth <= 768 ? window.innerHeight : window.innerHeight - 10;
        window.addEventListener('scroll', () => {
            if (window.scrollY > screenHeight) {
                navbar.classList.remove('bg-transparent');
                navbar.classList.add('bg-black');
            } else {
                navbar.classList.remove('bg-black');
                navbar.classList.add('bg-transparent');
            }
        });
    </script>
</body>

</html>
