<?php use site\widgets\header\Header;

$this->beginContent('@site/views/layouts/main.php'); ?>

<div>
    <div class="pb-250 bg_color_e4eff9">
        <?php echo Header::widget(); ?>
    </div>
    <?= $content; ?>
</div>
<?php $this->endContent(); ?>
