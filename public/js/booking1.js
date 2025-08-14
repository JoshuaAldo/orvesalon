let lastSelected = null;

function handleScheduleSelection(clickedElement) {
    const radioInput = clickedElement.parentElement.querySelector(
        'input[type="radio"][name="schedule_id"]'
    );
    const scheduleIdInput = document.querySelector('input[name="schedule_id"]');
    const submitBtn = document.querySelector("#submitBtn"); // Pastikan ada ID ini di tombol submit

    if (clickedElement.classList.contains("bg-[#B29100]")) {
        // Unselect
        clickedElement.classList.remove("bg-[#B29100]", "text-white");
        radioInput.checked = false;
        scheduleIdInput.value = "";

        // Nonaktifkan tombol submit
        submitBtn.disabled = true;
        submitBtn.classList.add("opacity-50", "cursor-not-allowed");
    } else {
        // Select new
        document.querySelectorAll(".schedule-item").forEach((item) => {
            item.classList.remove("bg-[#B29100]", "text-white");
        });

        clickedElement.classList.add("bg-[#B29100]", "text-white");
        radioInput.checked = true;
        scheduleIdInput.value = radioInput.value;

        // Aktifkan tombol submit
        submitBtn.disabled = false;
        submitBtn.classList.remove("opacity-50", "cursor-not-allowed");
    }
}

document
    .getElementById("service-select")
    .addEventListener("change", function () {
        if (this.value !== "") {
            this.classList.add("text-black");
            this.classList.remove("text-gray-400");
        } else {
            this.classList.remove("text-black");
            this.classList.add("text-gray-400");
        }
    });

document
    .getElementById("location-select")
    .addEventListener("change", function () {
        if (this.value !== "") {
            this.classList.add("text-black");
            this.classList.remove("text-gray-400");
        } else {
            this.classList.remove("text-black");
            this.classList.add("text-gray-400");
        }
    });

document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.getElementById("testimonial-carousel");
    const items = carousel
        ? carousel.querySelectorAll(".testimonial-slide")
        : [];
    let currentIndex = 0;
    const intervalDuration = 5000; // 5 detik per slide

    // Fungsi untuk menampilkan gambar berdasarkan indeks
    function showItem(index) {
        items.forEach((item, i) => {
            if (i === index) {
                item.classList.remove("opacity-0");
                item.classList.add("opacity-100");
            } else {
                item.classList.remove("opacity-100");
                item.classList.add("opacity-0");
            }
        });
    }

    // Fungsi untuk berpindah ke gambar berikutnya
    function nextItem() {
        currentIndex = (currentIndex + 1) % items.length; // Mengatur index ke gambar berikutnya
        showItem(currentIndex);
    }

    // Mulai interval untuk ganti gambar otomatis
    setInterval(nextItem, intervalDuration);
});

