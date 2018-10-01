<?php

use site\widgets\activeForm\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;

?>

<div class="uk-container">
    <div class="uk-grid uk-grid-small uk-child-width-1-2 uk-margin-top">
        <div>
            <div class="uk-background-muted uk-padding uk-border-rounded">
                <div class="uk-text-center">
                    <h1 class="h1 h1_page_main">Регистрация для пользователя</h1>
                </div>
                <div class="header__content-parts">
                    <div class="header__content-part">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->errorSummary($model); ?>

                        <?= $form->field($model, 'type')->hiddenInput([
                            'value' => \site\models\User::TYPE_CLIENT,
                            'id' => 'type-user',
                        ])->label(false); ?>

                        <div class="input-box">
                            <div class="input-box__wrap">
                                <?= $form->field($model, 'phone')->textInput([
                                    'autofocus' => true,
                                    'id' => 'phone-user',
                                    'required' => true,
                                ])->label('Введите ваш телефон'); ?>
                            </div>
                        </div>

                        <div class="input-box mt-20">
                            <div class="input-box__wrap">
                                <?= $form->field($model, 'password')->passwordInput([
                                    'id' => 'password-user',
                                    'required' => true,
                                ])->label('Введите пароль'); ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                            'captchaAction' => '/auth/captcha',
                            'template' => '{image}<br>{input}',
                            'options' => [
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
                </div>
            </div>
        </div>
        <div>
            <div class="uk-background-secondary uk-padding uk-light uk-border-rounded">
                <div class="uk-text-center">
                    <h1 class="h1 h1_page_main">Регистрация для исполнителя</h1>
                </div>
                <div class="header__content-parts">
                    <div class="header__content-part">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->errorSummary($model); ?>

                        <?= $form->field($model, 'type')->hiddenInput([
                            'value' => \site\models\User::TYPE_MASTER
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

                        <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                            'captchaAction' => '/auth/captcha',
                            'template' => '{image}<br>{input}',
                            'options' => [
                                'id' => 'registrationform-verifycode-master',
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
                </div>
            </div>
        </div>
    </div>
</div>
