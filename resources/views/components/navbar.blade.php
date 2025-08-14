@props(['fromHomeOrHomecare' => 'default'])
@php
    $isBookingPage = Route::currentRouteName() === 'booking.index';
    $isHomePage = Route::currentRouteName() === 'home';
@endphp

<nav x-data="{ open: false }"
    class="{{ $isBookingPage ? 'relative' : 'fixed bg-transparent' }}  top-0 left-0 w-screen z-50 px-8 py-[16px] md:py-[20px] flex items-center justify-between transition-colors  bg-transparent"
    id="navbar">

    <!-- Logo -->
    <div class="z-50">
        @if ($isBookingPage)
            @if ($fromHomeOrHomecare === 'homecare')
                <a href="{{ url('/homecare') }}" rel="noopener noreferrer">
                    <img src="{{ asset('Image/ORVÉ Salon Logo Black.png') }}" alt=""
                        class="w-[90px] md:w-[135px] absolute top-[10px] md:top-[8px] md:left-[60px]">
                </a>
            @else
                <a href="{{ url('/') }}" rel="noopener noreferrer">
                    <img src="{{ asset('Image/ORVÉ Salon Logo Black.png') }}" alt=""
                        class="w-[90px] md:w-[135px] absolute top-[10px] md:top-[8px] md:left-[60px]">
                </a>
            @endif
        @else
            <a href="" rel="noopener noreferrer">
                <img src="{{ asset('Image/ORVÉ Salon Logo.png') }}" alt=""
                    class="w-[150px] md:w-[250px] absolute top-[-40px] md:top-[-85px] left-[-15px] md:left-[0px]">
            </a>
        @endif
    </div>

    <!-- Hamburger Button -->
    <button @click="open = !open" class="md:hidden z-50 focus:outline-none"
        :class="{ 'text-black': {{ $isBookingPage ? 'true' : 'false' }}, 'text-white': {{ $isBookingPage ? 'false' : 'true' }} }">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <!-- Menu -->
    <ul :class="{ 'hidden': !open, 'flex': open }"
        class="absolute top-full left-0 w-full justify-start md:flex md:static md:w-auto flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8 text-xl font-light z-40  md:mt-2 px-6 md:px-0 py-4 md:py-0
        {{ $isBookingPage ? ' text-right bg-white text-black bg-opacity-80 md:bg-transparent ' : 'text-right bg-black text-white bg-opacity-80 md:bg-transparent ' }}">

        @if ($isBookingPage)
            @if ($fromHomeOrHomecare === 'homecare')
                <li><a href="{{ url('/homecare') }}" class="hover:underline">Home</a></li>
                <li><a href="{{ url('/homecare#tentang-kami') }}" class="hover:underline">Tentang Kami</a></li>
                <li><a href="{{ url('/homecare#services') }}" class="hover:underline">Service</a></li>
                <li><a href="https://wa.me/6283869158630" class="hover:underline" target="_blank">Kontak Kami</a></li>
            @else
                <li><a href="{{ url('/#home') }}" class="hover:underline">Home</a></li>
                <li><a href="{{ url('/#tentang-kami') }}" class="hover:underline">Tentang Kami</a></li>
                <li><a href="{{ url('/#services') }}" class="hover:underline">Service</a></li>
                <li><a href="https://wa.me/6283869158630" class="hover:underline" target="_blank">Kontak Kami</a></li>
            @endif
        @else
            @if ($isHomePage)
                <li class="text-left"><a href="#" @click="open = false" class="hover:underline text-left">Home</a>
                </li>
                <li class="text-left"><a href="#tentang-kami" @click="open = false"
                        class="hover:underline text-left">Tentang Kami</a></li>
                <!-- Service menu -->
                <li class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="inline-flex w-full md:w-auto hover:underline justify-start">
                        Service
                        <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Main Dropdown -->
                    <ul x-show="open" @click.outside="open = false" x-transition
                        class="md:absolute md:right-[-25px] pt-4 w-44 rounded-md bg-black shadow-lg ring-1 ring-black ring-opacity-5 z-50">

                        {{-- Haircut & Styling --}}
                        <li class="relative" x-data="{ openNested: false }">
                            <button @click="openNested = !openNested" type="button"
                                class="flex  w-full px-4 hover:bg-gray-700 text-[16px]">
                                Haircut & Styling
                                <p class="ml-2 mt-[4px] text-sm">></p>
                            </button>

                            <!-- Nested Dropdown -->
                            <ul x-show="openNested" @click.outside="openNested = false" x-transition
                                class="absolute top-[-10px] left-full mt-2 md:mt-0 w-full md:w-32 md:mr-4 justify-center items-center max-w-[90vw] bg-black/80 shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Precision Cut
                                    </a>
                                </li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Luxe
                                        Blowout</a>
                                </li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Signature
                                        Blowout</a></li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Sleek &
                                        Shine</a></li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Bridal
                                        Elegance</a></li>
                            </ul>
                        </li>

                        <!-- Coloring with Nested -->
                        <li class="relative" x-data="{ openNested: false }">
                            <button @click="openNested = !openNested" type="button"
                                class="flex  w-full px-4 hover:bg-gray-700 text-[16px]">
                                Coloring
                                <p class="ml-2 mt-[4px] text-sm">></p>
                            </button>

                            <!-- Nested Dropdown -->
                            <ul x-show="openNested" @click.outside="openNested = false" x-transition
                                class="absolute top-[-10px] left-full mt-2 md:mt-0 w-full md:w-32 md:mr-4 justify-center items-center max-w-[90vw] bg-black/80 shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Balayage
                                        Luxe</a>
                                </li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Face Frame
                                        Glow</a>
                                </li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Color
                                        Radiance
                                        Package</a></li>
                            </ul>
                        </li>

                        <!-- Treatment with Nested -->
                        <li class="relative" x-data="{ openNested: false }">
                            <button @click="openNested = !openNested" type="button"
                                class="flex  w-full px-4 hover:bg-gray-700 text-[16px]">
                                Treatment
                                <p class="ml-2 mt-[4px] text-sm">></p>
                            </button>

                            <!-- Nested Dropdown -->
                            <ul x-show="openNested" @click.outside="openNested = false" x-transition
                                class="absolute top-[-10px] left-full mt-2 md:mt-0 w-full md:w-32 md:mr-4 justify-center items-center max-w-[90vw] bg-black/80 shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Shine
                                        Infusion</a>
                                </li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Scalp
                                        Rejuvenate</a>
                                </li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Hair
                                        Fortify</a></li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Silk
                                        Therapy</a></li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Keratin
                                        Restore</a></li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Bond Repair
                                        Therapy</a></li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Scalp
                                        Detox</a></li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Ultimate
                                        Revive Package</a></li>
                            </ul>
                        </li>

                        <!-- Wellness with Nested -->
                        <li class="relative" x-data="{ openNested: false }">
                            <button @click="openNested = !openNested" type="button"
                                class="flex  w-full px-4 hover:bg-gray-700 text-[16px]">
                                Wellness
                                <p class="ml-2 mt-[4px] text-sm">></p>
                            </button>

                            <!-- Nested Dropdown -->
                            <ul x-show="openNested" @click.outside="openNested = false" x-transition
                                class="absolute top-[-10px] left-full mt-2 md:mt-0 w-full md:w-32 md:mr-4 justify-center items-center max-w-[90vw] bg-black/80 shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Luxury Hand &
                                        Scalp Reflexology</a>
                                </li>
                                <li><a href="{{ route('booking.index', ['from' => 'home']) }}"
                                        @click="open = false; openNested = false"
                                        class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-center">Signature
                                        Glow Package</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="/homecare" @click="open = false"
                                class="block px-4 py-2 hover:bg-gray-700 text-[16px] text-left">Home Care</a></li>
                    </ul>
                </li>


                <li class="text-left"><a href="https://wa.me/6283869158630" class="hover:underline"
                        target="_blank">Kontak Kami</a></li>
            @else
                <li><a href="#home" @click="open = false" class="hover:underline">Home</a></li>
                <li><a href="#tentang-kami" @click="open = false" class="hover:underline">Tentang Kami</a>
                </li>
                <li><a href="#services" class="hover:underline">Service</a></li>
                <li><a href="https://wa.me/6283869158630" class="hover:underline" target="_blank">Kontak
                        Kami</a>
                </li>
            @endif
        @endif

    </ul>
</nav>