$(document).ready(function () {
    const $serviceSelect = $('#service-select');
    const $locationSelect = $('#location-select');

    const $calendarWrapper = $('#calendar-wrapper');
    const $datePicker = $('#date-picker');
    const $dateLoading = $('#date-loading');
    const $dateNone = $('#date-none');

    const $timeSlotWrapper = $('#time-slot-wrapper');
    const $timeSlotSelect = $('#time-slot-select'); // name="schedule_id"
    const $timeLoading = $('#time-loading');
    const $timeNone = $('#time-none');

    const $priceElement = $('#price');
    const $promoPriceElement = $('#promo-price');
    const $submitBtn = $('#submitBtn');

    let availableDatesForCalendar = [];

    // --- Helper Functions ---
    function updateTextColor($selectElement) {
        if (!$selectElement || !$selectElement.length) return;
        if ($selectElement.val() === "" || $selectElement.val() === null) {
            $selectElement.removeClass("text-black").addClass("text-gray-400");
        } else {
            $selectElement.removeClass("text-gray-400").addClass("text-black");
        }
    }

    function disableSubmitButton() {
        if($submitBtn.length) {
            $submitBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
        }
    }

    function enableSubmitButton() {
         if($submitBtn.length) {
            $submitBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
        }
    }

    // DEFINISI FUNGSI resetTimeSlotSection
    function resetTimeSlotSection(showLoading = false) { // Parameter showLoading ditambahkan agar konsisten jika diperlukan
        $timeSlotWrapper.addClass('hidden');
        $timeSlotSelect.html('<option value="" disabled selected class="text-gray-400">Pilih Jam</option>').val('').prop('disabled', true);
        $timeLoading.toggleClass('hidden', !showLoading); // Gunakan parameter showLoading
        $timeNone.addClass('hidden');
        updateTextColor($timeSlotSelect);
    }

    function resetCalendarSection(showLoading = false) {
        $calendarWrapper.addClass('hidden');
        $datePicker.val('');
        if ($datePicker.hasClass('hasDatepicker')) {
            try { $datePicker.datepicker('destroy'); } catch(e) { console.warn("Error destroying datepicker:", e); }
        }
        $datePicker.prop('disabled', true);
        $dateLoading.toggleClass('hidden', !showLoading);
        $dateNone.addClass('hidden');
    }

    // resetCalendarAndTime sekarang akan memanggil dua fungsi reset di atas
    function resetCalendarAndTime(showDateLoading = false, showTimeLoading = false) {
        resetCalendarSection(showDateLoading);
        resetTimeSlotSection(showTimeLoading); // Panggil fungsi yang sudah ada

        if($submitBtn.length) { // Pastikan tombol submit juga di-disable
            $submitBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
        }
    }

    // 1. Fungsi untuk menampilkan harga
    function displayPrice() {
        const selectedOption = $serviceSelect.find('option:selected');
        $priceElement.text($priceElement.data('placeholder'))
                     .removeClass('line-through text-black text-gray-500 strike-through')
                     .addClass('text-gray-400');
        $promoPriceElement.text('').addClass('hidden');

        if (selectedOption.length && selectedOption.val() && selectedOption.data('price')) {
            const price = parseInt(selectedOption.data('price'));
            const promoPrice = selectedOption.data('promo') ? parseInt(selectedOption.data('promo')) : null;

            if (promoPrice) {
                $priceElement.text('Rp ' + new Intl.NumberFormat('id-ID').format(price))
                             .addClass('strike-through text-gray-500')
                             .removeClass('text-gray-400 text-black');
                $promoPriceElement.text('Rp ' + new Intl.NumberFormat('id-ID').format(promoPrice))
                                  .removeClass('hidden');
            } else {
                $priceElement.text('Rp ' + new Intl.NumberFormat('id-ID').format(price))
                             .addClass('text-black')
                             .removeClass('text-gray-400 text-gray-500 strike-through');
            }
        }
    }

    // 2. Fungsi untuk mengambil tanggal tersedia HANYA berdasarkan layanan
    function fetchAvailableDates() {
        const serviceId = $serviceSelect.val();
        resetCalendarAndTime(true, false);
        if (serviceId) {
            $calendarWrapper.removeClass('hidden');
            $datePicker.prop('disabled', true);
            $.ajax({
                url: fetchAvailableDatesUrl, type: 'GET', data: { service_id: serviceId }, dataType: 'json',
                success: function(response) {
                    $dateLoading.addClass('hidden');
                    if (response.available_dates && response.available_dates.length > 0) {
                        availableDatesForCalendar = response.available_dates;
                        initializeCalendar();
                        $datePicker.prop('disabled', false);
                        if (oldBookingDate && availableDatesForCalendar.includes(oldBookingDate)) {
                            $datePicker.datepicker('setDate', oldBookingDate);
                            fetchAvailableTimes(serviceId, oldBookingDate, true);
                        }
                    } else {
                        availableDatesForCalendar = [];
                        $dateNone.text('Tidak ada tanggal tersedia untuk layanan ini.').removeClass('hidden');
                        if ($datePicker.hasClass('hasDatepicker')) { try { $datePicker.datepicker('destroy'); } catch(e) {} }
                    }
                },
                error: function(xhr) {
                    $dateLoading.addClass('hidden');
                    $dateNone.text('Gagal memuat tanggal. Periksa koneksi atau coba lagi.').removeClass('hidden');
                    console.error('Error fetching available dates:', xhr.responseText);
                 }
            });
        } else { resetCalendarAndTime(); }
    }

    // 3. Fungsi untuk menginisialisasi jQuery UI Datepicker
    function initializeCalendar() {
        if (typeof $.fn.datepicker === 'undefined') {
            console.warn('jQuery UI Datepicker not loaded. Using native date input.');
            $datePicker.attr('type', 'date').attr('min', new Date().toISOString().split("T")[0]);
            $datePicker.off('change').on('change', handleNativeDateChange);
            $datePicker.prop('disabled', !(availableDatesForCalendar && availableDatesForCalendar.length > 0));
            return;
        }
        if ($datePicker.hasClass('hasDatepicker')) { try { $datePicker.datepicker('destroy'); } catch(e) {} }
        $datePicker.datepicker({
            dateFormat: 'yy-mm-dd', minDate: 0,
            beforeShowDay: function(date) {
                const stringDate = $.datepicker.formatDate('yy-mm-dd', date);
                const isAvailable = availableDatesForCalendar.includes(stringDate);
                return [isAvailable, isAvailable ? "date-available" : "date-unavailable ui-state-disabled-custom", isAvailable ? "Tanggal tersedia" : "Tidak tersedia"];
            },
            onSelect: function(dateText) {
                const serviceId = $serviceSelect.val();
                if (serviceId && dateText) { fetchAvailableTimes(serviceId, dateText, false); }
            }
        });
    }

    function handleNativeDateChange(){
        const serviceId = $serviceSelect.val();
        const dateText = $(this).val();
         if (serviceId && dateText) {
            if (!availableDatesForCalendar.includes(dateText) && availableDatesForCalendar.length > 0) {
                alert('Tanggal tidak tersedia. Silakan pilih tanggal lain.'); $(this).val('');
                resetTimeSlotSection(); disableSubmitButton(); return;
            }
            fetchAvailableTimes(serviceId, dateText, false);
        }
    }

    // 4. Fungsi untuk mengambil dan menampilkan slot waktu
    function fetchAvailableTimes(serviceId, selectedDate, isInitialLoadWithOldTime = false) {
        // Panggil resetTimeSlotSection dengan parameter showLoading yang benar
        resetTimeSlotSection(true); // true untuk menampilkan loading pada time slot
        disableSubmitButton();

        if (!serviceId || !selectedDate) {
            resetTimeSlotSection(false); // false karena tidak ada proses loading lagi
            return;
        }

        $timeSlotWrapper.removeClass('hidden');
        // $timeLoading sudah di-handle oleh resetTimeSlotSection(true)
        $timeSlotSelect.prop('disabled', true);

        $.ajax({
            url: fetchAvailableTimesUrl, type: 'GET', data: { service_id: serviceId, date: selectedDate }, dataType: 'json',
            success: function(response) {
                $timeLoading.addClass('hidden'); // Sembunyikan loading setelah data diterima
                populateTimeSlots(response.available_times || [], isInitialLoadWithOldTime ? oldScheduleId : null);
            },
            error: function(xhr) {
                $timeLoading.addClass('hidden'); // Sembunyikan loading jika error
                $timeNone.text('Gagal memuat jam. Periksa koneksi atau coba lagi.').removeClass('hidden');
                console.error('Error fetching available times:', xhr.responseText);
                populateTimeSlots([]);
            }
        });
    }

    // function populateTimeSlots(timesArray, selectedScheduleId = null) {
    //     $timeSlotSelect.html('<option value="" disabled selected class="text-gray-400">Pilih Jam</option>');
    //     if (timesArray && timesArray.length > 0) {
    //         $.each(timesArray, function(_, timeData) {
    //             const option = $('<option>', {
    //                 value: timeData.schedule_id,
    //                 text: timeData.formatted_time,
    //                 class: 'text-black'
    //             });
    //             if (selectedScheduleId && timeData.schedule_id == selectedScheduleId) {
    //                 option.prop('selected', true);
    //             }
    //             $timeSlotSelect.append(option);
    //         });
    //         $timeSlotSelect.prop('disabled', false);
    //         if (selectedScheduleId) {
    //             $timeSlotSelect.val(selectedScheduleId);
    //             if (String($timeSlotSelect.val()) === String(selectedScheduleId)) {
    //                 enableSubmitButton();
    //             }
    //         }
    //     } else {
    //         $timeNone.text('Tidak ada jam tersedia pada tanggal ini.').removeClass('hidden');
    //         $timeSlotSelect.prop('disabled', true);
    //     }
    //     updateTextColor($timeSlotSelect);
    // }

    function populateTimeSlots(timesArray, selectedTimeValue = null) { // selectedValue sekarang adalah string HH:MM
    $timeSlotSelect.html('<option value="" disabled selected class="text-gray-400">Pilih Jam</option>');
    if (timesArray && timesArray.length > 0) {
        $.each(timesArray, function(_, timeData) {
            const optionText = `${timeData.formatted_time} - ${timeData.slot_count} Slot Tersedia`;
            const option = $('<option>', {
                value: timeData.time, // VALUE ADALAH "HH:MM"
                text: optionText,
                class: 'text-black'
            });
            if (selectedTimeValue && timeData.time == selectedTimeValue) {
                option.prop('selected', true);
            }
            $timeSlotSelect.append(option);
        });
        $timeSlotSelect.prop('disabled', false);
        if (selectedTimeValue) {
            $timeSlotSelect.val(selectedTimeValue);
            if ($timeSlotSelect.val() === selectedTimeValue) {
                enableSubmitButton();
            }
        }
    } else {
        $timeNone.text('Tidak ada jam tersedia pada tanggal ini.').removeClass('hidden');
        $timeSlotSelect.prop('disabled', true);
    }
    updateTextColor($timeSlotSelect);
}

    // --- Event Listeners ---
    $serviceSelect.on('change', function () { displayPrice(); fetchAvailableDates(); });
    $timeSlotSelect.on('change', function() { if ($(this).val()) { enableSubmitButton(); } else { disableSubmitButton(); } });

    // Inisialisasi saat halaman dimuat
    if ($serviceSelect.length && $serviceSelect.val()) {
        displayPrice();
        fetchAvailableDates();
    } else {
        resetCalendarAndTime();
    }
});

