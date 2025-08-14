<x-layout>
    <div class="min-h-screen bg-cover bg-center bg-no-repeat">
        <div class="relative flex flex-col md:flex-row items-center justify-between min-h-screen w-full px-4 md:px-10 z-10 overflow-hidden"
            id="home"
            style="background-image: url('{{ asset('Image/Background.webp') }}');
               background-size: cover;
               background-position: center;">

            <div class="absolute inset-0 bg-black opacity-70"></div>

            <!-- Bagian Kiri (Teks) -->
            <div
                class="w-full md:w-1/2 z-30 md:pl-10 flex flex-col justify-start md:justify-center items-start mt-56 md:mt-0 px-4 md:px-0 md:text-left md:mr-20">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-semibold text-white">The Exclusive</h1>
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-semibold text-white mt-2">Transformation Awaits</h1>
                <p class="text-white text-md md:text-xl mt-2">
                    Setiap helai rambut kamu mencerminkan sebuah cerita. Biarkan ORVÉ membantu menulis cerita terbaikmu.
                </p>
                <a href="{{ route('booking.index', ['from' => 'home']) }}">
                    <button
                        class="flex items-center justify-center px-4 pt-[9px] pb-[6px] bg-orangeBtn text-white font-semibold text-center leading-normal rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 mt-4">
                        Booking Sekarang
                    </button>
                </a>
            </div>

            <!-- Bagian Kanan (Foto) -->
            <div class="w-full md:w-1/2">

                <img src="{{ asset('Image/girl-1.png') }}" alt="Salon"
                    class="absolute bottom-0 right-0 md:right-0 h-[45vh] md:h-[75vh] lg:h-[84vh] w-auto object-cover z-20">
            </div>
        </div>

        <div class="relative flex flex-col-reverse md:flex-row items-center justify-between min-h-screen px-0 md:px-10 overflow-hidden md:pb-0 pb-4"
            id="tentang-kami">
            {{-- kiri --}}
            <div class="relative w-[38vh] md:w-[40vw] h-[47vh] md:h-screen z-30 pl-10 m-8 md:mb-[120px]">
                <!-- Background merah berada di belakang gambar -->
                <div
                    class="absolute w-full h-full bg-redPhoto md:min-w-[130%] rounded-full top-[4vh] md:top-[5vh] left-0 md:left-[-150px]">
                </div>

                <!-- Foto berbentuk bulat dengan posisi tetap -->
                <img src="{{ asset('Image/girl-2.jpg') }}" alt="Girl Photo"
                    class="rounded-full w-full md:min-w-[130%] h-full md:h-screen object-cover absolute top-0 left-0 md:left-[-150px]"
                    style="object-position: top;">
            </div>

            {{-- kanan --}}
            <div class="relative w-full md:w-3/4 px-8 md:px-0 md:ml-10 md:mr-10">
                <h2 class="text-2xl mt-6 text-center mb-2 md:mb-4 md:text-left md:mt-0 md:text-4xl font-semibold">
                    Tentang Kami</h2>
                <p class="text-md md:text-2xl text-justify">Di ORVÉ, kami percaya bahwa rambut bukan sekadar gaya—ia
                    adalah
                    identitas, refleksi
                    kepribadian, dan
                    simbol keanggunan.</p>
                <br>
                <p class="text-md md:text-2xl text-justify">Kami menghadirkan pengalaman salon premium dengan standar
                    tertinggi,
                    diciptakan untuk
                    mereka yang
                    menghargai presisi, inovasi, dan personalisasi. Setiap layanan dirancang untuk memberikan
                    transformasi eksklusif, di tangan hairstylist profesional yang memahami seni dan ilmu dalam setiap
                    potongan.</p>
                <br>
                <p class="text-md md:text-2xl text-justify">Setiap helai rambut membawa kisah, dan di ORVÉ, kami
                    memastikan kisah
                    itu diceritakan dengan keanggunan.</p>
                <br>
                <p class="text-md md:text-2xl text-justify font-bold">The Exclusive Transformation Awaits.</p>
            </div>
        </div>

        <div class="relative w-full flex flex-col items-center mt-32 md:mt-0 ">
            <!-- Kartu Melengkung -->
            <div
                class="relative w-[95%] max-w-full md:w-[70%] bg-cream rounded-l-[150px] p-10 text-white text-left shadow-lg ml-auto h-[82px] md:h-[200px] z-30 flex items-center">
                <h2 class="text-[12px] md:text-4xl font-semibold md:ml-[40px]">Eksklusivitas Dimulai dari Sini.</h2>

                <!-- Gambar Orang -->
                <img src="{{ asset('Image/girl-3.png') }}" alt="Model"
                    class="absolute right-[-3px] md:right-[5px] top-[-150%] md:top-[-250px] h-[250%] md:h-[450px] max-w-[100vw] w-auto object-cover z-50">
            </div>

            <!-- Bagian Layanan -->
            <div
                class="relative w-full h-auto md:h-[464px] -mt-12 md:-mt-28 bg-[radial-gradient(circle_at_top,_rgba(232,179,73,1),_rgba(196,142,52,1))] rounded-[40px] md:rounded-[110px] p-10 text-white flex justify-around z-20">

                <div
                    class="flex flex-col md:flex-row mt-[40px] md:mt-[100px] md:justify-between gap-y-10 md:gap-x-20 items-center md:items-start w-full">
                    <div class="w-full md:w-1/3 text-center">
                        <div class="flex justify-center">
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.0764 11.9117C10.7406 12.1367 10.4736 12.4502 10.3047 12.8175C10.1359 13.1848 10.0719 13.5916 10.1197 13.993L10.8524 21.6627C11.0172 23.3964 11.8225 25.0065 13.1108 26.1783C14.3992 27.3502 16.0781 27.9997 17.8197 28H21C21.5417 28.0008 22.0663 28.1901 22.4836 28.5354C22.901 28.8807 23.1853 29.3605 23.2877 29.8924C23.39 30.4244 23.3041 30.9753 23.0447 31.4509C22.7852 31.9264 22.3684 32.2968 21.8657 32.4987L16.4057 34.685C14.3407 35.511 13.7877 37.765 14.8564 39.193C15.5284 40.089 16.2004 40.8987 16.8164 41.517C17.36 42.0606 18.0577 42.6487 18.8347 43.2437C20.279 44.352 22.6264 43.743 23.3614 41.531L25.788 34.2627C25.9431 33.7984 26.2402 33.3946 26.6374 33.1085C27.0346 32.8224 27.5117 32.6685 28.0012 32.6685C28.4907 32.6685 28.9678 32.8224 29.365 33.1085C29.7622 33.3946 30.0593 33.7984 30.2144 34.2627L32.6364 41.531C33.3737 43.743 35.721 44.3543 37.1654 43.246C37.874 42.7128 38.5481 42.1354 39.1837 41.517C39.802 40.8987 40.474 40.089 41.1437 39.193C42.2124 37.765 41.6617 35.511 39.5944 34.685L34.1344 32.4987C33.6317 32.2968 33.2149 31.9264 32.9554 31.4509C32.696 30.9753 32.6101 30.4244 32.7124 29.8924C32.8148 29.3605 33.099 28.8807 33.5164 28.5354C33.9338 28.1901 34.4583 28.0008 35 28H38.1804C39.922 27.9997 41.6009 27.3502 42.8892 26.1783C44.1776 25.0065 44.9828 23.3964 45.1477 21.6627L45.8804 13.993C45.9282 13.5916 45.8642 13.1848 45.6953 12.8175C45.5265 12.4502 45.2595 12.1367 44.9237 11.9117C44.6303 11.7065 44.2811 11.5964 43.9231 11.5959C43.5651 11.5955 43.2156 11.7049 42.9217 11.9093C36.75 15.8947 33.4717 19.9407 30.0884 26.7097C29.8948 27.0979 29.5969 27.4246 29.228 27.6529C28.8591 27.8812 28.4339 28.0022 28 28.0022C27.5662 28.0022 27.141 27.8812 26.7721 27.6529C26.4032 27.4246 26.1052 27.0979 25.9117 26.7097C22.5284 19.9407 19.25 15.8947 13.0784 11.9093C12.7845 11.7049 12.435 11.5955 12.077 11.5959C11.719 11.5964 11.3698 11.7065 11.0764 11.9117ZM5.47636 14.4363C4.97003 9.13032 10.6564 4.79032 15.61 7.98932C21.3034 11.6667 24.878 15.491 28 20.7667C31.122 15.491 34.6967 11.6667 40.39 7.98932C45.3437 4.79032 51.03 9.13266 50.526 14.4363L49.7934 22.106C49.6045 24.0946 48.9083 26.0015 47.7713 27.6439C46.6342 29.2863 45.0946 30.6092 43.2997 31.486C46.4007 33.9103 47.5417 38.4347 44.8794 41.9907C44.1397 42.9777 43.3184 43.981 42.483 44.8163C41.7434 45.556 40.873 46.2817 40.005 46.949C35.6184 50.3113 29.7967 47.7657 28.21 43.0057L28 42.378L27.79 43.008C26.2034 47.768 20.3817 50.3113 15.995 46.949C15.1245 46.2915 14.2969 45.5791 13.517 44.8163C12.6541 43.9308 11.8534 42.9866 11.1207 41.9907C8.45836 38.4347 9.6017 33.9103 12.7027 31.486C10.9074 30.6095 9.36724 29.2867 8.2298 27.6443C7.09236 26.0019 6.39575 24.0949 6.2067 22.106L5.47636 14.4363Z"
                                    fill="white" />
                            </svg>

                        </div>
                        <h3 class="font-semibold text-lg md:text-4xl">Modern Lifestyle</h3>
                        <h3 class="font-semibold text-lg md:text-4xl">Concept</h3>
                        <p class="text-md md:text-lg px-4 md:px-0">Salon premium yang merefleksikan
                        </p>
                        <p class="text-md md:text-lg px-4 md:px-0">gaya hidup
                            modern.
                        </p>
                    </div>

                    <div class="w-full md:w-1/3 text-center">
                        <div class="flex justify-center">
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M38.1734 32.6666C38.3601 31.1266 38.5001 29.5866 38.5001 28C38.5001 26.4133 38.3601 24.8733 38.1734 23.3333H46.0601C46.4334 24.8266 46.6667 26.39 46.6667 28C46.6667 29.61 46.4334 31.1733 46.0601 32.6666M34.0434 45.6399C35.4434 43.0499 36.5167 40.25 37.2634 37.3333H44.1467C41.8861 41.2259 38.2997 44.1746 34.0434 45.6399ZM33.4601 32.6666H22.5401C22.3067 31.1266 22.1667 29.5866 22.1667 28C22.1667 26.4133 22.3067 24.85 22.5401 23.3333H33.4601C33.6701 24.85 33.8334 26.4133 33.8334 28C33.8334 29.5866 33.6701 31.1266 33.4601 32.6666ZM28.0001 46.5733C26.0634 43.7733 24.5001 40.67 23.5434 37.3333H32.4567C31.5001 40.67 29.9367 43.7733 28.0001 46.5733ZM18.6667 18.6666H11.8534C14.0902 14.763 17.6743 11.8095 21.9334 10.36C20.5334 12.95 19.4834 15.75 18.6667 18.6666ZM11.8534 37.3333H18.6667C19.4834 40.25 20.5334 43.0499 21.9334 45.6399C17.6827 44.1753 14.1034 41.2257 11.8534 37.3333ZM9.94008 32.6666C9.56675 31.1733 9.33341 29.61 9.33341 28C9.33341 26.39 9.56675 24.8266 9.94008 23.3333H17.8267C17.6401 24.8733 17.5001 26.4133 17.5001 28C17.5001 29.5866 17.6401 31.1266 17.8267 32.6666M28.0001 9.40329C29.9367 12.2033 31.5001 15.33 32.4567 18.6666H23.5434C24.5001 15.33 26.0634 12.2033 28.0001 9.40329ZM44.1467 18.6666H37.2634C36.532 15.777 35.4507 12.9875 34.0434 10.36C38.3367 11.83 41.9067 14.7933 44.1467 18.6666ZM28.0001 4.66663C15.0967 4.66663 4.66675 15.1666 4.66675 28C4.66675 34.1883 7.12507 40.1233 11.5009 44.4991C13.6676 46.6658 16.2399 48.3845 19.0708 49.5571C21.9017 50.7297 24.9359 51.3333 28.0001 51.3333C34.1885 51.3333 40.1234 48.875 44.4992 44.4991C48.8751 40.1233 51.3334 34.1883 51.3334 28C51.3334 24.9358 50.7299 21.9016 49.5573 19.0707C48.3847 16.2397 46.6659 13.6675 44.4992 11.5008C42.3325 9.3341 39.7603 7.61538 36.9294 6.44277C34.0984 5.27016 31.0643 4.66663 28.0001 4.66663Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-lg md:text-4xl">Seamless Digital Experience</h3>
                        <p class="text-md md:text-lg px-4 md:px-0">Pengalaman digital terintegrasi</p>
                        <p class="text-md md:text-lg px-4 md:px-0">untuk kenyamanan
                            tanpa hambatan.</p>
                    </div>

                    <div class="w-full md:w-1/3 text-center">
                        <div class="flex justify-center">
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M42.9101 33.9733C38.9901 31.9666 33.9034 30.3333 28.0001 30.3333C22.0967 30.3333 17.0101 31.9666 13.0901 33.9733C11.9515 34.5597 10.9978 35.4501 10.3346 36.5457C9.6715 37.6413 9.32493 38.8993 9.3334 40.1799V46.6666H46.6667V40.1799C46.6667 37.5666 45.2434 35.1633 42.9101 33.9733ZM22.8201 27.9999H33.1801C36.0034 27.9999 38.1734 25.5266 37.8001 22.7266L37.0534 17.0099C36.3301 12.5766 32.4801 9.33325 28.0001 9.33325C23.5201 9.33325 19.6701 12.5766 18.9467 17.0099L18.2001 22.7266C17.8267 25.5266 19.9967 27.9999 22.8201 27.9999Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-lg md:text-4xl">Personalized Grooming Experience</h3>
                        <p class="text-md md:text-lg px-4 md:px-0">Grooming eksklusif yang disesuaikan</p>
                        <p class="text-md md:text-lg px-4 md:px-0">dengan karakter
                            dan kebutuhan kamu.</p>
                    </div>
                </div>
            </div>

        </div>
        <div
            style="background-image: url('{{ asset('Image/black background 1.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <div id="services"
                class="relative flex flex-col justify-between min-h-screen px-8 md:px-10 z-10 w-full pb-8 -mt-28">

                <div class="w-full text-center">
                    <h1 class="font-bold text-2xl md:text-4xl text-white mt-40 md:mt-48">Layanan Yang Bisa Kamu
                        Dapatkan di
                        ORVÉ
                    </h1>

                    <div id="splide-carousel" class="splide w-full lg:w-[940px]  mx-auto mt-4"
                        data-total-slides="{{ count($carousels) }}">
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


                    <div class="w-full flex justify-center mt-2 md:mt-10">
                        <div class="relative w-full max-w-[1500px] mx-auto overflow-hidden rounded-3xl">
                            <!-- Background image -->
                            <img src="{{ asset('Image/backgorund carousel.jpg') }}" alt="Salon"
                                class="w-full h-[550px] md:h-auto max-h-[800px] object-cover">

                            <!-- Text overlay -->
                            <div class="absolute top-0 md:top-10 left-0 right-0 z-30 text-center pt-10">
                                <h2 class="text-2xl md:text-4xl text-white font-bold mb-4 mx-4">Transformasi
                                    berbicara
                                    lebih
                                    dari kata-kata.</h2>
                                <p class="px-[24px] md:px-0 text-md md:text-lg text-white">Lihat bagaimana ORVÉ
                                    menciptakan
                                    keindahan
                                    dalam setiap detail.</p>
                            </div>

                            <div class="absolute top-[200px] left-0 right-0 z-20 w-full px-4 md:px-8">
                                <div id="splide-second-carousel" class="splide w-full"
                                    data-total-slides="{{ count($carouselsSecond) }}">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            @foreach ($carouselsSecond as $carouselSecond)
                                                <li class="splide__slide">
                                                    <div class="flex flex-col items-center">
                                                        <!-- Top label -->
                                                        <div class="mb-2">
                                                            <h2
                                                                class="text-sm md:text-xl text-white font-bold bg-[#B29100] pt-[6px] pb-[3px] md:pt-[9px] md:pb-[6px] px-4 md:px-6 rounded-3xl shadow-md whitespace-nowrap">
                                                                {{ $carouselSecond->title }}
                                                            </h2>
                                                        </div>

                                                        <!-- Image with custom landscape size -->
                                                        <div class="w-full h-[250px] md:h-[400px]">
                                                            <img src="{{ asset('storage/' . $carouselSecond->image) }}"
                                                                alt="{{ $carouselSecond->title }}"
                                                                class="w-full h-full object-cover rounded-[20px]">
                                                        </div>

                                                        <!-- Description -->
                                                        <h3
                                                            class="text-center text-white text-xs md:text-base mt-2 px-2">
                                                            {{ $carouselSecond->description }}
                                                        </h3>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <!-- Navigation -->
                                    <div class="splide__arrows">
                                        <button class="splide__arrow splide__arrow--prev text-white">‹</button>
                                        <button class="splide__arrow splide__arrow--next text-white">›</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="section4" class="relative flex flex-col justify-between h-full md:min-h-screen z-20 w-full">

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
                                <h1 class="text-[20px] md:text-[60px] text-white font-bold mb-2 md:mb-8">Waktunya
                                    tampil
                                    lebih
                                    percaya
                                    diri.
                                </h1>
                                <p class="text-[12px] md:text-[30px] text-white w-full text-center">
                                    Jadwalkan
                                    perawatan
                                    rambut
                                    kamu hari ini dan rasakan</p>
                                <p class="text-[12px] md:text-[30px] text-white w-full text-center mb-4 md:mb-8">
                                    pengalaman
                                    perawatan premium
                                    yang sesungguhnya.</p>
                                <a href="{{ route('booking.index', ['from' => 'home']) }}">
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
    </div>

    <script src="{{ asset('js/carouselHome1.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/js/splide.min.js"></script>
</x-layout>
