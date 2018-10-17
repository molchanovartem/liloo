<?php

use site\widgets\breadcrumbs\Breadcrumbs;

?>

<?php echo \site\widgets\header\Header::widget(); ?>
<div class="uk-container">
    <h1 class="h1 h1_page_performers"><?= $this->getHeading(); ?></h1>

    <div class="uk-margin-top">
        <div class="row-categories">
            <?php echo Breadcrumbs::widget([
                'links' => $this->getBreadcrumbs(),
            ]); ?>
        </div>
    </div>

    <div class="uk-margin-top">
        <?= $content; ?>
    </div>
</div>