// $(document).ready(function () {
//     // Cache jQuery selectors
//     const $serviceSelect = $('#service-select');
//     const $locationSelect = $('#location-select');
//     const $hairdresserWrapper = $('#hairdresser-wrapper');
//     const $hairdresserSelect = $('#hairdresser-select');
//     const $hairdresserLoading = $('#hairdresser-loading');
//     const $hairdresserNone = $('#hairdresser-none');

//     const $calendarWrapper = $('#calendar-wrapper');
//     const $datePicker = $('#date-picker');
//     const $dateLoading = $('#date-loading');
//     const $dateNone = $('#date-none');

//     const $timeSlotWrapper = $('#time-slot-wrapper');
//     const $timeSlotSelect = $('#time-slot-select');
//     const $timeLoading = $('#time-loading');
//     const $timeNone = $('#time-none');

//     const $priceElement = $('#price');
//     const $promoPriceElement = $('#promo-price');
//     const $submitBtn = $('#submitBtn');

//     let availableDatesForCalendar = [];

//     // --- Helper Functions ---

//     function resetHairdresserSection() {
//         $hairdresserWrapper.addClass('hidden');
//         $hairdresserSelect.html('<option value="" disabled selected class="text-gray-400">Pilih Hairdresser</option>').val('').prop('disabled', true);
//         $hairdresserLoading.addClass('hidden');
//         $hairdresserNone.addClass('hidden');
//     }

