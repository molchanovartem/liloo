jQuery(function($){

    $('.button-hamburger').click(function(){
        $(this).toggleClass('open');
        $('.cloud_in_header').slideToggle(200);
    });

    $(document).on('focus blur', '.input-box__input, .textarea-box__textarea', function(){
        var input = $(this),
            is_focused = input.is(':focus'),
            is_filled = input.val().length,
            box = input.closest('.input-box, .textarea-box');
        if (is_focused) {
            box.addClass('field-box_opened');
        } else if (is_filled) {
            box.addClass('field-box_opened');
        } else {
            box.removeClass('field-box_opened');
        }
    });

    $('.services-slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: true,
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed: 2500,
    });

    $('.reviews-slider').slick({
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        adaptiveHeight: true,
        arrows: true,
        dots: false,
        autoplay: false,
        autoplaySpeed: 2500,
        prevArrow: '.js-reviews-slider-arrows .slider-arrows__arrow_to_prev',
        nextArrow: '.js-reviews-slider-arrows .slider-arrows__arrow_to_next',
    });

});