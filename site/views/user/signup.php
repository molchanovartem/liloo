<div class="uk-grid uk-grid-small uk-child-width-1-2 uk-margin-top">
    <div>
        <div class="uk-background-muted uk-padding uk-border-rounded">
            <div class="uk-text-center">
                <h1 class="h1 h1_page_main">Регистрация для пользователя</h1>
            </div>
            <div class="header__content-parts">
                <div class="header__content-part">
                    <form action="/site/web/index.php/user/signup" method="post">
                        <?php use yii\helpers\Html;

                        echo Html:: hiddenInput(\Yii:: $app->getRequest()->csrfParam, \Yii:: $app->getRequest()->getCsrfToken(), []); ?>
                        <input name="SignupForm[type]" type="hidden" value="1">
                        <div class="input-box">
                            <div class="input-box__wrap">
                                <input name="SignupForm[phone]" type="tel" id="input_phone_user" required
                                       pattern="\+7\-[0-9]{3}\-[0-9]{3}\-[0-9]{2}\-[0-9]{2}"
                                       class="input-box__input">
                                <label for="input_phone_user" class="input-box__label">Введите ваш телефон</label>
                            </div>
                        </div>
                        <div class="input-box mt-20">
                            <div class="input-box__wrap">
                                <input name="SignupForm[password]" type="password" id="input_password_user" required
                                       class="input-box__input">
                                <label for="input_password_user" class="input-box__label">Введите пароль</label>
                            </div>
                        </div>
                        <div class="mt-35 between-15 uk-text-center">
                            <input type="submit" class="button button_color_red" value="Регистрация">
                        </div>
                    </form>
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
                    <form action="/site/web/index.php/site/signup" method="post">
                        <?php echo Html:: hiddenInput(\Yii:: $app->getRequest()->csrfParam, \Yii:: $app->getRequest()->getCsrfToken(), []); ?>
                        <input name="SignupForm[type]" type="hidden" value="2">
                        <div class="input-box">
                            <div class="input-box__wrap">
                                <input name="SignupForm[phone]" type="tel" id="input_phone_executor" required
                                       pattern="\+7\-[0-9]{3}\-[0-9]{3}\-[0-9]{2}\-[0-9]{2}"
                                       class="input-box__input">
                                <label for="input_phone_executor" class="input-box__label">Введите ваш телефон</label>
                            </div>
                        </div>

                        <div class="input-box mt-20">
                            <div class="input-box__wrap">
                                <input name="SignupForm[password]" type="password" id="input_password_executor" required
                                       class="input-box__input">
                                <label for="input_password_executor" class="input-box__label">Введите пароль</label>
                            </div>
                        </div>
                        <div class="mt-35 between-15 uk-text-center">
                            <input type="submit" class="button button_color_red" value="Регистрация">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs('$(function () {
        $("#input_phone_user").mask("8(999) 999-9999");
    });');
?>