//     function resetCalendarSection() {
//         $calendarWrapper.addClass('hidden');
//         $datePicker.val('');
//         if ($datePicker.hasClass('hasDatepicker')) {
//             $datePicker.datepicker('destroy');
//         }
//         $dateLoading.addClass('hidden');
//         $dateNone.addClass('hidden');
//     }

//     function resetTimeSlotSection() {
//         $timeSlotWrapper.addClass('hidden');
//         $timeSlotSelect.html('<option value="" disabled selected class="text-gray-400">Pilih Jam</option>').val('').prop('disabled', true);
//         $timeLoading.addClass('hidden');
//         $timeNone.addClass('hidden');
//     }

//     function disableSubmitButton() {
//         $submitBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
//     }

//     function enableSubmitButton() {
//         $submitBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
//     }


//     // 1. Fungsi untuk menampilkan harga (diadaptasi dari kode Anda)
//     function displayPrice() {
//         const selectedOption = $serviceSelect.find('option:selected');

//         // Default state (placeholder)
//         $priceElement.text($priceElement.data('placeholder'))
//                      .removeClass('line-through text-black text-gray-500 strike-through') // strike-through adalah class Anda
//                      .addClass('text-gray-400');
//         $promoPriceElement.text('').addClass('hidden');

//         if (selectedOption.val() && selectedOption.data('price')) {
//             const price = parseInt(selectedOption.data('price'));
//             const promoPrice = selectedOption.data('promo') ? parseInt(selectedOption.data('promo')) : null;

//             if (promoPrice) {
//                 $priceElement.text('Rp ' + new Intl.NumberFormat('id-ID').format(price))
//                              .addClass('strike-through text-gray-500') // Class Anda untuk coret
//                              .removeClass('text-gray-400 text-black');
//                 $promoPriceElement.text('Rp ' + new Intl.NumberFormat('id-ID').format(promoPrice))
//                                   .removeClass('hidden');
//             } else {
//                 $priceElement.text('Rp ' + new Intl.NumberFormat('id-ID').format(price))
//                              .addClass('text-black')
//                              .removeClass('text-gray-400 text-gray-500 strike-through');
//             }
//         }
//     }

