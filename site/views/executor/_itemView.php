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
        <p><?php echo $model['address']; ?></p>
        <?php foreach ($model['service'] as $service): ?>
            <p><?= $service['name']; ?> - <?= $service['price']; ?> руб.</p>
        <?php endforeach; ?>
    </div>
    <div class="uk-card-footer">
        <?php if ($model['isSalon']): ?>
            <a href="executor/salon-view?id=<?php echo $model['id']; ?>" class="uk-button uk-button-text">Записаться</a>
        <?php else: ?>
            <a href="executor/user-view?id=<?php echo $model['id']; ?>" class="uk-button uk-button-text">Записаться</a>
        <?php endif; ?>
    </div>
</div>
