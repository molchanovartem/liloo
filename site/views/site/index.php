<?php

$this->registerJs('indexForm();');

?>

<div class="header__content header__content_page_main uk-container">
    <h1 class="h1 h1_page_main">Записывайтесь к лучшим и&nbsp;проверенным мастерам</h1>

    <div class="header__content-parts">
        <div class="header__content-part uk-margin-top" id="indexForm">
            <form ref="filter" action="/site/web/executor-map" method="get">
                <div class="uk-grid uk-grid-small uk-child-width-1-2">
                    <div>
                        <div class="uk-background-default executor-filter-border-radius">
                            <input type="hidden" name="service_id" :value="attributes.serviceId">

                            <v-autocomplete
                                    class="custom-input-index-filter"
                                    outline
                                    :items="services"
                                    v-model="attributes.serviceId"
                                    append-icon="mdi-chevron-down"
                                    item-value="id"
                                    item-text="name"
                                    placeholder="Маникюр"
                            />
                        </div>
                    </div>
                    <div>
                        <div class="uk-background-default executor-filter-border-radius">
                            <v-menu
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                            >
                                <v-text-field
                                        slot="activator"
                                        v-model="attributes.date"
                                        label="Выбор даты"
                                        append-icon="mdi-calendar"
                                        readonly
                                        hide-details
                                        outline
                                        height="60px"
                                        name="date"
                                ></v-text-field>
                                <v-date-picker
                                        v-model="attributes.date"
                                        prev-icon="mdi-chevron-left"
                                        next-icon="mdi-chevron-right"
                                        no-title
                                />
                            </v-menu>
                        </div>
                    </div>
                </div>

                <div class="uk-grid uk-grid-small">
                    <div class="uk-width-1-1">
                        <input type="submit" class="button button_color_red" value="Найти мастера">
                    </div>
                </div>
            </form>

            <a href="" class="anchor-more mt-65">
                <span class="anchor-more__arrow fas fa-arrow-down"></span>
                <span class="anchor-more__text">Все услуги</span>
            </a>
        </div>

        <div class="header__content-part">
            <div uk-slideshow="animation: slide">

                <div class="popular-service-index uk-position-relative uk-visible-toggle uk-light uk-background-default uk-padding-small uk-border-rounded">

                    <ul class="uk-slideshow-items">
                        <li>
                            <span class="service-popular__tip">Популярная услуга в вашем городе</span>
                            <div class="service-popular__wrap">
                                <div class="service-popular__img"
                                     style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png)"></div>
                                <div class="service-popular__row">
                                    <span class="service-popular__name">Ресницы, брови</span>
                                    <span class="service-popular__prices">Цены: от 300 руб.</span>
                                </div>
                            </div>
                            <span class="service-popular__more service-popular_custom">Подробнее</span>
                        </li>
                        <li>
                            <span class="service-popular__tip">Популярная услуга в вашем городе</span>
                            <div class="service-popular__wrap">
                                <div class="service-popular__img"
                                     style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png)"></div>
                                <div class="service-popular__row">
                                    <span class="service-popular__name">Ресницы, брови</span>
                                    <span class="service-popular__prices">Цены: от 300 руб.</span>
                                </div>
                            </div>
                            <span class="service-popular__more">Подробнее</span>
                        </li>
                        <li>
                            <span class="service-popular__tip">Популярная услуга в вашем городе</span>
                            <div class="service-popular__wrap">
                                <div class="service-popular__img"
                                     style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png)"></div>
                                <div class="service-popular__row">
                                    <span class="service-popular__name">Ресницы, брови</span>
                                    <span class="service-popular__prices">Цены: от 300 руб.</span>
                                </div>
                            </div>
                            <span class="service-popular__more">Подробнее</span>
                        </li>
                    </ul>

                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#"
                       uk-slidenav-previous uk-slideshow-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#"
                       uk-slidenav-next uk-slideshow-item="next"></a>

                </div>

                <ul class="uk-slideshow-nav uk-dotnav uk-flex-center uk-margin"></ul>

            </div>
        </div>
    </div>

</div>