//     // 2. Fungsi untuk mengambil dan menampilkan hairdresser
//     function fetchHairdressers() {
//         const serviceId = $serviceSelect.val();
//         const locationId = $locationSelect.val();

//         resetHairdresserSection();
//         resetCalendarSection();
//         resetTimeSlotSection();
//         disableSubmitButton();


//         if (serviceId && locationId) {
//             $hairdresserWrapper.removeClass('hidden');
//             $hairdresserLoading.removeClass('hidden');
//             $hairdresserSelect.prop('disabled', true);

//             $.ajax({
//                 url: fetchHairdressersUrl,
//                 type: 'GET',
//                 data: { service_id: serviceId, location_id: locationId },
//                 dataType: 'json',
//                 success: function (response) {
//                     $hairdresserLoading.addClass('hidden');
//                     $hairdresserSelect.html('<option value="" disabled selected class="text-gray-400">Pilih Hairdresser</option>');
//                     if (response.hairdressers && response.hairdressers.length > 0) {
//                         $.each(response.hairdressers, function (_, hairdresser) {
//                             $hairdresserSelect.append($('<option>', { value: hairdresser.id, text: hairdresser.name, class: 'text-black' }));
//                         });
//                         $hairdresserSelect.prop('disabled', false).removeClass('text-gray-400').addClass('text-black');
//                     } else {
//                         $hairdresserNone.removeClass('hidden');
//                     }
//                 },
//                 error: function (xhr) {
//                     $hairdresserLoading.addClass('hidden');
//                     $hairdresserNone.text('Gagal memuat data hairdresser.').removeClass('hidden');
//                     console.error('Error fetching hairdressers:', xhr.responseText);
//                 }
//             });
//         }
//     }

//     // 3. Fungsi untuk mengambil tanggal tersedia
//     function fetchAvailableDates(hairdresserId, serviceId) {
//         resetCalendarSection();
//         resetTimeSlotSection();
//         disableSubmitButton();

//         if (!hairdresserId || !serviceId) return;

//         $calendarWrapper.removeClass('hidden');
//         $dateLoading.removeClass('hidden');

//         $.ajax({
//             url: fetchAvailableDatesUrl,
//             type: 'GET',
//             data: { hairdresser_id: hairdresserId, service_id: serviceId },
//             dataType: 'json',
//             success: function(response) {
//                 $dateLoading.addClass('hidden');
//                 if (response.available_dates && response.available_dates.length > 0) {
//                     availableDatesForCalendar = response.available_dates;
//                     initializeCalendar();
//                 } else {
//                     availableDatesForCalendar = [];
//                     $dateNone.text('Tidak ada tanggal tersedia.').removeClass('hidden');
//                 }
//             },
//             error: function(xhr) {
//                 $dateLoading.addClass('hidden');
//                 $dateNone.text('Gagal memuat tanggal.').removeClass('hidden');
//                 console.error('Error fetching available dates:', xhr.responseText);
//             }
//         });
//     }

//     // 4. Fungsi untuk menginisialisasi jQuery UI Datepicker
//      function initializeCalendar() {
//         // Hancurkan instance lama jika ada untuk menghindari duplikasi atau error
//         if ($datePicker.hasClass('hasDatepicker')) {
//             try { $datePicker.datepicker('destroy'); } catch(e) { console.warn("Error destroying datepicker:", e); }
//         }

//         $datePicker.datepicker({
//             dateFormat: 'yy-mm-dd', // Format tanggal yang akan dikirim ke server
//             minDate: 0, // Tidak bisa memilih tanggal di masa lalu
//             beforeShowDay: function(date) {
//                 // Format tanggal dari datepicker menjadi YYYY-MM-DD
//                 const stringDate = $.datepicker.formatDate('yy-mm-dd', date);
//                 // Cek apakah tanggal ini ada di array availableDatesForCalendar
//                 const isAvailable = availableDatesForCalendar.includes(stringDate);
//                 if (isAvailable) {
//                     return [true, 'date-available', 'Tanggal tersedia']; // [bisaDipilih, kelasCSS, tooltip]
//                 } else {
//                     return [false, 'date-unavailable ui-state-disabled-custom', 'Tidak tersedia']; // Tanggal tidak bisa dipilih
//                 }
//             },
//             onSelect: function(dateText) {
//                 // Ketika tanggal dipilih, panggil fungsi untuk mengambil slot waktu
//                 const hairdresserId = $hairdresserSelect.val();
//                 const serviceId = $serviceSelect.val();
//                 if (hairdresserId && serviceId && dateText) {
//                     fetchAvailableTimes(hairdresserId, serviceId, dateText);
//                 }
//             }
//         });
//         // Tampilkan kalender secara otomatis setelah inisialisasi jika ada tanggal tersedia
//         if(availableDatesForCalendar.length > 0){
//             // $datePicker.datepicker('show'); // Opsional: langsung tampilkan kalender
//         }
//     }

