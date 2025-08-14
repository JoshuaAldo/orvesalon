document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('testimonial-carousel');
    const items = carousel.querySelectorAll('[data-carousel-item]');
    let currentIndex = 0;

    function showSlide(index) {
        items.forEach(item => {
            item.style.opacity = '0';
            item.style.zIndex = '0';
        });

        items[index].style.opacity = '1';
        items[index].style.zIndex = '10';

        currentIndex = index;
    }

    function nextSlide() {
        const nextIndex = (currentIndex + 1) % items.length;
        showSlide(nextIndex);
    }

    // Auto slide every 5 seconds
    setInterval(nextSlide, 5000);

    // Initialize
    showSlide(0);
});

document.addEventListener('DOMContentLoaded', function () {
    const totalSlides = parseInt(document.getElementById('splide-carousel')?.dataset.total || 0);
    const maxPerPage = 3;
    const perPage = Math.min(totalSlides, maxPerPage);
    const middleIndex = Math.floor(totalSlides / 2);

    new Splide('#splide-carousel', {
        type: 'loop',
        perPage: perPage,
        focus: 'center',
        start: middleIndex,
        fixedWidth: 300,
        gap: '1rem',
        pagination: false,
        arrows: true,
        speed: 400,
        updateOnMove: true,
        breakpoints: {
            768: {
                perPage: 1,
                fixedWidth: null,
            },
        },
    }).mount();
});



