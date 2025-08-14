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

const maxPerPage = 6;
let currentPage = 1;
let paginatedSchedules = [];

function renderSchedulePage(page = 1) {
    const startIndex = (page - 1) * maxPerPage;
    const endIndex = startIndex + maxPerPage;
    const schedules = paginatedSchedules.slice(startIndex, endIndex);

    let scheduleHTML =
        '<label class="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm">Pilih Jadwal:</label><div class="grid grid-cols-2 md:grid-cols-3 gap-2">';

    schedules.forEach((schedule) => {
        const available = schedule.available_hairdressers; // Use available count instead of bookings_count
        const disabled = available <= 0;
        const isSelected = schedule.isSelected ? "checked" : "";

        // Ambil waktu langsung dari string tanpa diubah timezone
        const availableAt = schedule.available_at; // format: "2025-04-17 01:27:00"
        const datePart = availableAt.slice(0, 10); // "2025-04-17"
        const timePart = availableAt.slice(11, 16); // "01:27"

        // Format ulang tanggal
        const [year, month, day] = datePart.split("-");
        const monthNames = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "Mei",
            "Jun",
            "Jul",
            "Agu",
            "Sep",
            "Okt",
            "Nov",
            "Des",
        ];
        const formattedDate = `${day} ${
            monthNames[parseInt(month) - 1]
        } ${year} ${timePart} WIB`;

        scheduleHTML += `
            <label class="cursor-pointer ${
                disabled ? "opacity-50 cursor-not-allowed" : ""
            }">
                <input type="radio" name="schedule_id" value="${schedule.id}"
                    class="hidden" ${disabled ? "disabled" : ""} ${isSelected}>
                <div onclick="handleScheduleSelection(this)"
                    class="schedule-item border px-2 py-2 rounded text-xs text-center
                    ${disabled ? "bg-gray-200" : ""}
                    ${isSelected ? "bg-[#B29100] text-white" : ""}">
                    ${formattedDate}
                    <br><span class="text-xs">(${available} tersedia)</span>
                </div>
            </label>
            `;
    });

    scheduleHTML += "</div>";

    // Pagination controls
    const totalPages = Math.ceil(paginatedSchedules.length / maxPerPage);
    if (totalPages > 1) {
        scheduleHTML += `<div class="px-4 mt-4">`;
        scheduleHTML += `<div class="flex flex-wrap justify-center gap-2 w-full max-w-full mx-auto overflow-x-auto py-2">`;

        // Previous button
        if (page > 1) {
            scheduleHTML += `
            <button class="px-3 py-1 text-xs rounded border bg-white hover:bg-gray-100 transition-colors"
                onclick="renderSchedulePage(${page - 1})">
                &lt;
            </button>
        `;
        }

        // Page numbers - tampilkan maksimal 5 halaman di sekitar current page
        const maxVisiblePages = 5;
        let startPage = Math.max(1, page - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        // Adjust if we're at the end
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        // First page and ellipsis
        if (startPage > 1) {
            scheduleHTML += `
            <button class="px-3 py-1 text-xs rounded border ${
                1 === page
                    ? "bg-orangeBtn text-white"
                    : "bg-white hover:bg-gray-100"
            } transition-colors"
                onclick="renderSchedulePage(1)">
                1
            </button>
        `;
            if (startPage > 2) {
                scheduleHTML += `<span class="px-2 py-1 text-xs">...</span>`;
            }
        }

        // Visible pages
        for (let i = startPage; i <= endPage; i++) {
            scheduleHTML += `
            <button class="px-3 py-1 text-xs rounded border ${
                i === page
                    ? "bg-orangeBtn text-white"
                    : "bg-white hover:bg-gray-100"
            } transition-colors"
                onclick="renderSchedulePage(${i})">
                ${i}
            </button>
        `;
        }

        // Last page and ellipsis
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                scheduleHTML += `<span class="px-2 py-1 text-xs">...</span>`;
            }
            scheduleHTML += `
            <button class="px-3 py-1 text-xs rounded border ${
                totalPages === page
                    ? "bg-orangeBtn text-white"
                    : "bg-white hover:bg-gray-100"
            } transition-colors"
                onclick="renderSchedulePage(${totalPages})">
                ${totalPages}
            </button>
        `;
        }

        // Next button
        if (page < totalPages) {
            scheduleHTML += `
            <button class="px-3 py-1 text-xs rounded border bg-white hover:bg-gray-100 transition-colors"
                onclick="renderSchedulePage(${page + 1})">
                &gt;
            </button>
        `;
        }

        scheduleHTML += `</div>`;
        scheduleHTML += `</div>`;
    }

    document.getElementById("schedule-container").innerHTML = scheduleHTML;
}

// Handle location change
document
    .getElementById("location-select")
    .addEventListener("change", async function () {
        const locationId = this.value;

        if (!locationId) {
            document.getElementById("schedule-container").innerHTML =
                "<div class='col-span-full text-center text-gray-500 py-4'>Pilih lokasi terlebih dahulu</div>";
            return;
        }

        try {
            const response = await fetch(`/jadwal/lokasi/${locationId}`);
            if (!response.ok) throw new Error("Network response was not ok");

            const data = await response.json();
            const oldScheduleId = data.oldScheduleId;

            // Process schedules with available hairdressers
            paginatedSchedules = data.schedules
                .filter((schedule) => schedule.available_hairdressers > 0) // Only show available schedules
                .sort(
                    (a, b) =>
                        new Date(a.available_at) - new Date(b.available_at)
                )
                .map((schedule) => ({
                    ...schedule,
                    isSelected: oldScheduleId === schedule.id,
                }));

            if (paginatedSchedules.length === 0) {
                document.getElementById("schedule-container").innerHTML =
                    "<div class='col-span-full text-center text-gray-500 py-4'>Tidak ada jadwal tersedia</div>";
            } else {
                currentPage = 1;
                renderSchedulePage(currentPage);
            }
        } catch (error) {
            console.error("Error:", error);
            document.getElementById("schedule-container").innerHTML =
                "<div class='col-span-full text-center text-red-500 py-4'>Terjadi kesalahan saat memuat jadwal.</div>";
        }
    });

document
    .getElementById("service-select")
    .addEventListener("change", function () {
        const priceSpan = document.getElementById("price");
        const promoPriceSpan = document.getElementById("promo-price");
        const selectedOption = this.options[this.selectedIndex];

        if (this.value && selectedOption.hasAttribute("data-price")) {
            const price = parseInt(selectedOption.getAttribute("data-price"));
            const promoPrice = selectedOption.hasAttribute("data-promo")
                ? parseInt(selectedOption.getAttribute("data-promo"))
                : null;

            if (promoPrice) {
                priceSpan.textContent = "Rp " + price.toLocaleString("id-ID");
                priceSpan.classList.add("strike-through"); // ✅ Tambahkan garis coret
                priceSpan.classList.remove("text-black"); // ✅ Tambahkan garis coret
                promoPriceSpan.textContent =
                    "Rp " + promoPrice.toLocaleString("id-ID");
                promoPriceSpan.classList.remove("hidden");
            } else {
                // Jika tidak ada promo, tampilkan harga biasa tanpa coret
                priceSpan.textContent = "Rp " + price.toLocaleString("id-ID");
                promoPriceSpan.textContent = "";
                promoPriceSpan.classList.add("hidden");
                // Hilangkan efek coret jika sebelumnya ada
                priceSpan.classList.remove("strike-through");
                priceSpan.classList.add("text-black");
            }
        } else {
            priceSpan.textContent = "";
            promoPriceSpan.textContent = "";
            promoPriceSpan.classList.add("hidden");
        }
    });
