<?php

use yii\helpers\Html;
use site\widgets\cityWidget\Widget as CityWidget;

?>

<div class="header__wrap content-width">

    <div class="header__wrap-part">
        <a class="logo" href="/">
            <img src="http://upload.wikimedia.org/wikipedia/commons/a/ab/Logo_TV_2015.png" alt="logo" class="logo__img">
        </a>

    </div>
    <div class="header__wrap-part header__wrap-part_actions">
        <?php echo CityWidget::widget(); ?>
        <a href="" class="choose-city">
            <span class="choose-city__fa fas fa-map-marker-alt"></span>
            <span class="choose-city__text"></span>
        </a>

        <?php echo Html::a("<button class='button button_color_blue button_in_header'>Каталог</button>", '/site/web/executor-map'); ?>

        <?php if (Yii::$app->user->isGuest): ?>
            <?php echo Html::a("<button class='button button_color_blue button_in_header'>Регистрация для исполнителя</button>", '/site/web/auth/registration'); ?>

            <?php echo Html::a("Войти", '/site/web/auth/login', ['class' => 'font_Gilroy-17-800-000000']); ?>
        <?php else: ?>
            <?php
                echo Html::beginForm(['/auth/logout'], 'post')
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
                                <li class="footer-menu__li">
                                    <a href="" class="footer-menu__a">Косметолог</a>
                                </li>
                                <li class="footer-menu__li">
                                    <a href="" class="footer-menu__a">Визажист</a>
                                </li>
                                <li class="footer-menu__li">
                                    <a href="" class="footer-menu__a">Стилист</a>
                                </li>
                                <li class="footer-menu__li">
                                    <a href="" class="footer-menu__a">Фотограф</a>
                                </li>
                            </ul>
                            <ul class="footer-menu__ul">
                                <li class="footer-menu__li">
                                    <a href="" class="footer-menu__a">Косметолог</a>
                                </li>
                                <li class="footer-menu__li">
                                    <a href="" class="footer-menu__a">Визажист</a>
                                </li>
                                <li class="footer-menu__li">
                                    <a href="" class="footer-menu__a">Стилист</a>
                                </li>
                                <li class="footer-menu__li">
                                    <a href="" class="footer-menu__a">Брови, ресницы</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
