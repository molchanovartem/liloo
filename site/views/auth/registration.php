<?php

use site\widgets\activeForm\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;

$this->setHeading('Регистрируйся и записывайся к лучшим и проверенным мастерам');

?>
<div class="content-width content-width_w_550">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>
    <?php //TODO разобраться с radio button ?>
    <div class="j-c_c">
        <div class="type-switcher mt-25 js-switch-register type-switcher_in_register">
            <?= $form->field($model, 'type')->radio([
                'label' => false,
                'class' => 'type-switcher__input',
                'value' => \site\models\User::TYPE_CLIENT,
                'id' => 'input_1_1',
                'checked' => 'checked'
            ]); ?>

            <label for="input_1_1" class="type-switcher__value font_Gilroy-17-800-000000">Я клиент, ищу мастера</label>
            <?= $form->field($model, 'type')->radio([
                'label' => false,
                'class' => 'type-switcher__input',
                'value' => \site\models\User::TYPE_MASTER,
                'id' => 'input_1_2',
            ]) ?>

            <label for="input_1_2" class="type-switcher__value font_Gilroy-17-800-000000">Я мастер, ищу работу</label>
            <div class="type-switcher__active"></div>
        </div>
    </div>

    <div class="block_type_1 mt-35">

        <?= $form->field($model, 'type')->hiddenInput([
            'value' => \site\models\User::TYPE_CLIENT,
        ])->label(false); ?>

        <div class="input-box">
            <div class="input-box__wrap">
                <?= $form->field($model, 'phone')->textInput([
                    'autofocus' => true,
                    'required' => true,
                ])->label('Введите ваш телефон'); ?>
            </div>
        </div>

        <div class="input-box mt-20">
            <div class="input-box__wrap">
                <?= $form->field($model, 'password')->passwordInput([
                    'required' => true,
                ])->label('Введите пароль'); ?>
            </div>
        </div>
        <br>
        <div class="uk-text-center">
            <b class="mt-20">Введите текст с картинки</b>
        </div>
        <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
            'captchaAction' => '/auth/captcha',
            'template' => '  
                            <div class="uk-grid-large " uk-grid>
                            
                                <div class="input-box mt-20 uk-margin-large-left uk-width-1-2">
                                    <div class="input-box__wrap">{input}</div>
                                </div>
                            
                                <div class="uk-padding-remove uk-margin-small-top uk-margin-left uk-width-1-3">{image}</div>
                            </div>',
            'options' => [
                'class' => 'uk-form-small input-box__input',
                'required' => true,
            ]
        ])->label(false); ?>

        <div class="mt-35 between-15 uk-text-center">
            <?= Html::submitButton('Регистрация', [
                'class' => 'button button_color_red',
                'name' => 'login-button'
            ]); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="font_type_8 mt-40 t-a_c">Быстрая регистрация</div>
    <div class="social-buttons mt-30">
        <a href="" class="button button_color_vk"><span class="fab button__icon fa-vk"></span><span
                    class="">ВКонтакте</span></a>
        <a href="" class="button button_color_fb"><span class="fab button__icon fa-facebook-square"></span><span
                    class="">Facebook</span></a>
        <a href="" class="button button_color_ok"><span class="fab button__icon fa-odnoklassniki"></span><span class="">Одноклассники</span></a>
    </div>

</div>
