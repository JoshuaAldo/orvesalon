<x-layout :fromHomeOrHomecare="$fromHomeOrHomecare">
    <div
        class="flex flex-col-reverse md:flex-row justify-between max-w-screen-xl mx-auto min-h-screen px-4 md:mt-0 mt-6 mb-4">
        <!-- Kolom kiri: Testimonial -->
        <div class="w-full md:w-1/2 max-w-2xl flex flex-col justify-center items-center py-12 md:mr-4">
            @if ($testimonials->count() > 0)
                <div class="relative w-full max-w-md" id="testimonial-carousel">
                    <!-- Carousel container -->
                    <div class="relative h-[500px]">
                        @foreach ($testimonials as $index => $testimonial)
                            <div class="testimonial-slide transition-opacity duration-1000 ease-in-out absolute inset-0
                                    {{ $index !== 0 ? 'opacity-0' : 'opacity-100' }}"
                                id="testimonial-{{ $index }}">
                                <!-- Background Image -->
                                <div class="absolute inset-0 z-0">
                                    <img src="{{ asset('storage/' . $testimonial->image_path) }}"
                                        alt="{{ $testimonial->name }}" class="object-cover w-full h-full rounded-lg">
                                    <div class="absolute inset-0 bg-black bg-opacity-30 rounded-lg"></div>
                                </div>

                                <!-- Content Container -->
                                <div
                                    class="absolute top-3/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 w-full max-w-2xl px-4 text-center text-white">
                                    <!-- Name and Role -->
                                    <div class="mb-4 flex justify-center">
                                        <span
                                            class="inline-block border-2 border-white rounded-[26px] px-8 pt-[4px] mr-4 text-md">
                                            {{ $testimonial->name }}
                                        </span>
                                        <span
                                            class="inline-block border-2 border-white rounded-[26px] px-8 pt-[4px] text-md">
                                            {{ $testimonial->role }}
                                        </span>
                                    </div>
                                    <!-- Testimonial Text -->
                                    <div class="pl-8 pr-8">
                                        <p class="text-lg leading-relaxed font-semibold">
                                            "{{ $testimonial->content }}"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-center py-8 text-gray-500">Belum ada testimonial</p>
            @endif
        </div>

        <!-- Kolom Kanan: Form -->
        <div class="w-full md:w-1/2 max-w-md mx-auto flex flex-col justify-center items-center md:min-h-screen">
            <div class="w-full text-left">
                <h2 class="text-3xl md:text-4xl font-custom">Tinggal duduk manis,</h2>
                <h2 class="text-3xl md:text-4xl font-[1000] mb-6 ">kami yang datang.</h2>
            </div>
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            @error('schedule_id')
                <div class="text-red-800 text-center bg-red-100 p-3 rounded mb-4">
                    {{ $message }}
                </div>
            @enderror

            <form id="bookingForm" method="POST" action="{{ route('booking.store') }}" class="w-full">
                @csrf

                <div class="mb-4">
                    <input type="text" name="name" class="w-full border rounded px-3 py-2"
                        placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                </div>

                <div class="mb-4">
                    <input type="text" name="phone" class="w-full border rounded px-3 py-2"
                        placeholder="Nomor Whatsapp Aktif" inputmode="numeric" pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('phone') }}" required>
                </div>

                <div class="mb-4">
                    <input type="email" name="email" class="w-full border rounded px-3 py-2" placeholder="Email"
                        value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <input type="text" name="address" class="w-full border rounded px-3 py-2"
                        value="{{ old('address') }}" placeholder="Alamat Lengkap" required>
                </div>

                <!-- Select Layanan -->
                <select name="service_id" id="service-select"
                    class="w-full border px-3 py-2 rounded text-gray-700 mb-2 appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                    <option value="" disabled selected class="text-gray-400">Pilih Layanan</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->price }}"
                            @if ($service->promo_price) data-promo="{{ $service->promo_price }}" @endif
                            class="text-black" @if (old('service_id') == $service->id) selected @endif>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>

                <div class="mb-4">
                    <!-- Wrapper seperti input dengan border, padding, dan rounded -->
                    <div id="price-wrapper"
                        class="w-full border px-3 py-2 rounded text-gray-400 bg-white flex items-center">
                        <!-- Harga asli yang akan diberi coret -->
                        <span id="price" data-placeholder="Harga" class="text-black"></span>
                        <!-- Harga promo, tampil di samping kanan -->
                        <span id="promo-price" class="text-red-500 font-bold ml-2 hidden"></span>
                    </div>
                </div>

                <select name="location_id" id="location-select"
                    class="w-full border px-3 py-2 rounded text-gray-700 mb-4 bg-white appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                    <option value="" disabled selected class="text-gray-400">Pilih Lokasi</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" class="text-black"
                            @if (old('location_id') == $location->id) selected @endif>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>

                {{--
                <div id="hairdresser-wrapper" class="mb-4 hidden">
                    <label for="hairdresser-select"
                        class="block text-sm font-medium text-gray-700 mb-1">Hairdresser</label>
                    <select name="hairdresser_id" id="hairdresser-select"
                        class="w-full border px-3 py-2 rounded text-gray-700 bg-white appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                        <option value="" disabled selected class="text-gray-400">Pilih Hairdresser</option>
                        //Opsi hairdresser akan diisi oleh JavaScript
                    </select>
                    <p id="hairdresser-loading" class="text-sm text-gray-500 mt-1 hidden">Memuat hairdresser...</p>
                    <p id="hairdresser-none" class="text-sm text-red-500 mt-1 hidden">Tidak ada hairdresser yang
                        tersedia untuk kombinasi layanan dan lokasi ini.</p>
                </div>  --}}

                {{-- <div id="calendar-wrapper" class="mb-4 hidden">
                    <label for="date-picker" class="block text-sm font-medium text-gray-700 mb-1">Pilih
                        Tanggal</label>
                    <input type="text" id="date-picker" name="booking_date"
                        class="w-full border px-3 py-2 rounded text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Pilih tanggal dari kalender" readonly>
                    <p id="date-loading" class="text-sm text-gray-500 mt-1 hidden">Memuat tanggal tersedia...</p>
                    <p id="date-none" class="text-sm text-red-500 mt-1 hidden">Tidak ada tanggal tersedia untuk
                        hairdresser ini.</p>
                </div> --}}

                {{-- <div id="time-slot-wrapper" class="mb-4 hidden">
                    <label for="time-slot-select" class="block text-sm font-medium text-gray-700 mb-1">Pilih
                        Jam</label>
                    <select name="booking_time" id="time-slot-select"
                        class="w-full border px-3 py-2 rounded text-gray-700 bg-white appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                        <option value="" disabled selected class="text-gray-400">Pilih Jam</option>

                    </select>
                    <p id="time-loading" class="text-sm text-gray-500 mt-1 hidden">Memuat jam tersedia...</p>
                    <p id="time-none" class="text-sm text-red-500 mt-1 hidden">Tidak ada jam tersedia pada tanggal
                        ini.</p>
                </div> --}}

                <div id="calendar-wrapper" class="mb-4 hidden">
                    <label for="date-picker" class="block text-sm font-medium text-gray-700 mb-1">Pilih
                        Tanggal</label>
                    <input type="text" id="date-picker" name="booking_date"
                        class="w-full border px-3 py-2 rounded text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Pilih tanggal dari kalender" readonly required>
                    <p id="date-loading" class="text-sm text-gray-500 mt-1 hidden">Memuat tanggal...</p>
                    <p id="date-none" class="text-sm text-red-500 mt-1 hidden">Tidak ada tanggal tersedia untuk
                        layanan ini.</p>
                </div>

                <div id="time-slot-wrapper" class="mb-4 hidden">
                    <label for="time-slot-select" class="block text-sm font-medium text-gray-700 mb-1">Pilih
                        Jam</label>
                    {{-- Nama diubah menjadi schedule_id, karena value-nya akan schedule_id --}}
                    <select name="booking_time" id="time-slot-select"
                        class="w-full border px-3 py-2 rounded text-gray-400 bg-white appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                        <option value="" disabled selected class="text-gray-400">Pilih Jam</option>
                    </select>
                    <p id="time-loading" class="text-sm text-gray-500 mt-1 hidden">Memuat jam...</p>
                    <p id="time-none" class="text-sm text-red-500 mt-1 hidden">Tidak ada jam tersedia.</p>
                </div>


                <div class="mb-4">
                    <textarea name="notes" class="w-full border rounded px-3 py-2 min-h-[100px]"
                        placeholder="Catatan Tambahan (Opsional)"></textarea>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full px-4 py-2 bg-orangeBtn text-white font-semibold rounded-lg hover:bg-orangeHoverBtn transition duration-200 transform hover:scale-95 cursor-not-allowed"
                    disabled>
                    Booking Sekarang
                </button>
            </form>
        </div>
    </div>
    <!-- Modal Konfirmasi -->
    <div id="confirmModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-4 pl-3">Konfirmasi Booking</h3>
                <div id="confirmContent">
                    <!-- Konten akan diisi oleh JavaScript -->
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button id="cancelConfirm" type="button" class="px-4 py-2 border rounded-lg">Batal</button>
                    <button id="proceedPayment" type="button"
                        class="px-4 py-2 bg-orangeBtn text-white rounded-lg">Bayar
                        Sekarang</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pembayaran -->
    <div id="paymentModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Pembayaran</h3>
                <button id="closePaymentModal" type="button" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
            <div id="payment-container" class="p-6 min-h-[300px] flex items-center justify-center">
                <!-- Tempat Snap widget akan dirender -->
            </div>
        </div>
    </div>

    {{-- <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script> --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            if (!document.querySelector('input[name="schedule_id"]').value) {
                e.preventDefault();
                alert('Silakan pilih jadwal terlebih dahulu');
                return false;
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const bookingForm = document.getElementById('bookingForm');
            const submitBtn = document.getElementById('submitBtn');
            const confirmModal = document.getElementById('confirmModal');
            const paymentModal = document.getElementById('paymentModal');
            const cancelConfirm = document.getElementById('cancelConfirm');
            const proceedPayment = document.getElementById('proceedPayment');
            const closePaymentModal = document.getElementById('closePaymentModal');

            // Handle form submission
            bookingForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Validasi form sebelum submit
                if (!bookingForm.checkValidity()) {
                    bookingForm.reportValidity();
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = `
               <span class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></span>
               Memproses...
           `;

                try {
                    const formData = new FormData(bookingForm);
                    const response = await fetch(bookingForm.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }
                    const rawDate = data.booking.schedule; // "2025-05-29T15:00:00.000000Z"

                    // Pisahkan tanggal dan waktu
                    const [datePart, timePartFull] = rawDate.split(
                        'T'); // ["2025-05-29", "15:00:00.000000Z"]
                    const [year, month, day] = datePart.split('-');
                    const timePart = timePartFull.substring(0, 5); // Ambil "15:00"

                    // Buat array nama bulan
                    const monthNames = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];

                    // Ambil nama bulan dari angka (ingat index dimulai dari 0)
                    const monthName = monthNames[parseInt(month, 10) - 1];

                    // Gabungkan hasil akhir
                    const formattedDate = `${day} ${monthName} ${year} ${timePart} WIB`;
                    // Tampilkan modal konfirmasi
                    document.getElementById('confirmContent').innerHTML = `
                   <p class="pl-3">Anda akan melakukan pembayaran untuk:</p>
                   <div class="mt-3 p-3 bg-gray-50 rounded">
                       <p><strong>Layanan:</strong> ${data.booking.service_name}</p>
                       <p><strong>Atas Nama:</strong> ${data.booking.customer_name}</p>
                       <p><strong>No Whatsapp Aktif:</strong> ${data.booking.phone}</p>
                       <p><strong>Email:</strong> ${data.booking.email}</p>
                       <p><strong>Alamat:</strong> ${data.booking.address}</p>
                       <p><strong>Jadwal:</strong> ${formattedDate}</p>
                       <p><strong>Total Pembayaran:</strong> Rp ${Math.floor(Number(data.booking.price)).toLocaleString('id-ID')}</p>
                   </div>
                   <div class="flex items-center mt-3 bg-yellow-100 text-yellow-700 px-4 py-2 rounded mb-4">
  <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
  </svg>
  Pastikan Data Sudah Benar!
</div>
                   <p class="mt-3 px-4">Lanjutkan ke pembayaran?</p>
               `;

                    confirmModal.classList.remove('hidden');

                    // Simpan booking ID untuk proses selanjutnya
                    proceedPayment.dataset.bookingId = data.booking.id;
                    proceedPayment.dataset.bookingUUID = data.booking.uuid;

                } catch (error) {
                    console.error('Error:', error);
                    alert(error.message || 'Terjadi kesalahan saat memproses booking');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Booking Sekarang';
                }
            });

            // Handle tombol Bayar Sekarang
            document.getElementById('proceedPayment').addEventListener('click', async function() {
                const bookingId = this.dataset.bookingId;
                const bookingUUID = this.dataset.bookingUUID;
                const paymentModal = document.getElementById('paymentModal');

                // Tutup modal konfirmasi
                confirmModal.classList.add('hidden');

                // Tampilkan loading di modal pembayaran
                paymentModal.classList.remove('hidden');
                document.getElementById('payment-container').innerHTML =
                    '<p>Mempersiapkan pembayaran...</p>';

                try {
                    // Dapatkan snap token
                    const response = await fetch(`/booking/${bookingId}/generate-payment-token`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || 'Gagal memproses pembayaran');
                    }

                    // Pastikan Snap.js sudah terload
                    if (typeof snap === 'undefined') {
                        throw new Error('Midtrans Snap.js belum terload');
                    }

                    // Render Snap payment (versi alternatif)
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = `/booking/finish/${bookingUUID}`;
                        },
                        onPending: function(result) {
                            window.location.href =
                                `/booking/`;
                        },
                        onError: function(result) {
                            window.location.href = `/booking/failed`;
                        },
                        onClose: function() {
                            window.location.href = `/booking/`;
                        }
                    });


                } catch (error) {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                    paymentModal.classList.add('hidden');
                }
            });

            // Tutup modal konfirmasi
            cancelConfirm.addEventListener('click', function() {
                confirmModal.classList.add('hidden');
            });

            // Tutup modal pembayaran
            closePaymentModal.addEventListener('click', function() {
                paymentModal.classList.add('hidden');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        const fetchAvailableDatesUrl = @json(route('dates.getAvailable'));
        const fetchAvailableTimesUrl = @json(route('times.getAvailable'));
        const oldServiceId = @json(old('service_id'));
        const oldLocationId = @json(old('location_id'));
        const oldBookingDate = @json(old('booking_date'));
        const oldScheduleId = @json(old('schedule_id'));
    </script>
    <script src="{{ asset('js/booking1.js') }}"></script>
</x-layout>
