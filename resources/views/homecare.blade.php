<x-layout>
    <div class="min-h-screen bg-cover bg-center bg-no-repeat">
        <div class="relative flex flex-col md:flex-row items-center justify-between min-h-screen w-full px-4 md:px-10 z-10 overflow-hidden"
            id="home"
            style="background-image: url('{{ asset('Image/Background.webp') }}'); background-size: cover; background-position: center;">

            <div class="absolute inset-0 bg-black opacity-70"></div>

            <!-- left Section (Text) -->
            <div
                class="w-full md:w-1/2 z-30 md:pl-10 flex flex-col justify-start md:justify-center items-start mt-56 md:mt-0 px-4 md:px-0 md:text-left">
                <h1 class="text-3xl md:text-6xl font-semibold text-white">Salon Premium,</h1>
                <h1 class="text-3xl md:text-6xl font-semibold text-white mt-2">Hadir di Rumahmu!</h1>
                <p class="text-white text-md md:text-xl mt-2">
                    Dapatkan perawatan rambut profesional dari</p>
                <p class="text-white text-md md:text-xl">
                    hairstylist berpengalaman, <strong>langsung di rumahmu.</strong>
                </p>
                <a href="{{ route('booking.index', ['from' => 'homecare']) }}">
                    <button
                        class="flex items-center justify-center px-4 pt-[9px] pb-[6px] bg-orangeBtn text-white font-semibold text-center leading-normal rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 mt-4">
                        Booking Sekarang
                    </button>
                </a>
            </div>

            <!-- Right Section (Photo) -->
            <div class="w-full md:w-1/2 md:">
                <div class="relative md:static">

                    <img src="{{ asset('Image/girl-5.webp') }}" alt="Salon"
                        class="absolute bottom-0 right-[-60px] md:right-0 md:h-[84vh] w-auto object-fit-contain h-[45vh ] sm:h-[60vh]">
                </div>
            </div>
        </div>

        <div class="relative flex flex-col-reverse md:flex-row items-center justify-between  px-0 mb-[-50px] md:mb-0 md:px-10 overflow-hidden md:pb-0 pb-2 md:mt-4 z-20"
            id="tentang-kami">
            {{-- left --}}
            <div class="relative w-full md:w-[700px] h-[350px] md:h-[500px] z-30 m-0 md:m-8">
                <!-- red background -->

                <img src="{{ asset('Image/homecare/redBg.png') }}" alt="Iphone"
                    class="absolute min-w-[140%] md:w-full h-[200px] md:h-[300px] top-[120px] rounded-r-[70px] md:top-[190px] left-[-50%] object-cover md:mb-10"
                    style="object-fit: cover;">


                <!-- about us photo -->
                <img src="{{ asset('Image/homecare/iphone.png') }}" alt="Iphone"
                    class="w-[300px] md:w-[400px] h-[364px] md:h-[550px] absolute top-[-10px] md:top-[0vh] right-[60px]"
                    style="object-position: top;">
            </div>


            {{-- kanan --}}
            <div class="relative w-full md:w-3/4 px-8 md:px-0 md:ml-10 md:mr-10">
                <h2 class="text-2xl mt-6 text-center mb-2 md:mb-4 md:text-left md:mt-0 md:text-4xl font-semibold">
                    Tentang Kami</h2>
                <p class="text-md md:text-2xl text-justify">ORVÉ Home Care Salon hadir untuk menghadirkan pengalaman
                    salon premium
                    langsung di rumahmu. Kami memahami bahwa pergi ke salon sering kali memakan waktu dan tidak selalu
                    nyaman. Dengan ORVÉ, kamu tidak perlu lagi mengorbankan kenyamanan untuk mendapatkan perawatan
                    rambut terbaik.</p>
                <br>
                <p class="text-md md:text-2xl text-justify">Kami menghubungkan kamu dengan hairstylist profesional yang
                    memiliki
                    keahlian di bidangnya. Dengan layanan haircut premium, ORVÉ memastikan setiap potongan rambut dibuat
                    dengan presisi, sesuai dengan karakter dan gaya yang kamu inginkan.</p>
                <br>
            </div>
        </div>
        <div
            class="relative flex flex-col-reverse md:flex-row h-[750px] md:min-h-screen bg-cream rounded-[40px] md:rounded-[100px] md:pl-10 z-30 justify-between overflow-hidden mt-20 md:mt-10">
            {{-- kiri --}}
            <div class="w-full md:w-1/2 z-30 p-8 md:pl-10 flex flex-col justify-center">
                <div class="space-y-1  md:mt-0">
                    <h2 class="text-2xl md:text-5xl font-semibold text-white">Pengalaman salon premium,</h2>
                    <h2 class="text-2xl md:text-5xl font-semibold text-white">langsung di rumah kamu.</h2>
                </div>
                <div class="mt-8 space-y-4">
                    <div class="relative  overflow-hidden">
                        <div class="absolute rounded-2xl inset-0 bg-black opacity-50 z-0 md:w-auto md:max-w-[600px]">
                        </div>
                        <div class="relative z-10 flex items-center p-2 md:p-4">
                            <div class="mr-4">
                                <svg class="w-14 h-20 md:w-20 md:h-16 sm:w-10 sm:h-10" viewBox="0 0 80 80"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M32.8 67.5834C31.4033 70.8234 27.5167 72.6934 23.9067 70.8467C17.0867 67.35 12.3933 63.3534 9.52333 58.9134C6.62 54.4167 5.72333 49.6934 6.12666 45.08C6.91333 36.1367 12.6133 27.6334 17.3333 21.3334C23.6133 12.96 31.6 8.33337 40 8.33337C48.4 8.33337 56.3867 12.96 62.6667 21.3334C67.3367 27.56 73.4667 36.1134 74.4667 45.0834C74.9833 49.74 74.1333 54.5234 71.1067 59.0634C68.1267 63.5367 63.1967 67.53 55.98 71.0134C52.37 72.7567 48.52 70.8567 47.17 67.6034C44.7633 69.1167 42.2433 70 40.0033 70C37.75 70 35.2133 69.1067 32.7967 67.5834H32.8ZM22.6667 25.3334C28.0533 18.1534 34.2333 15 40 15C45.7667 15 51.9467 18.1534 57.3333 25.3334C62.18 31.7934 67.0733 38.94 67.84 45.8234C68.2033 49.09 67.6233 52.2667 65.56 55.3667C63.4733 58.4934 59.7233 61.7667 53.3333 64.89V61.8867C56.22 58.0534 58.3333 52.9134 58.3333 46.6667C58.3333 45.3889 58.2655 44.1523 58.13 42.9567C58.0381 42.1486 57.6539 41.4019 57.0498 40.8573C56.4457 40.3128 55.6633 40.0079 54.85 40C51.1992 39.9639 47.687 38.5976 44.9716 36.1571C42.2562 33.7166 40.5241 30.3696 40.1 26.7434C40.0392 26.2654 39.8766 25.806 39.623 25.3962C39.3695 24.9865 39.0309 24.6359 38.6302 24.3683C38.2295 24.1006 37.7761 23.9221 37.3004 23.8448C36.8248 23.7674 36.3382 23.7931 35.8733 23.92C27.8933 26.2 21.6667 34.6834 21.6667 46.6667C21.6667 52.9134 23.78 58.0534 26.6667 61.8867V64.7667C20.71 61.6734 17.1467 58.42 15.1233 55.29C13.1 52.1634 12.48 48.95 12.77 45.6667C13.37 38.8167 17.9 31.68 22.6667 25.3334ZM28.3333 46.6667C28.3333 39.26 31.1667 34.42 34.4767 31.96C35.7511 35.708 38.0264 39.0359 41.0564 41.5835C44.0864 44.1311 47.7556 45.8014 51.6667 46.4134C51.7067 51.1067 50.1067 55.71 46.92 59.1867C44.1467 62.21 41.22 63.3334 40 63.3334C38.78 63.3334 35.8567 62.21 33.0833 59.1867C30.46 56.3234 28.3333 52.11 28.3333 46.6667Z"
                                        fill="white" />
                                </svg>
                            </div>

                            <div>
                                <p class="text-white text-md md:text-2xl flex-1">Ditangani oleh profesional</p>
                                <p class="text-white text-md md:text-2xl flex-1">berstandar
                                    tinggi</p>
                            </div>
                        </div>
                    </div>


                    <div class="relative overflow-hidden">
                        <div class="absolute rounded-2xl inset-0 bg-black opacity-50 z-0 md:md:w-auto md:max-w-[600px]">
                        </div>
                        <div class="relative z-10 flex items-center p-2 md:p-4">
                            <div class="mr-4">
                                <svg class="w-14 h-20 md:w-20 md:h-16 sm:w-10 sm:h-10" viewBox="0 0 80 80"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M62.5 63.09C64.035 61.715 65 59.72 65 57.5V34.885C65.0003 33.7362 64.7367 32.6028 64.2296 31.572C63.7224 30.5412 62.9853 29.6408 62.075 28.94L44.575 15.48C43.2636 14.4704 41.655 13.923 40 13.923C38.345 13.923 36.7364 14.4704 35.425 15.48L17.925 28.94C17.014 29.6413 16.2765 30.5426 15.7693 31.5742C15.2621 32.6059 14.9989 33.7404 15 34.89V57.5C14.9974 58.4827 15.1884 59.4563 15.5622 60.3652C15.936 61.274 16.4852 62.1003 17.1785 62.7968C17.8717 63.4933 18.6954 64.0464 19.6025 64.4244C20.5096 64.8024 21.4823 64.998 22.465 65H25V47.5C25 44.8478 26.0536 42.3043 27.9289 40.4289C29.8043 38.5536 32.3478 37.5 35 37.5H45C47.6522 37.5 50.1957 38.5536 52.0711 40.4289C53.9464 42.3043 55 44.8478 55 47.5V65H57.535C59.44 64.99 61.185 64.27 62.5 63.09ZM72.5 57.5C72.5 61.4783 70.9197 65.2936 68.1066 68.1066C65.2936 70.9197 61.4782 72.5 57.5 72.5H22.5C18.5218 72.5 14.7064 70.9197 11.8934 68.1066C9.08035 65.2936 7.5 61.4783 7.5 57.5V34.885C7.50016 32.5883 8.0277 30.3223 9.04196 28.2617C10.0562 26.2012 11.5301 24.401 13.35 23L30.85 9.54C33.4729 7.52088 36.69 6.42603 40 6.42603C43.31 6.42603 46.5271 7.52088 49.15 9.54L66.65 23C68.4706 24.4015 69.9449 26.2025 70.9591 28.264C71.9734 30.3255 72.5006 32.5925 72.5 34.89V57.5ZM47.5 47.5C47.5 46.837 47.2366 46.2011 46.7678 45.7322C46.2989 45.2634 45.663 45 45 45H35C34.337 45 33.7011 45.2634 33.2322 45.7322C32.7634 46.2011 32.5 46.837 32.5 47.5V65H47.5V47.5Z"
                                        fill="white" />
                                </svg>

                            </div>

                            <div>
                                <p class="text-white text-md md:text-2xl flex-1">Layanan profesional tanpa</p>
                                <p class="text-white text-md md:text-2xl flex-1">harus keluar
                                    rumah</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative  overflow-hidden">
                        <div class="absolute inset-0 rounded-2xl bg-black opacity-50 z-0 md:md:w-auto md:max-w-[600px]">
                        </div>
                        <div class="relative z-10 flex items-center p-2 md:p-4">
                            <div class="mr-4">
                                <svg class="w-14 h-20 md:w-20 md:h-16 sm:w-10 sm:h-10" viewBox="0 0 80 80"
                                    fill='none' xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M33.3333 10H26.6667C24.8986 10 23.2029 10.7024 21.9526 11.9526C20.7024 13.2029 20 14.8986 20 16.6667V63.3333C20 65.1014 20.7024 66.7971 21.9526 68.0474C23.2029 69.2976 24.8986 70 26.6667 70H53.3333C55.1014 70 56.7971 69.2976 58.0474 68.0474C59.2976 66.7971 60 65.1014 60 63.3333V16.6667C60 14.8986 59.2976 13.2029 58.0474 11.9526C56.7971 10.7024 55.1014 10 53.3333 10H46.6667M33.3333 10H46.6667M33.3333 10V13.3333M46.6667 10V13.3333M33.3333 13.3333C33.3333 14.2174 33.6845 15.0652 34.3096 15.6904C34.9348 16.3155 35.7826 16.6667 36.6667 16.6667H43.3333C44.2174 16.6667 45.0652 16.3155 45.6904 15.6904C46.3155 15.0652 46.6667 14.2174 46.6667 13.3333M33.3333 13.3333H46.6667"
                                        stroke="white" stroke-width="7" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                            <div>
                                <p class="text-white text-md md:text-2xl flex-1">Hemat waktu, tinggal pesan</p>
                                <p class="text-white text-md md:text-2xl flex-1">melalui
                                    website</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- kanan --}}
            <div class="w-full md:w-1/2 relative z-30">
                <img src="{{ asset('Image/homecare/Section3.jpg') }}" alt="premium-salon"
                    class="absolute top-[30px] left-1/2 -translate-x-1/2 md:top-1/2 md:-translate-y-1/2 md:left-auto md:right-0 md:translate-x-0 h-[240px] md:h-auto w-auto max-w-full object-contain rounded-[20px] md:p-0 md:rounded-l-[200px] md:rounded-none ">
            </div>


        </div>

        <div
            style="background-image: url('{{ asset('Image/black background 1.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <div id="services"
                class="relative flex flex-col justify-between min-h-screen px-8  z-10 w-full -mt-16 md:-mt-36">

                <div class="w-full text-center px-4">
                    <h1 class="font-semibold text-2xl md:text-4xl text-white mt-24 md:mt-48">
                        Hairdresser
                        Professional Siap Melayani Kamu!</h1>

                    <div id="splide-carousel" class="splide w-full lg:w-[940px]  mx-auto mt-4"
                        data-total="{{ count($carousels) }}">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($carousels as $carousel)
                                    <li class="splide__slide" style="width: 200px"> <!-- Ukuran fixed -->
                                        <div
                                            class="h-full bg-[#B29100] rounded-xl overflow-hidden shadow-lg flex flex-col">
                                            <div class="px-4 pt-4 pb-3 bg-[#B29100] min-h-[50px] flex-shrink-0">
                                                <h2 class="text-lg md:text-xl text-white font-bold truncate">
                                                    {{ $carousel->title }}
                                                </h2>
                                            </div>
                                            <div class="flex-1 relative flex items-end">
                                                <img src="{{ asset('storage/' . $carousel->image) }}"
                                                    alt="{{ $carousel->title }}"
                                                    class="w-full h-[400px] object-cover object-top align-bottom">
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Optional navigation -->
                        <div class="splide__arrows">
                            <button
                                class="splide__arrow splide__arrow--prev text-white bg-black/30 rounded-full px-4 py-2">←</button>
                            <button
                                class="splide__arrow splide__arrow--next text-white bg-black/30 rounded-full px-4 py-2">→</button>
                        </div>
                    </div>


                    <div
                        class="relative flex flex-col md:flex-row items-center z-50 overflow-hidden -mb-8 md:mb-8 md:mt-16">
                        {{-- Bagian Kiri (Konten) --}}
                        <div class="w-full md:w-1/2 z-30 flex flex-col ">
                            <div class="md:space-y-4">
                                <h2 class="font-bold text-2xl md:text-4xl text-white p-2 md:mt-0 mt-4">Transformasi
                                    dengan
                                    ORVÉ</h2>
                            </div>
                            <div class="md:mt-4 space-y-4">
                                <div class="relative rounded-2xl overflow-hidden">
                                    <div class="relative z-10 flex items-center p-2 md:py-0">
                                        <div>
                                            <p class="text-white md:text-justify text-md md:text-xl md:flex-1">Kami
                                                percaya
                                                setiap
                                                orang layak
                                                mendapatkan
                                                gaya rambut yang sempurna. Inilah hasil karya hairstylist profesional
                                                ORVÉ.
                                                Dari
                                                haircut klasik hingga modern, ORVÉ menghadirkan layanan personalisasi
                                                dengan
                                                standar terbaik. Temukan transformasi gaya rambut terbaik untuk kamu.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian Kanan (Carousel) --}}
                        <div
                            class="w-full md:w-1/2 relative flex items-center justify-center overflow-hidden md:mt-28">
                            <div class="relative w-full max-w-md" id="testimonial-carousel">
                                <!-- Carousel container -->
                                <div class="relative w-full md:h-[600px] h-[520px]"> <!-- Fixed height for carousel -->
                                    @foreach ($carouselsSecond as $index => $testimonial)
                                        <div class="absolute inset-0 transition-all duration-500 opacity-0"
                                            data-carousel-item="{{ $index }}"
                                            style="{{ $index === 0 ? 'opacity: 1; z-index: 10' : 'opacity: 0; z-index: 0' }}">

                                            <!-- Image Container -->
                                            <div class="relative w-full h-[300px]">
                                                <img src="{{ asset('storage/' . $testimonial->image) }}"
                                                    alt="{{ $testimonial->name }}"
                                                    class="object-cover w-full h-full rounded-lg">
                                            </div>

                                            <!-- Testimonial Content Container -->
                                            <div
                                                class="relative z-10 w-full max-w-2xl px-4 text-center text-white mt-4">
                                                <div class="min-h-auto"> <!-- Tinggi minimum -->
                                                    <p
                                                        class="text-sm md:text-md italic leading-relaxed break-words whitespace-pre-line line-clamp-6 hover:line-clamp-none">
                                                        "{{ $testimonial->testimoni }}"
                                                    </p>
                                                </div>
                                                <div class="mb-4 mt-4">
                                                    <p class="font-bold text-lg md:text-2xl">{{ $testimonial->nama }},
                                                        {{ $testimonial->lokasi_tinggal }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    @php
                        $activeBanner = \App\Models\Banner::where('is_active', true)->first();
                        $activePartner = \App\Models\Partnership::where('is_active', true)->first();
                    @endphp

                    @if ($activeBanner)
                        <div
                            class="w-full md:w-auto banner-container md:mx-auto md:px-4  flex items-center justify-center md:mt-0 mt-8">
                            <div class="text-center w-full">
                                <a href="#kontak-kami" rel="noopener noreferrer">
                                    <!-- Gambar untuk mobile -->
                                    <img src="{{ $activeBanner->mobile_image_url }}"
                                        alt="{{ $activeBanner->alt_text }}"
                                        class="rounded-lg mx-auto w-full md:hidden">

                                    <!-- Gambar untuk desktop -->
                                    <img src="{{ $activeBanner->desktop_image_url }}"
                                        alt="{{ $activeBanner->alt_text }}"
                                        class="rounded-lg mx-auto w-full hidden md:block">
                                </a>
                            </div>
                        </div>
                    @endif


                    @if ($activePartner)
                        <div
                            class="w-full md:w-auto banner-container md:mx-auto md:px-4 flex items-center justify-center mt-8 mb-8">
                            <div class="text-center w-full">
                                <a href="#kontak-kami" rel="noopener noreferrer">
                                    <!-- Gambar untuk mobile -->
                                    <img src="{{ $activePartner->mobile_image_url }}"
                                        alt="{{ $activePartner->alt_text }}"
                                        class="rounded-lg mx-auto w-full md:hidden">

                                    <!-- Gambar untuk desktop -->
                                    <img src="{{ $activePartner->desktop_image_url }}"
                                        alt="{{ $activePartner->alt_text }}"
                                        class="rounded-lg mx-auto w-full hidden md:block">
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            <div id="kontak-kami" class="relative flex flex-col justify-between h-full md:min-h-screen z-20 w-full">

                <div class="w-full text-center">

                    <div class="w-full flex justify-center">
                        <div class="relative w-full max-w-full overflow-hidden rounded-t-[100px] md:rounded-t-[300px]">
                            <div class="absolute inset-0 bg-black opacity-70 z-10"></div>
                            <!-- Gambar background dengan container yang membatasi -->
                            <img src="{{ asset('Image/background 3.jpg') }}" alt="Salon"
                                class="w-full h-[230px] md:h-auto md:max-h-screen object-cover z-10">

                            <!-- Teks utama di atas gambar -->
                            <div
                                class="absolute top-[10%] md:top-[30%] left-0 right-0 z-30 text-center pt-10 justify-center mx-2 md:mx-20">
                                <h1 class="text-xl md:text-[60px] text-white font-bold mb-2 md:mb-8">Gaya Terbaik,
                                    Langsung di Rumah
                                </h1>
                                <p
                                    class="text-sm md:text-[30px] text-white w-full text-center mb-2 md:mb-8 break-words whitespace-normal leading-normal">
                                    Jadwalkan
                                    haircut premium
                                    kamu sekarang dan nikmati layanan personalisasi langsung di rumah.</p>
                                <a href="{{ route('booking.index', ['from' => 'homecare']) }}">
                                    <button
                                        class="px-4 pt-[9px] pb-[6px] bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95">
                                        Booking Sekarang
                                    </button>
                                </a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/carouselHomecare2.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/js/splide.min.js"></script>
</x-layout>
