<?php

use site\widgets\breadcrumbs\Breadcrumbs;
use yii\helpers\Url;

?>
<div class="mt--250 uk-container">
    <h1 class="h1 h1_page_performers"><?= $this->getHeading(); ?></h1>

    <div class="uk-margin-top">
        <div class="row-categories">
            <?php echo Breadcrumbs::widget([
                'links' => $this->getBreadcrumbs(),
            ]); ?>
        </div>
    </div>

    <div class="uk-grid">
        <div class="uk-width-expand">
            <?= $content ?>
        </div>


        <div class="uk-width-auto">
            <?php if (isset($this->blocks['aboveSidebar'])): ?>
                <div class="uk-margin uk-width-medium">
                    <?php echo $this->blocks['aboveSidebar']; ?>
                </div>
            <?php endif; ?>

            <?php if (!Yii::$app->user->isGuest) : ?>
                <div class="uk-margin uk-width-medium uk-margin-top">
                    <div class="uk-card-default uk-padding-small uk-border-rounded">
                        <div class="menu-blocks">
                            <a href="<?php echo Url::to(['/executor-map']); ?>" class="menu-blocks__item">
                                <span class="menu-blocks__item-name">Каталог</span>
                            </a>
                            <a href="<?php echo Url::to(['/selected-masters']); ?>" class="menu-blocks__item">
                                <span class="menu-blocks__item-name">Избранные мастера</span>
                            </a>
                            <a href="" class="menu-blocks__item">
                                <span class="menu-blocks__item-name">Акции</span>
                            </a>
                            <a href="<?php echo Url::to(['/appointment/view']); ?>"
                               class="menu-blocks__item">
                                <span class="menu-blocks__item-name">Записи</span>
                            </a>
                            <a href="<?php echo Url::to(['/recall']); ?>" class="menu-blocks__item">
                                <span class="menu-blocks__item-name">Отзывы</span>
                            </a>
                            <a href="" class="menu-blocks__item">
                                <span class="menu-blocks__item-name">Уведомления</span>
                            </a>
                            <a href="<?php echo Url::to(['/profile/view']); ?>"
                               class="menu-blocks__item" data-ajax-content="false">
                                <span class="menu-blocks__item-name">Профиль</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($this->blocks['underSidebar'])): ?>
                <div class="uk-margin uk-width-medium">
                    <?php echo $this->blocks['underSidebar']; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
