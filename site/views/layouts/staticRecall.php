<?php use site\widgets\breadcrumbs\Breadcrumbs; ?>
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

    </div>
</div>