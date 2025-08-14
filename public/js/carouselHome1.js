document.addEventListener('DOMContentLoaded', function () {
    // Ambil data dari HTML data-attribute
    const totalSlides1 = parseInt(document.getElementById('splide-carousel').dataset.totalSlides);
    const totalSlides2 = parseInt(document.getElementById('splide-second-carousel').dataset.totalSlides);
    const maxPerPage = 3;

    const perPage1 = Math.min(totalSlides1, maxPerPage);
    const middleIndex1 = Math.floor(totalSlides1 / 2);

    new Splide('#splide-carousel', {
        type: 'loop',
        perPage: perPage1,
        focus: 'center',
        start: middleIndex1,
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

    const perPage2 = Math.min(totalSlides2, maxPerPage);
    const middleIndex2 = Math.floor(totalSlides2 / 2);

    new Splide('#splide-second-carousel', {
        type: 'loop',
        perPage: perPage2,
        focus: 'center',
        start: middleIndex2,
        fixedWidth: 500,
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

