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
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.2.0/css/all.css"
              integrity="sha384-TXfwrfuHVznxCssTxWoPZjhcss/hp38gEOH8UPZG/JcXonvBQ6SlsIF49wUzsGno"
              crossorigin="anonymous">
        <link rel="stylesheet" type="text/css"
              href="<?php echo Yii::getAlias('@web'); ?>/build/vendors/uikit/css/uikit.css">
        <link rel="stylesheet" type="text/css"
              href="<?php echo Yii::getAlias('@web'); ?>/build/vendors/uikit/css/uikit-rtl.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/css/slick.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/css/slick-theme.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/css/fonts.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/css/additional.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/css/elements.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/css/init.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/css/responsive.css">

        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css">
    </head>
    <body>
    <?php $this->beginBody(); ?>
    <header class="header bg_image_header-main">
        <div class="header__container">

            <div class="header__wrap content-width">

                <div class="header__wrap-part">

                    <a class="logo" href="/"><img
                                src="http://upload.wikimedia.org/wikipedia/commons/a/ab/Logo_TV_2015.png" alt="logo"
                                class="logo__img"></a>

                </div>

                <div class="header__wrap-part header__wrap-part_actions">

                    <a href="" class="choose-city">
                        <span class="choose-city__fa fas fa-map-marker-alt"></span>
                        <span class="choose-city__text">Москва</span>
                    </a>

                    <?php echo Html::a("<button class='button button_color_blue button_in_header'>Регистрация для исполнителя</button>", '/site/web/user/signup'); ?>

                    <?php echo Html::a("<button class='button button_color_blue button_in_header'>Каталог</button>", '/site/web/executor'); ?>

                    <?php echo Html::a("Войти", '/site/web/site/login', ['class' => 'font_Gilroy-17-800-000000']); ?>

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
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Косметолог</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Визажист</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Стилист</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Фотограф</a>
                                            </li>
                                        </ul>
                                        <ul class="footer-menu__ul">
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Косметолог</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Визажист</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Стилист</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Брови,
                                                    ресницы</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>


        </div>
    </header>
    <main>
        <?= $content; ?>
    </main>

    <?php echo $this->render('footer'); ?>

    <script src="<?php echo Yii::getAlias('@web'); ?>/build/vendors/uikit/js/uikit.js"></script>
    <script src="<?php echo Yii::getAlias('@web'); ?>/build/vendors/uikit/js/uikit-icons.js"></script>
    <script src="<?php echo Yii::getAlias('@web'); ?>/public/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo Yii::getAlias('@web'); ?>/public/js/slick.min.js"></script>
    <script src="<?php echo Yii::getAlias('@web'); ?>/public/js/main.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>