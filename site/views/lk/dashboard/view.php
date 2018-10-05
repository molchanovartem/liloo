<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<?php

use site\widgets\header\Header;
use yii\helpers\Url;

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
                <div class="row-categories__item"><a href="" class="row-categories__link row-categories__link_current">Виктор
                        Субботин</a>
                </div>
            </div>

        </div>

    </div>
</header>
<main>
    <div class="content-width content-columns uk-margin-large-top">

        <div class="service-list-wrap">
            <div class="service-list">
                <?php foreach ($specializations as $specialization): ?>

                    <a href="<?php echo Url::to(['lk/executor-map/index', 'specialization_id' => $specialization->id]) ?>"
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

    </div>
</main>