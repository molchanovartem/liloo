<?php

use yii\captcha\Captcha;
use site\widgets\activeForm\ActiveForm;
use site\widgets\MaskedTextInputWidget as MasketWidget;

?>
<h1 class="h1 h1_page_performers uk-text-center">Вход</h1>

<div class="uk-container">
    <div class="uk-flex uk-flex-center">
        <div class="uk-width-xlarge block_type_1">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->errorSummary($data['form']); ?>

            <div class="uk-margin input-box">
                <div class="input-box__wrap">
                    <?= $form->field($data['form'], 'phone')
                        ->widget(MasketWidget::class, ['pattern' => '(99) 9999-9999'])
                        ->label('Введите ваш телефон');
                    ?>
                </div>
            </div>
            <div class="uk-margin input-box">
                <div class="input-box__wrap">
                    <?= $form->field($data['form'], 'password')->passwordInput([
                        'required' => true,
                    ])->label('Введите пароль'); ?>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-text-center">
                    <b class="mt-20">Введите текст с картинки</b>
                </div>
                <?= $form->field($data['form'], 'verifyCode')->widget(Captcha::class, [
                    'captchaAction' => '/auth/captcha',
                    'template' => '<div class="uk-grid-large" uk-grid>
                                <div class="input-box mt-20 uk-margin-large-left uk-width-1-2">
                                    <div class="input-box__wrap">{input}</div>
                                </div>
                                <div class="uk-padding-remove uk-margin-small-top uk-margin-left uk-width-1-3">{image}</div>
                           </div>',
                    'options' => [
                        'class' => 'uk-form-small input-box__input',
                        //'required' => true,
                    ]
                ])->label(false); ?>
            </div>
            <div class="uk-margin uk-text-center">
                <button class="button button_color_red">Войти</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <!--    <div class="font_type_8 mt-40 t-a_c">Быстрая регистрация</div>-->
    <!--    <div class="social-buttons mt-30">-->
    <!--        <a href="" class="button button_color_vk"><span class="fab button__icon fa-vk"></span>-->
    <!--            <span class="">ВКонтакте</span>-->
    <!--        </a>-->
    <!--        <a href="" class="button button_color_fb"><span class="fab button__icon fa-facebook-square"></span>-->
    <!--            <span class="">Facebook</span>-->
    <!--        </a>-->
    <!--        <a href="" class="button button_color_ok"><span class="fab button__icon fa-odnoklassniki"></span>-->
    <!--            <span class="">Одноклассники</span>-->
    <!--        </a>-->
    <!--    </div>-->

</div>