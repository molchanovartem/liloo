<?php $this->beginContent('@site/views/layouts/main.php'); ?>
<?php echo \site\widgets\header\Header::widget(); ?>
<?= $content; ?>
<?php $this->endContent(); ?>
