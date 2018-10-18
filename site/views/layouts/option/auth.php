<?php use site\widgets\header\Header;

$this->beginContent('@site/views/layouts/main.php'); ?>
<div class="bg_color_e4eff9">
    <?php echo Header::widget(); ?>
    <div id="appContent"><?= $content; ?></div>

</div>
<?php $this->endContent(); ?>
