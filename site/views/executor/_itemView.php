<?php use yii\helpers\Html; ?>
<div class="uk-card uk-card-default uk-width-auto uk-margin-top">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small uk-flex-middle">
            <div class="uk-width-auto">
                <img class="uk-border-circle" width="60" height="60"
                     src="http://mycs.net.au/wp-content/uploads/2016/03/person-icon-flat.png">
            </div>
            <div class="uk-width-expand">
                <h3 class="uk-card-title uk-margin-remove-bottom"><?= $model['name']; ?></h3>
                <p class="uk-text-meta uk-margin-remove-top">
                    <span class="uk-label uk-label-success">+<?php echo $model['like']; ?></span>
                    <span class="uk-label uk-label-danger">-<?php echo $model['dislike']; ?></span>
                </p>
            </div>
        </div>
    </div>
    <div class="uk-card-body">
        <h5>Адрес</h5>
        <p><?php echo $model['address']; ?></p>
        <h5>Услуги</h5>
        <?php foreach ($model['services'] as $service): ?>
            <p><?= $service['name']; ?> - <?= $service['price']; ?> руб.</p>
        <?php endforeach; ?>
        <h5>Доступное время по вашему запросу</h5>
<!--        --><?php //foreach ($model['validTime'] as $time): ?>
<!--            <span class="uk-label">--><?php //echo $time; ?><!--</span>-->
<!--        --><?php //endforeach; ?>
    </div>
    <div class="uk-card-footer">
        <?php if ($model['isSalon']): ?>
            <?php echo Html::a('Записаться', '/site/web/executor/salon-view?id=' . $model['id'], ['class' => 'uk-button uk-button-text']); ?>
        <?php else: ?>
            <?php echo Html::a('Записаться', '/site/web/executor/user-view?id=' . $model['id'], ['class' => 'uk-button uk-button-text']); ?>
        <?php endif; ?>
    </div>
</div>
