<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/dist/vendor.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::getAlias('@web'); ?>/public/dist/style.min.css">
        <script src="<?php echo Yii::getAlias('@web'); ?>/public/dist/vendor.min.js"></script>
        <script src="<?php echo Yii::getAlias('@web'); ?>/public/dist/script.min.js"></script>
    </head>
    <body>
    <?php $this->beginBody(); ?>

    <main id="appContent"><?= $content; ?></main>

    <?php echo $this->render('footer'); ?>

    <div id="appSpinner" class="uk-position-fixed uk-position-center" uk-spinner="ratio: 3" style="display: none;"></div>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>