//     // 5. Fungsi untuk mengambil dan menampilkan slot waktu
//     function fetchAvailableTimes(hairdresserId, serviceId, selectedDate) {
//         resetTimeSlotSection();
//         disableSubmitButton();

//         if (!hairdresserId || !serviceId || !selectedDate) return;

//         $timeSlotWrapper.removeClass('hidden');
//         $timeLoading.removeClass('hidden');
//         $timeSlotSelect.prop('disabled', true);

//         $.ajax({
//             url: fetchAvailableTimesUrl,
//             type: 'GET',
//             data: { hairdresser_id: hairdresserId, service_id: serviceId, date: selectedDate },
//             dataType: 'json',
//             success: function(response) {
//                 $timeLoading.addClass('hidden');
//                 $timeSlotSelect.html('<option value="" disabled selected class="text-gray-400">Pilih Jam</option>');
//                 if (response.available_times && response.available_times.length > 0) {
//                     $.each(response.available_times, function(_, time) {
//                         // Asumsi backend mengembalikan schedule_id bersamaan dengan waktu
//                         // Jika tidak, Anda hanya akan memiliki waktu, dan backend harus mencari schedule_id saat submit
//                         const option = $('<option>', {
//                             value: time.time, // atau time.schedule_id jika ada
//                             text: time.formatted_time,
//                             class: 'text-black'
//                         });
//                         // Jika backend mengirim schedule_id: option.data('schedule-id', time.schedule_id);
//                         $timeSlotSelect.append(option);
//                     });
//                     $timeSlotSelect.prop('disabled', false).removeClass('text-gray-400').addClass('text-black');
//                 } else {
//                     $timeNone.text('Tidak ada jam tersedia.').removeClass('hidden');
//                 }
//             },
//             error: function(xhr) {
//                 $timeLoading.addClass('hidden');
//                 $timeNone.text('Gagal memuat jam.').removeClass('hidden');
//                 console.error('Error fetching available times:', xhr.responseText);
//             }
//         });
//     }

//     // --- Event Listeners ---

//     // Perubahan warna teks untuk dropdown service dan location (dari kode Anda)
//     $serviceSelect.add($locationSelect).add($hairdresserSelect).add($timeSlotSelect).on('change', function() {
//         if ($(this).val() !== "" && $(this).val() !== null) {
//             $(this).removeClass("text-gray-400").addClass("text-black");
//         } else {
//             $(this).removeClass("text-black").addClass("text-gray-400");
//         }
//     });

//     $serviceSelect.on('change', function () {
//         displayPrice();
//         fetchHairdressers();
//     });

//     $locationSelect.on('change', function () {
//         fetchHairdressers();
//     });

//     $hairdresserSelect.on('change', function() {
//         const hairdresserId = $(this).val();
//         const serviceId = $serviceSelect.val();
//         fetchAvailableDates(hairdresserId, serviceId);
//     });

//     $timeSlotSelect.on('change', function() {
//         if ($(this).val()) {
//             // selectedScheduleId = $(this).find('option:selected').data('schedule-id'); // Jika Anda menyimpan schedule_id
//             // console.log('Selected Schedule ID (if available):', selectedScheduleId);
//             enableSubmitButton();
//         } else {
//             disableSubmitButton();
//         }
//     });

//     // --- Inisialisasi ---
//     if ($serviceSelect.val()) {
//         displayPrice();
//         $serviceSelect.removeClass("text-gray-400").addClass("text-black"); // Handle initial state if value exists
//     }
//     if ($locationSelect.val()) {
//          $locationSelect.removeClass("text-gray-400").addClass("text-black"); // Handle initial state
//     }

//     if ($serviceSelect.val() && $locationSelect.val()) {
//         fetchHairdressers();
//         // Logika untuk old input hairdresser, date, time bisa ditambahkan di sini jika diperlukan
//         // Misalnya, jika old('hairdresser_id') ada, trigger change pada hairdresserSelect setelah opsi dimuat.
//     }
// });
