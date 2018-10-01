jQuery(function($){

    if (typeof $.fancybox == 'object') {
        $.fancybox.defaults.animationEffect = 'zoom-in-out';
        $.fancybox.defaults.btnTpl.smallBtn = '<button class="window__close far fa-times" data-fancybox-close></button>';
        $.fancybox.defaults.touch = false;
    }

    $(document).on('change', '.upload-file__input', function(){
        var input = $(this),
            multiple = input.prop('multiple'),
            wrap = input.closest('.upload-file');
        if (multiple) {
            var files = event.target.files,
                previews = wrap.find('.upload-file__previews');
            previews.html('');
            for (var i = 0, file; file = files[i]; i++) {
                if (file.type.match('image.*')) {
                    var reader = new FileReader();
                    reader.onload = (function() {
                        return function(e) {
                            previews.append('<div class="upload-file__previews-img" style="background-image:url(' + e.target.result + ');"></div>');
                        };
                    })(file);
                    reader.readAsDataURL(file);
                }
            }
        } else {
            var file = event.target.files[0],
                preview = wrap.find('.upload-file__preview'),
                preview_icon = preview.find('.upload-file__preview-icon');
            if (file.type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = (function() {
                    return function(e) {
                        preview.css({'background-image': 'url(' + e.target.result + ')'});
                        preview_icon.hide();
                    };
                })(file);
                reader.readAsDataURL(file);
            }
        }
    });
    $(document).on('click', '.upload-file__previews-img', function(){
        alert('Удалить загружаемый файл.');
    });

    $('.select-box__wrap').click(function(){
        var button = $(this),
            select = button.closest('.select-box'),
            options = select.find('.select-box__options');
        options.slideToggle(100);
    });

    $('.select-box__option').click(function(){
        var option = $(this),
            select = option.closest('.select-box'),
            options = select.find('.select-box__options'),
            input = select.find('.select-box__input'),
            label = select.find('.select-box__label');
        input.val(option.data('value'));
        label.text(option.text()).addClass('select-box__label_is_selected');
        options.slideUp(100);
    });

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

    $('.js-switch-register input[type="radio"]').change(function() {
        var input = $(this);
        switch (input.val())  {
            case 'client':
                $('body').addClass('bg_color_e4eff9').removeClass('bg_color_fffcfe');
                break;
            case 'master':
                $('body').addClass('bg_color_fffcfe').removeClass('bg_color_e4eff9');
                break;
            default:
                break;
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

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    $('.calendar').fullCalendar({
        defaultView: 'month',
        firstDay : 1,
        locale: 'ru',
        columnHeader: true,
        header: {
            left: 'month,agendaWeek,agendaDay',
            center: 'title',
            right: 'today,prev,next',
        },
        eventTextColor: '#fff',
        eventBorderColor: '#FE4375',
        eventBackgroundColor: '#FE4375',
        events: [
            {
                id: 146,
                title: 'All Day Event',
                start: new Date(y, m, 1),
                text: 'ololo',
            },
            {
                id: 147,
                title: 'All Day Event',
                start: new Date(y, m, 1),
                text: 'ololo',
            },
            {
                id: 148,
                // title: 'All Day Event',
                start: new Date(y, m, 1),
                text: 'ololo',
            },
        ],
        eventAfterRender: function(event, element, view) {
            // element.find('.fc-title').hide();
            element.append(
                '<div class="calendar-event-window">' +
                '<div class="calendar-event-window__close far fa-times"></div>' +
                '<div class="calendar-event-window__name">Мария Семечкина</div>' +
                '<div class="calendar-event-window__service">Мужская стрижка</div>' +
                '<div class="calendar-event-window__price">от 500 руб</div>' +
                '<a data-fancybox data-src="#window_5" class="calendar-event-window__more">Подробнее</a>' +
                '</div>'
            );

        },
        eventClick: function(date, jsEvent, view) {
            if (!$(jsEvent.target).closest('.calendar-event-window').length) {
                $(jsEvent.target).closest('.fc-content-skeleton').css('z-index', 5);
                $(jsEvent.target).closest('.fc-event').find('.calendar-event-window').show();
            } else if ($(jsEvent.target).is('.calendar-event-window__close')) {
                $(jsEvent.target).closest('.calendar-event-window').hide();
                $(jsEvent.target).closest('.fc-content-skeleton').css('z-index', 4);
            }
        },
    });

    if ($('#chart1, #chart2').length) {
        ['chart1', 'chart2'].forEach(function(chart_id) {
            var chartcanvas = document.getElementById(chart_id).getContext('2d');
            var chart = new Chart(chartcanvas, {
                type: 'line',
                data: {
                    labels: ['Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                    datasets: [
                        {
                            label: 'Values 1',
                            data: [12, 19, 3, 5, 12, 3, 16, 11],
                            fill: true,
                            borderWidth: 2,
                            borderColor: '#FE4375',
                            backgroundColor: 'rgba(254,67,117,0.2)',
                        },
                        {
                            label: 'Values 2',
                            data: [11, 2, 7, 1, 8, 8, 8, 10],
                            fill: true,
                            borderWidth: 2,
                            borderColor: '#00AEF4',
                            backgroundColor: 'rgba(0,174,244,0.2)',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    title: {
                        display: false,
                    },
                    legend: {
                        display: true,
                        labels: {
                            usePointStyle:true,
                        }
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                            }
                        }],
                        yAxes: [{
                            display: true,
                            ticks: {
                                display: false,
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'point',
                        intersect: false,
                        yPadding: 10,
                        xPadding: 10,
                        titleFontColor: '#FE4375',
                        backgroundColor: '#fff',
                        borderColor: '#c1c1c1',
                        bodyFontColor: '#000',
                        borderWidth: 1,
                        cornerRadius: 0,
                        displayColors: false,
                    }
                }
            });
        });
    }

    $('.js-datepicker-click').click(function(e) {
        console.log(1);
        $(this).find('.js-datepicker').click();
    });
    $('.js-datepicker').click(function(e) {
        console.log(2);
        e.stopPropagation();
    });
    $('.js-datepicker').datepicker({
        inline: false,
    });

    $('.js-letter__more').click(function() {
        $(this).siblings('.js-letter__text').toggleClass('letter__text_short');
        return false;
    });

    ymaps.ready(function() {
        var myMap = new ymaps.Map('map', {
                center: [55.751574, 37.573856],
                zoom: 9
            }),
            points = [
                [55.831903,37.411961], [55.763338,37.565466], [55.763338,37.565466], [55.744522,37.616378], [55.780898,37.642889], [55.793559,37.435983], [55.800584,37.675638], [55.716733,37.589988], [55.775724,37.560840], [55.822144,37.433781], [55.874170,37.669838], [55.716770,37.482338], [55.780850,37.750210], [55.810906,37.654142], [55.865386,37.713329], [55.847121,37.525797], [55.778655,37.710743], [55.623415,37.717934], [55.863193,37.737000], [55.866770,37.760113], [55.698261,37.730838], [55.633800,37.564769], [55.639996,37.539400], [55.690230,37.405853], [55.775970,37.512900], [55.775777,37.442180], [55.811814,37.440448], [55.751841,37.404853], [55.627303,37.728976], [55.816515,37.597163], [55.664352,37.689397], [55.679195,37.600961], [55.673873,37.658425], [55.681006,37.605126], [55.876327,37.431744], [55.843363,37.778445], [55.875445,37.549348], [55.662903,37.702087], [55.746099,37.434113], [55.838660,37.712326], [55.774838,37.415725], [55.871539,37.630223], [55.657037,37.571271], [55.691046,37.711026], [55.803972,37.659610], [55.616448,37.452759], [55.781329,37.442781], [55.844708,37.748870], [55.723123,37.406067], [55.858585,37.484980]
            ],
            geoObjects = [],
            clusterer = new ymaps.Clusterer({
                preset: 'islands#pinkClusterIcons',
                groupByCoordinates: false,
                clusterDisableClickZoom: true,
                clusterHideIconOnBalloonOpen: false,
                geoObjectHideIconOnBalloonOpen: false,
                clusterBalloonContentLayout: 'cluster#balloonCarousel',
                clusterBalloonContentLayoutWidth: 240,
                clusterBalloonContentLayoutHeight: 140,
            });
        for(var i = 0, len = points.length; i < len; i++) {
            geoObjects[i] = new ymaps.Placemark(points[i], {
                balloonContentBody: '<div class="person">\n' +
                '                    <div class="person__img" style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png);"></div>\n' +
                '                    <div class="person__info">\n' +
                '                        <div class="label-status label-status_bg_black label-status_fz_14 person__status">Profi</div>\n' +
                '                        <div class="person__name">Мария Семечкина</div>\n' +
                '                    </div>\n' +
                '                </div><div class="font_type_13 mt-5">Новослободская, 48</div>',
            }, {
                iconLayout: 'default#image',
                iconImageHref: '../images/map-mark.png',
                iconImageSize: [38, 52],
            });
        }
        clusterer.add(geoObjects);
        myMap.geoObjects.add(clusterer);
    });

});