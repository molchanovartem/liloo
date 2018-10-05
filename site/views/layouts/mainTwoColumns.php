<?php use yii\helpers\Url; ?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

    <div class="uk-grid">

        <?= $content ?>

        <div class="uk-card-default uk-margin-top uk-width-1-5 uk-padding-small uk-margin-large-right">

            <div class="menu-blocks">
                <a href="" class="menu-blocks__item">
                    <span class="menu-blocks__item-name">Каталог</span>
                </a>
                <a href="" class="menu-blocks__item">
                    <span class="menu-blocks__item-name">Избранные мастера</span>
                </a>
                <a href="" class="menu-blocks__item">
                    <span class="menu-blocks__item-name">Акции</span>
                </a>
                <a href="<?php echo Url::to(['lk/appointment/view?id=' . \Yii::$app->user->identity->id]); ?>"
                   class="menu-blocks__item">
                    <span class="menu-blocks__item-name">Записи</span>
                </a>
                <a href="" class="menu-blocks__item">
                    <span class="menu-blocks__item-name">Отзывы</span>
                </a>
                <a href="" class="menu-blocks__item">
                    <span class="menu-blocks__item-name">Уведомления</span>
                </a>
                <a href="<?php echo Url::to(['lk/profile/view?id=' . \Yii::$app->user->identity->id]); ?>"
                   class="menu-blocks__item">
                    <span class="menu-blocks__item-name">Профиль</span>
                </a>
            </div>

        </div>
    </div>

<?php $this->endContent(); ?>
