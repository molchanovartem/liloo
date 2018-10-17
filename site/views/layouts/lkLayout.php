<?php

use yii\helpers\Url;
use site\widgets\header\Header;

?>

<header class="header bg_color_e4eff9 uk-width-1-1">
    <div class="header__container">

        <?php echo Header::widget(); ?>

        <div class="content-width">

            <div class="row-categories">
                <div class="row-categories__item"><a href="" class="row-categories__link">Главная</a></div>
                <div class="row-categories__item"><a href="" class="row-categories__link">Мастера</a></div>
                <div class="row-categories__item"><a href="" class="row-categories__link">Фотограф</a></div>
                <div class="row-categories__item"><a href="" class="row-categories__link">Москва</a></div>
                <div class="row-categories__item">
                    <a href="" class="row-categories__link row-categories__link_current">Виктор Субботин</a>
                </div>
            </div>

        </div>

    </div>
</header>

<div class="uk-container">
    <div class="uk-grid uk-margin-top">
        <div class="uk-width-2-3">
            <?= $content ?>
        </div>

        <div class="uk-width-1-3">
            <div class="uk-card-default">
                <div class="menu-blocks">
                    <a href="<?php echo Url::to(['lk/executor-map']); ?>" class="menu-blocks__item">
                        <span class="menu-blocks__item-name">Каталог</span>
                    </a>
                    <a href="<?php echo Url::to(['lk/selected-masters']); ?>" class="menu-blocks__item">
                        <span class="menu-blocks__item-name">Избранные мастера</span>
                    </a>
                    <a href="" class="menu-blocks__item">
                        <span class="menu-blocks__item-name">Акции</span>
                    </a>
                    <a href="<?php echo Url::to(['lk/appointment/view']); ?>"
                       class="menu-blocks__item">
                        <span class="menu-blocks__item-name">Записи</span>
                    </a>
                    <a href="<?php echo Url::to(['lk/recall']); ?>" class="menu-blocks__item">
                        <span class="menu-blocks__item-name">Отзывы</span>
                    </a>
                    <a href="" class="menu-blocks__item">
                        <span class="menu-blocks__item-name">Уведомления</span>
                    </a>
                    <a href="<?php echo Url::to(['lk/profile/view']); ?>"
                       class="menu-blocks__item" data-ajax-content="true">
                        <span class="menu-blocks__item-name">Профиль</span>
                    </a>
                </div>

            </div>
            <?php if (isset($this->blocks['cart'])) echo $this->blocks['cart']; ?>

        </div>
    </div>
</div>
