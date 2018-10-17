<?php

use yii\helpers\Url;

?>

<div class="content-columns uk-margin-large-top">

    <div class="service-list-wrap">
        <div class="service-list">
            <?php foreach ($data['specializations'] as $specialization): ?>

                <a href="<?php echo Url::to(['lk/executor-map/index', 'specialization_id' => $specialization->id]) ?>"
                   class="service-list__item" data-ajax-content="true">
                    <div class="service-list-item">
                        <div class="service-list-item__img"
                             style="background-image: url(https://leonardo.osnova.io/c5591b46-aefc-5aa2-7be1-9ba41cef3ea0/)"></div>
                        <div class="service-list-item__wrap">
                            <span class="service-list-item__name"><?php echo $specialization->name ?></span>
                            <div class="service-list-item__row">
                                    <span class="service-list-item__prices">
<!--                                        Цены: от --><?//= $modelService->getServiceMinPrice($specialization->id); ?><!-- руб.-->
                                    </span>
                                <span class="service-list-item__more">Подробнее</span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

</div>
