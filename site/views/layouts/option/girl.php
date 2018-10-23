<?php use site\widgets\header\Header;

$this->beginContent('@site/views/layouts/main.php'); ?>

<div class="bg_image_header-main">
    <?php echo Header::widget(); ?>
    <div id="appContent"><?= $content; ?></div>

</div>
<?php $this->endContent(); ?>
