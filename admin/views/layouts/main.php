<?php

/* @var $this \yii\web\View */

/* @var $content string */

use admin\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
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

    <link rel="shortcut icon" href="/favicon.ico">
    <title>Элементы - Сервис Мастеров</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body>
<?php $this->beginBody() ?>
<div class="uk-container-fluid">
    <nav class="uk-navbar-container uk-light" uk-navbar style="background-color: #1e87f0">
        <div class="uk-navbar-left">
            <div class="uk-navbar-item uk-logo">
                <a href="#">liloo</a>
            </div>

            <ul class="uk-navbar-nav">
                <li>
                    <a href="#">
                        <span class="uk-icon uk-margin-small-right" uk-icon="icon: star"></span>
                        Features
                    </a>
                </li>
            </ul>

            <div class="uk-navbar-item">
                <div>Some <a href="#">Link</a></div>
            </div>
        </div>
    </nav>

    <div class="uk-grid uk-grid-collapse">
        <div id="kek" class="uk-background-muted uk-width-1-6">
            <div class="uk-background-muted uk-padding-small uk-height-max-large">
                <ul class="uk-nav-default uk-nav-parent-icon" uk-nav="multiple: true">
                    <li><a href="/admin/web/index.php/user">Пользователи</a></li>
                    <li><a href="#">Уведомления</a></li>
                    <li class="uk-parent">
                        <a href="#">Parent</a>
                        <ul class="uk-nav-sub">
                            <li><a href="#">Sub item</a></li>
                            <li>
                                <a href="#">Sub item</a>
                                <ul>
                                    <li><a href="#">Sub item</a></li>
                                    <li><a href="#">Sub item</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="uk-parent">
                        <a href="#">Parent</a>
                        <ul class="uk-nav-sub">
                            <li><a href="#">Sub item</a></li>
                            <li><a href="#">Sub item</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="uk-width-5-6">
            <div class="uk-padding-small">
                <div>
                    <h1><?= $this->getTitle(); ?></h1>
                </div>
                <?= $content; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
