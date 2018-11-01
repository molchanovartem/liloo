<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use site\widgets\activeForm\ActiveForm;
use site\widgets\MaskedTextInputWidget as MasketWidget;
use common\models\User;

$this->setHeading('Регистрируйся и записывайся к лучшим и проверенным мастерам');

?>
<div class="uk-container">
    <div class="uk-flex uk-flex-center">

        <?php $form = ActiveForm::begin(); ?>
        <div class="j-c_c uk-margin-medium-bottom">
            <div class="type-switcher mt-25 js-switch-register type-switcher_in_register">
                <input type="radio" name="RegistrationForm[type]" id="input_1_1" class="type-switcher__input"
                       onclick="registrationBgBlue()" value="<?php echo User::TYPE_CLIENT; ?>" checked="checked">
                <label for="input_1_1" class="type-switcher__value font_Gilroy-17-800-000000">Я клиент, ищу
                    мастера</label>
                <input type="radio" name="RegistrationForm[type]" id="input_1_2" class="type-switcher__input"
                       onclick="registrationBgWhite()" value="<?php echo User::TYPE_EXECUTOR; ?>">
                <label for="input_1_2" class="type-switcher__value font_Gilroy-17-800-000000">Я мастер, ищу
                    работу</label>
                <div class="type-switcher__active"></div>
            </div>
        </div>

        <div class="uk-width-xlarge block_type_1">

            <?= $form->errorSummary($data['form']); ?>

            <div class="uk-margin input-box">
                <div class="input-box__wrap">
                    <?= $form->field($data['form'], 'phone')
                        ->widget(MasketWidget::class, ['pattern' => '9 (999) 999 99 99', 'options' => ['class' => 'uk-form-small input-box__input', 'placeholder' => '9 (999) 999 99 99']])
                        ->label(false);
                    ?>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-text-center">
                    <b class="mt-20">Введите текст с картинки</b>
                </div>
                <?= $form->field($data['form'], 'verifyCode')->widget(Captcha::class, [
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
            </div>

            <label class="checkbox mt-35">
                <span class="checkbox__text checkbox__text_color_000">
                    Нажимая на кнопку «Зарегистрироваться», я даю согласие на обработку персональных
                    данных, соглашаюсь с публичной офертой ООО «Лилу» и правилами сайта.
                </span>
                <input name="RegistrationForm[deal]" type="checkbox" required>
                <span class="checkbox__mark"></span>
            </label>

            <div class="mt-35 between-25">
                <input type="submit" class="button button_color_red" value="Зарегистрироваться">
                <?php echo Html::a("У меня есть аккаунт", ['/auth/login'], ['class' => 'font_Gilroy-17-800-000000']); ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
<script>
    function bgWhite() {
        $('#appContent').find('.bg_color_e4eff9').css('background-color', '#ffffff');
    }

    function bgBlue() {
        $('#appContent').find('.bg_color_e4eff9').css('background-color', '#e4eff9');
    }
</script>
