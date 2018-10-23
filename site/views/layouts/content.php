<?php

use site\widgets\breadcrumbs\Breadcrumbs;

?>
<div class="uk-container">
    <h1 class="h1 h1_page_performers"><?= $this->getHeading();?></h1>

    <div class="row-categories">
        <?php echo Breadcrumbs::widget([
            'links' => $this->getBreadcrumbs(),
        ]); ?>
    </div>
</div>
<?= $content; ?>