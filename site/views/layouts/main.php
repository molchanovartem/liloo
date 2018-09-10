<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <link rel="shortcut icon" href="/favicon.ico">
    <title>Элементы - Сервис Мастеров</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-TXfwrfuHVznxCssTxWoPZjhcss/hp38gEOH8UPZG/JcXonvBQ6SlsIF49wUzsGno" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web');?>/build/vendors/uikit/css/uikit.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web');?>/build/vendors/uikit/css/uikit-rtl.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web');?>/public/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web');?>/public/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web');?>/public/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web');?>/public/css/additional.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web');?>/public/css/elements.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web');?>/public/css/init.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web');?>/public/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web');?>/public/css/responsive.css">

</head>
<body>
<header class="header bg_image_header-main">
    <div class="header__container">

        <div class="header__wrap content-width">

            <div class="header__wrap-part">

                <a class="logo" href="/"><img src="http://upload.wikimedia.org/wikipedia/commons/a/ab/Logo_TV_2015.png" alt="logo" class="logo__img"></a>

            </div>

            <div class="header__wrap-part header__wrap-part_actions">

                <a href="" class="choose-city">
                    <span class="choose-city__fa fas fa-map-marker-alt"></span>
                    <span class="choose-city__text">Москва</span>
                </a>

                <a href="user/signup"><button class="button button_color_blue button_in_header">Регистрация для исполнителя</button></a>

                <a href="" class="font_Gilroy-17-800-000000">Войти</a>

            </div>

            <div class="header__wrap-part header__wrap-part_actions">

                <a href="tel:88002345533" class="button-phone">
                    <span class="button-phone__fa fas fa-phone fa-flip-horizontal"></span>
                    <span class="button-phone__text">8 800 234-55-33</span>
                </a>

                <div class="cloud-wrap">

                        <span class="button-hamburger">
                            <span class="button-hamburger__cross">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </span>

                    <div class="cloud cloud_in_header" style="display: none;">
                        <div class="cloud__content">

                            <div class="footer-menu">
                                <div class="footer-menu__name">Специалисты</div>
                                <div class="footer-menu__uls">
                                    <ul class="footer-menu__ul">
                                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Косметолог</a></li>
                                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Визажист</a></li>
                                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Стилист</a></li>
                                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Фотограф</a></li>
                                    </ul>
                                    <ul class="footer-menu__ul">
                                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Косметолог</a></li>
                                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Визажист</a></li>
                                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Стилист</a></li>
                                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Брови, ресницы</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="header__content header__content_page_main content-width">

            <h1 class="h1 h1_page_main">Записывайтесь к лучшим и&nbsp;проверенным мастерам</h1>

            <div class="header__content-parts">

                <div class="header__content-part">

                    <form action="" method="post">

                        <div class="input-box">
                            <div class="input-box__wrap">
                                <input type="text" id="input_1" class="input-box__input">
                                <label for="input_1" class="input-box__label">Введите название услуги или специалиста</label>
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

                    <div class="services-slider">

                        <a href="" class="service-popular">
                            <span class="service-popular__tip">Популярная услуга в вашем городе</span>
                            <div class="service-popular__wrap">
                                <div class="service-popular__img" style="background-image: url(https://leonardo.osnova.io/c5591b46-aefc-5aa2-7be1-9ba41cef3ea0/)"></div>
                                <div class="service-popular__row">
                                    <span class="service-popular__name">Ресницы, брови</span>
                                    <span class="service-popular__prices">Цены: от 300 руб.</span>
                                </div>
                            </div>
                            <span class="service-popular__more">Подробнее</span>
                        </a>

                        <a href="" class="service-popular">
                            <span class="service-popular__tip">Популярная услуга в вашем городе</span>
                            <div class="service-popular__wrap">
                                <div class="service-popular__img" style="background-image: url(https://leonardo.osnova.io/c5591b46-aefc-5aa2-7be1-9ba41cef3ea0/)"></div>
                                <div class="service-popular__row">
                                    <span class="service-popular__name">Ресницы, брови</span>
                                    <span class="service-popular__prices">Цены: от 300 руб.</span>
                                </div>
                            </div>
                            <span class="service-popular__more">Подробнее</span>
                        </a>

                        <a href="" class="service-popular">
                            <span class="service-popular__tip">Популярная услуга в вашем городе</span>
                            <div class="service-popular__wrap">
                                <div class="service-popular__img" style="background-image: url(https://leonardo.osnova.io/c5591b46-aefc-5aa2-7be1-9ba41cef3ea0/)"></div>
                                <div class="service-popular__row">
                                    <span class="service-popular__name">Ресницы, брови</span>
                                    <span class="service-popular__prices">Цены: от 300 руб.</span>
                                </div>
                            </div>
                            <span class="service-popular__more">Подробнее</span>
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
</header>
<main>

    <?php $this->beginBody() ?>
    <div class="uk-container">
        <?= $content; ?>
    </div>
    <?php $this->endBody() ?>


</main>
<footer class="footer content-width">

    <div class="footer__parts">

        <div class="footer__part">

            <div class="font_Gilroy-18-800-000000">Bplus.com © 2005–2018</div>

            <div class="mt-20">
                <a href="tel:88002345533" class="button-phone">
                    <span class="button-phone__fa fas fa-phone fa-flip-horizontal"></span>
                    <span class="button-phone__text">8 800 234-55-33</span>
                </a>
            </div>

            <a class="logo mt-35" href="/"><img src="http://upload.wikimedia.org/wikipedia/commons/a/ab/Logo_TV_2015.png" alt="logo" class="logo__img"></a>

        </div>

        <div class="footer__part footer-menus">

            <div class="footer-menu">
                <div class="footer-menu__name">Профиль</div>
                <div class="footer-menu__uls">
                    <ul class="footer-menu__ul">
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Войти</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Зарегистрироваться</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Восстановить доступ</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-menu">
                <div class="footer-menu__name">Специалисты</div>
                <div class="footer-menu__uls">
                    <ul class="footer-menu__ul">
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Косметолог</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Визажист</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Стилист</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Фотограф</a></li>
                    </ul>
                    <ul class="footer-menu__ul">
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Косметолог</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Визажист</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Стилист</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Брови, ресницы</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-menu">
                <div class="footer-menu__name">Сервисы</div>
                <div class="footer-menu__uls">
                    <ul class="footer-menu__ul">
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Поиск по сайту</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Аккаунт PRO</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Платные опции в проектах</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Реклама на сайте</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-menu">
                <div class="footer-menu__name">О сайте</div>
                <div class="footer-menu__uls">
                    <ul class="footer-menu__ul">
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Помощь</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Правила</a></li>
                        <li class="footer-menu__li"><a href="" class="footer-menu__a">Команда</a></li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

</footer>
<script src="<?php echo Yii::getAlias('@web');?>/build/vendors/uikit/js/uikit.js"></script>
<script src="<?php echo Yii::getAlias('@web');?>/build/vendors/uikit/js/uikit-icons.js"></script>
<script src="<?php echo Yii::getAlias('@web');?>/public/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo Yii::getAlias('@web');?>/public/js/slick.min.js"></script>
<script src="<?php echo Yii::getAlias('@web');?>/public/js/main.js"></script>
</body>
</html>
