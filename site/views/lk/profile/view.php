<?php

use yii\helpers\Html;

?>

<div class="content-columns__column content-column__column_main">

    <div class="content-block p-40 content-block_shadow uk-background-default">

        <div class="j-c_s-b">
            <div class="content-block__title">Информация обо мне</div>
            <?php echo Html::a("Редактировать", '/site/web/lk/profile/update', ['class' => 'button button_color_blue-empty']); ?>
        </div>

        <div class="performer mt-40">
            <div class="performer__img performer__img_upload"></div>
            <div class="performer__info">
                <div class="label-status label-status_bg_gray label-status_fz_14">Обычный</div>
                <div class="performer__name">
                    <?php echo Html::encode($data['model']->profile->name); ?><?php echo Html::encode($data['model']->profile->surname); ?>
                </div>
            </div>
        </div>

        <div class="font_type_3 mt-25">
            <?php echo Html::encode($data['model']->profile->description); ?>
        </div>
        <div class="font_type_3 mt-25">
            <?php echo Html::encode($data['model']->profile->city->name); ?>
        </div>

        <div class="font_type_3 mt-25">
            <?php echo Html::encode($data['model']->profile->country->name); ?>
        </div>

        <div class="font_type_3 mt-25">
            <?php echo Html::encode($data['model']->profile->date_birth); ?>
        </div>

        <div class="font_type_3 mt-25">
            <?php echo Html::encode($data['model']->profile->phone); ?>
        </div>

    </div>

</div>

