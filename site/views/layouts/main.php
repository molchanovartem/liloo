<?php

use yii\helpers\Html;
use yii\helpers\Url;

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
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/dist/vendor.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/dist/style.min.css">
        <script src="<?php echo Yii::getAlias('@web'); ?>/public/dist/vendor.min.js"></script>
        <script src="<?php echo Yii::getAlias('@web'); ?>/public/dist/script.min.js"></script>
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

                    <?php echo Html::a("<button class='button button_color_blue button_in_header'>Каталог</button>", '/site/web/executor'); ?>

                        <?php if (Yii::$app->user->isGuest): ?>
                            <?php echo Html::a("<button class='button button_color_blue button_in_header'>Регистрация для исполнителя</button>", '/site/web/auth/registration'); ?>

                            <?php echo Html::a("Войти", '/site/web/auth/login', ['class' => 'font_Gilroy-17-800-000000']); ?>
                        <?php else: ?>
                            <?= Html::beginForm(['/auth/logout'], 'post')
                            . Html::submitButton(
                                    'Logout (' . Yii::$app->user->identity->login . ')',
                                    ['class' => 'button button_color_blue button_in_header']
                            )
                            . Html::endForm(); ?>
                        <?php endif; ?>

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
    <main id="appContent"><?= $content; ?></main>

    <?php echo $this->render('footer'); ?>

    <div id="appSpinner" class="uk-position-fixed uk-position-center" uk-spinner="ratio: 3" style="display: none;"></div>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>