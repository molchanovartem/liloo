<?php

use yii\helpers\Html;
use yii\captcha\Captcha;
use site\widgets\activeForm\ActiveForm;

?>
<script src="https://unpkg.com/imask"></script>

<h1 class="h1 h1_page_performers uk-text-center">Вход</h1>
<div class="content-width content-width_w_550">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <div class="block_type_1 mt-35">

        <div class="input-box">
            <div class="input-box__wrap">
                <?= $form->field($model, 'phone')->textInput([
                    'id' => 'phone',
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
            'template' => '<div class="uk-grid-large" uk-grid>
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
        <a href="" class="button button_color_vk"><span class="fab button__icon fa-vk"></span>
            <span class="">ВКонтакте</span>
        </a>
        <a href="" class="button button_color_fb"><span class="fab button__icon fa-facebook-square"></span>
            <span class="">Facebook</span>
        </a>
        <a href="" class="button button_color_ok"><span class="fab button__icon fa-odnoklassniki"></span>
            <span class="">Одноклассники</span>
        </a>
    </div>

</div>
<script>
    VMasker(document.getElementById('phone')).maskPattern('(99) 9999-9999');
</script>