<?php

use yii\helpers\Url;
use site\widgets\header\Header;

?>

<div class="header bg_image_header-main">
    <div class="header__container">
        <?php echo Header::widget(); ?>
        <div class="header__content header__content_page_main content-width">
            <h1 class="h1 h1_page_main">Записывайтесь к лучшим и&nbsp;проверенным мастерам</h1>

            <div class="header__content-parts">

                <div class="header__content-part">

                    <form action="" method="post">

                        <div class="input-box">
                            <div class="input-box__wrap">
                                <input type="text" id="input_1" class="input-box__input">
                                <label for="input_1" class="input-box__label">Введите название услуги или
                                    специалиста</label>
                            </div>
                        </div>

                        <div class="input-boxes mt-20">

                            <div class="input-box">
                                <div class="input-box__wrap">
                                    <input type="email" id="input_2" class="input-box__input">
                                    <label for="input_2" class="input-box__label">Ваш город</label>
                                </div>
                                <div class="input-box__additional">
                                    <span class="far fa-calendar-alt"></span>
                                </div>
                            </div>

                            <div class="input-box">
                                <div class="input-box__wrap">
                                    <input type="email" id="input_3" class="input-box__input">
                                    <label for="input_3" class="input-box__label">Желаемая дата записи</label>
                                </div>
                                <div class="input-box__additional">
                                    <span class="far fa-calendar-alt"></span>
                                </div>
                            </div>

                        </div>

                        <div class="mt-35 between-15">

                            <input type="submit" class="button button_color_red" value="Начать поиск">

                            <a href="" class="button button_color_blue-empty">Мастер рядом</a>

                        </div>

                    </form>

                    <a href="" class="anchor-more mt-65">
                        <span class="anchor-more__arrow fas fa-arrow-down"></span>
                        <span class="anchor-more__text">Все услуги</span>
                    </a>

                </div>

                <div class="header__content-part">

                    <div uk-slideshow="animation: slide">

                        <div class="uk-position-relative uk-visible-toggle uk-light uk-background-default uk-padding-small uk-border-rounded">

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
    </div>
</div>


<div class="service-list-wrap content-width">
    <div class="service-list">

        <?php foreach ($specializations as $specialization): ?>
            <a href="<?= Url::to(['executor-map/index', 'specialization' => $specialization->id]) ?>"
               class="service-list__item" data-ajax-content="true">
                <div class="service-list-item">
                    <div class="service-list-item__img"
                         style="background-image: url(https://leonardo.osnova.io/c5591b46-aefc-5aa2-7be1-9ba41cef3ea0/)"></div>
                    <div class="service-list-item__wrap">
                        <span class="service-list-item__name"><?php echo $specialization->name ?></span>
                        <div class="service-list-item__row">
                            <span class="service-list-item__prices">Цены: от <?= $modelService->getServiceMinPrice($specialization->id); ?>
                                руб.</span>
                            <span class="service-list-item__more">Подробнее</span>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>

    </div>
</div>

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
                                свободного времени, много работы, куча дел. На сегодняшний день, что касается посещения
                                салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала отличную
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
                                свободного времени, много работы, куча дел. На сегодняшний день, что касается посещения
                                салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала отличную
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
                                свободного времени, много работы, куча дел. На сегодняшний день, что касается посещения
                                салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала отличную
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
                                свободного времени, много работы, куча дел. На сегодняшний день, что касается посещения
                                салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала отличную
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
                                свободного времени, много работы, куча дел. На сегодняшний день, что касается посещения
                                салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала отличную
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
                                свободного времени, много работы, куча дел. На сегодняшний день, что касается посещения
                                салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала отличную
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
                                свободного времени, много работы, куча дел. На сегодняшний день, что касается посещения
                                салонов красоты и записи в салон, команда сервиса записи YOUR NAME придумала отличную
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