<div class="uk-container">
    <?php echo \site\widgets\specialization\Specialization::widget(); ?>

    <div class="content-width">

        <div class="j-c_s-b mt-120">
            <div class="h2">О нас говорят</div>

            <div class="title-tip">
                <span class="title-tip__text">БОЛЕЕ 98 ОТЗЫВОВ</span>
                <div class="slider-arrows title-tip__slider-arrows js-reviews-slider-arrows">
                    <span class="slider-arrows__arrow slider-arrows__arrow_to_prev far fa-long-arrow-left"></span>
                    <span class="slider-arrows__arrow slider-arrows__arrow_to_next far fa-long-arrow-right"></span>
                </div>
            </div>
        </div>

        <div class="reviews-slider">

            <div class="uk-position-relative uk-visible-toggle" uk-slider>
                <div class="uk-clearfix ">
                    <div class="uk-float-right">
                        <a class="uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                        <a class="uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
                    </div>
                </div>
                <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid">
                    <li>
                        <div class="review-slide">
                            <div class="review-slide__content">
                                <div class="review-slide__text">Все мы знаем, как протекает жизнь в мегаполисе: нехватка
                                    свободного времени, много работы, куча дел. На сегодняшний день, что касается
                                    посещения
                                    салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала
                                    отличную
                                    возможность записываться в салон в удобное для
                                </div>
                                <a href="" class="review-slide__more">Читать полностью</a>
                            </div>
                            <div class="review-slide__author">
                                <div class="review-slide__author-img"
                                     style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png);"></div>
                                <div class="review-slide__author-info">
                                    <div class="review-slide__author-name">Мария Семечкина</div>
                                    <div class="review-slide__author-profession">Стилист</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="review-slide">
                            <div class="review-slide__content">
                                <div class="review-slide__text">Все мы знаем, как протекает жизнь в мегаполисе: нехватка
                                    свободного времени, много работы, куча дел. На сегодняшний день, что касается
                                    посещения
                                    салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала
                                    отличную
                                    возможность записываться в салон в удобное для
                                </div>
                                <a href="" class="review-slide__more">Читать полностью</a>
                            </div>
                            <div class="review-slide__author">
                                <div class="review-slide__author-img"
                                     style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png);"></div>
                                <div class="review-slide__author-info">
                                    <div class="review-slide__author-name">Мария Семечкина</div>
                                    <div class="review-slide__author-profession">Стилист</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="review-slide">
                            <div class="review-slide__content">
                                <div class="review-slide__text">Все мы знаем, как протекает жизнь в мегаполисе: нехватка
                                    свободного времени, много работы, куча дел. На сегодняшний день, что касается
                                    посещения
                                    салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала
                                    отличную
                                    возможность записываться в салон в удобное для
                                </div>
                                <a href="" class="review-slide__more">Читать полностью</a>
                            </div>
                            <div class="review-slide__author">
                                <div class="review-slide__author-img"
                                     style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png);"></div>
                                <div class="review-slide__author-info">
                                    <div class="review-slide__author-name">Мария Семечкина</div>
                                    <div class="review-slide__author-profession">Стилист</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="review-slide">
                            <div class="review-slide__content">
                                <div class="review-slide__text">Все мы знаем, как протекает жизнь в мегаполисе: нехватка
                                    свободного времени, много работы, куча дел. На сегодняшний день, что касается
                                    посещения
                                    салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала
                                    отличную
                                    возможность записываться в салон в удобное для
                                </div>
                                <a href="" class="review-slide__more">Читать полностью</a>
                            </div>
                            <div class="review-slide__author">
                                <div class="review-slide__author-img"
                                     style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png);"></div>
                                <div class="review-slide__author-info">
                                    <div class="review-slide__author-name">Мария Семечкина</div>
                                    <div class="review-slide__author-profession">Стилист</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="review-slide">
                            <div class="review-slide__content">
                                <div class="review-slide__text">Все мы знаем, как протекает жизнь в мегаполисе: нехватка
                                    свободного времени, много работы, куча дел. На сегодняшний день, что касается
                                    посещения
                                    салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала
                                    отличную
                                    возможность записываться в салон в удобное для
                                </div>
                                <a href="" class="review-slide__more">Читать полностью</a>
                            </div>
                            <div class="review-slide__author">
                                <div class="review-slide__author-img"
                                     style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png);"></div>
                                <div class="review-slide__author-info">
                                    <div class="review-slide__author-name">Мария Семечкина</div>
                                    <div class="review-slide__author-profession">Стилист</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="review-slide">
                            <div class="review-slide__content">
                                <div class="review-slide__text">Все мы знаем, как протекает жизнь в мегаполисе: нехватка
                                    свободного времени, много работы, куча дел. На сегодняшний день, что касается
                                    посещения
                                    салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала
                                    отличную
                                    возможность записываться в салон в удобное для
                                </div>
                                <a href="" class="review-slide__more">Читать полностью</a>
                            </div>
                            <div class="review-slide__author">
                                <div class="review-slide__author-img"
                                     style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png);"></div>
                                <div class="review-slide__author-info">
                                    <div class="review-slide__author-name">Мария Семечкина</div>
                                    <div class="review-slide__author-profession">Стилист</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="review-slide">
                            <div class="review-slide__content">
                                <div class="review-slide__text">Все мы знаем, как протекает жизнь в мегаполисе: нехватка
                                    свободного времени, много работы, куча дел. На сегодняшний день, что касается
                                    посещения
                                    салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала
                                    отличную
                                    возможность записываться в салон в удобное для
                                </div>
                                <a href="" class="review-slide__more">Читать полностью</a>
                            </div>
                            <div class="review-slide__author">
                                <div class="review-slide__author-img"
                                     style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png);"></div>
                                <div class="review-slide__author-info">
                                    <div class="review-slide__author-name">Мария Семечкина</div>
                                    <div class="review-slide__author-profession">Стилист</div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <div class="mt-80">
            <a href="" class="font_Gilroy-17-800-000000">Больше отзывов</a>
        </div>
    </div>
</div>
<script>
    function indexForm() {
        let wm = new Vue({
            el: '#indexForm',
            beforeMount() {
                this.loadCommonData()
                    .then(() => {
                        this.setDefaultQueryParams();
                        this.loadAttributesFromQueryParams();
                    });
            },
            data: {
                services: [],
                attributes: {
                    serviceId: null,
                    date: null,
                },
            },
            methods: {
                loadCommonData() {
                    return new Promise((resolve, reject) => {
                        $.post('http://liloo/api/common/index', JSON.stringify({
                            query: `query {
                                     commonServices {id, name, price, duration}
                                }`
                        }))
                            .done(({data}) => {
                                if (data.commonServices) this.services = data.commonServices;
                                resolve(true);
                            })
                            .fail((error) => {
                                reject(error);
                            });
                    });
                },
                loadAttributesFromQueryParams() {
                    let params = new URLSearchParams(document.location.search);

                    this.attributes.date = params.get('date');
                },

                setDefaultQueryParams() {
                    let params = new URLSearchParams(document.location.search),
                        date = params.get('date');

                    if (date === null || date === '') {
                        params.set('date', moment().format('YYYY-MM-DD'));
                    }

                    let baseUrl = [location.protocol, '//', location.host, location.pathname].join('');

                    history.replaceState({}, '', [baseUrl, params.toString()].join('?'));
                },
            },
        });
    }
</script>
