<?php

use site\widgets\activeForm\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;

//?>
<!---->
<!--<div class="uk-container">-->
<!--    <div class="uk-grid uk-grid-small uk-child-width-1-2 uk-margin-top">-->
<!--        <div>-->
<!--            <div class="uk-background-muted uk-padding uk-border-rounded">-->
<!--                <div class="uk-text-center">-->
<!--                    <h1 class="h1 h1_page_main">Регистрация для пользователя</h1>-->
<!--                </div>-->
<!--                <div class="header__content-parts">-->
<!--                    <div class="header__content-part">-->
<!---->
<!--                        --><?php //$form = ActiveForm::begin(); ?>
<!---->
<!--                        --><? //= $form->errorSummary($model); ?>
<!---->
<!--                        --><? //= $form->field($model, 'type')->hiddenInput([
//                            'value' => \site\models\User::TYPE_CLIENT,
//                            'id' => 'type-user',
//                        ])->label(false); ?>
<!---->
<!--                        <div class="input-box">-->
<!--                            <div class="input-box__wrap">-->
<!--                                --><? //= $form->field($model, 'phone')->textInput([
//                                    'autofocus' => true,
//                                    'id' => 'phone-user',
//                                    'required' => true,
//                                ])->label('Введите ваш телефон'); ?>
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="input-box mt-20">-->
<!--                            <div class="input-box__wrap">-->
<!--                                --><? //= $form->field($model, 'password')->passwordInput([
//                                    'id' => 'password-user',
//                                    'required' => true,
//                                ])->label('Введите пароль'); ?>
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        --><? //= $form->field($model, 'verifyCode')->widget(Captcha::class, [
//                            'captchaAction' => '/auth/captcha',
//                            'template' => '{image}<br>{input}',
//                            'options' => [
//                                'required' => true,
//                            ]
//                        ])->label(false); ?>
<!---->
<!--                        <div class="mt-35 between-15 uk-text-center">-->
<!--                            --><? //= Html::submitButton('Регистрация', [
//                                'class' => 'button button_color_red',
//                                'name' => 'login-button'
//                            ]); ?>
<!--                        </div>-->
<!---->
<!--                        --><?php //ActiveForm::end(); ?>
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div>-->
<!--            <div class="uk-background-secondary uk-padding uk-light uk-border-rounded">-->
<!--                <div class="uk-text-center">-->
<!--                    <h1 class="h1 h1_page_main">Регистрация для исполнителя</h1>-->
<!--                </div>-->
<!--                <div class="header__content-parts">-->
<!--                    <div class="header__content-part">-->
<!---->
<!--                        --><?php //$form = ActiveForm::begin(); ?>
<!---->
<!--                        --><? //= $form->errorSummary($model); ?>
<!---->
<!--                        --><? //= $form->field($model, 'type')->hiddenInput([
//                            'value' => \site\models\User::TYPE_MASTER
//                        ])->label(false); ?>
<!---->
<!--                        <div class="input-box">-->
<!--                            <div class="input-box__wrap">-->
<!--                                --><? //= $form->field($model, 'phone')->textInput([
//                                    'autofocus' => true,
//                                    'required' => true,
//                                ])->label('Введите ваш телефон'); ?>
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="input-box mt-20">-->
<!--                            <div class="input-box__wrap">-->
<!--                                --><? //= $form->field($model, 'password')->passwordInput([
//                                    'required' => true,
//                                ])->label('Введите пароль'); ?>
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        --><? //= $form->field($model, 'verifyCode')->widget(Captcha::class, [
//                            'captchaAction' => '/auth/captcha',
//                            'template' => '{image}<br>{input}',
//                            'options' => [
//                                'id' => 'registrationform-verifycode-master',
//                                'required' => true,
//                            ]
//                        ])->label(false); ?>
<!---->
<!--                        <div class="mt-35 between-15 uk-text-center">-->
<!--                            --><? //= Html::submitButton('Регистрация', [
//                                'class' => 'button button_color_red',
//                                'name' => 'login-button'
//                            ]); ?>
<!--                        </div>-->
<!---->
<!--                        --><?php //ActiveForm::end(); ?>
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<body class="bg_color_e4eff9">
<header class="header">
    <div class="header__container">

        <?php echo \site\widgets\header\Header::widget(); ?>

    </div>
</header>
<div class="content-width content-width_w_550">

    <h1 class="font_type_7 t-a_c">Регистрируйся и записывайся к лучшим и проверенным мастерам</h1>

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


        <!--        <form>-->
        <!--            <div class="input-box field-box_opened">-->
        <!--                <div class="input-box__wrap">-->
        <!--                    <input type="text" id="window_2__input_1" class="input-box__input" value="+79288237895">-->
        <!--                    <label for="window_2__input_1" class="input-box__label">Введите номер телефона</label>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <label class="checkbox mt-35">-->
        <!--                <span class="checkbox__text checkbox__text_color_000">Нажимая на кнопку «Зарегистрироваться», я даю согласие на обработку персональных данных, соглашаюсь с публичной офертой ООО «Лилу» и правилами сайта.</span>-->
        <!--                <input type="checkbox">-->
        <!--                <span class="checkbox__mark"></span>-->
        <!--            </label>-->
        <!--            <div class="mt-35 between-25">-->
        <!--                <input type="submit" class="button button_color_red" value="Зарегистрироваться">-->
        <!--                <a href="" class="font_Gilroy-17-800-000000">У меня есть аккаунт</a>-->
        <!--            </div>-->
        <!--        </form>-->
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
