<?php

use yii\helpers\Html;

$this->setBreadcrumbs(['Профиль']);
?>

<div class="uk-margin-top content-columns__column content-column__column_main">

    <div class="content-block p-40 content-block_shadow uk-background-default">

        <div class="j-c_s-b">
            <div class="content-block__title">Информация обо мне</div>
            <?php echo Html::encode($data['model']->profile->city->name); ?>
        </div>

        <div class="performer mt-40">
            <div class="performer__img performer__img_upload"></div>
            <div class="performer__info">
                <div class="label-status label-status_bg_gray label-status_fz_14">Обычный</div>
                <div class="performer__name">
                    <?php echo Html::encode($data['model']->profile->name); ?>
                    <?php echo Html::encode($data['model']->profile->surname); ?>
                </div>
            </div>
        </div>

        <div class="uk-margin-left">

            <div class="font_type_3 mt-25">
                <h5>
                    <b>День рождения:</b> <?php echo Html::encode($data['model']->profile->date_birth); ?>
                    <i class="mdi mdi-help-circle-outline uk-text-primary"></i>

                    <div uk-dropdown="mode: hover">
                        Если мастера проводят акции в день рождения, то вам придет сообщение об этом.
                    </div>

                </h5>
            </div>

            <div class="font_type_3 mt-25">
                <h5>
                    <b>Телефон:</b> <?php echo Html::encode($data['model']->profile->phone); ?>
                </h5>
            </div>

        </div>
        <div class="font_type_3 mt-25">
            <?php echo Html::a('Редактировать', 'update', ['class' => 'button button_color_blue-empty']); ?>
            <?php echo Html::a('Сброс пароля', 'reset-password', ['class' => 'button button_color_gray-empty']); ?>
        </div>

    </div>

</div>
