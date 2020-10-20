jQuery(function($) {
    $('.grid-carousel').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        arrows: true,
        easing: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breaklpoint: 480,
                settings: {
                    slidesToShow: 2,
                }
            }
        ],
    });
});
