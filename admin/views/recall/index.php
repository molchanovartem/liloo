<?php

$this->setTitle('Отзывы');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="notice-index">

<?php foreach ($recalls as $recall) : ?>
    <div class="uk-card uk-card-default uk-width-1-4 uk-margin-bottom uk-float-left uk-margin-left">
        <div class="uk-card-header">
            <div class="uk-grid uk-grid-small uk-flex-middle">
                <div class="uk-width-auto">
                    <?php if ($recall->status) : ?>
                        <a href="recall/check?id=<?php echo $recall->id; ?>" class="uk-icon-button uk-margin-small-right uk-background-primary uk-light" uk-icon="check"></a>
                    <?php else: ?>
                        <a href="recall/check?id=<?php echo $recall->id; ?>" class="uk-icon-button uk-margin-small-right" uk-icon="check"></a>
                    <?php endif; ?>
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom"><?php echo $recall->getStatus($recall->status); ?></h3>
                    <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00"><?php echo $recall->create_time; ?></time></p>
                </div>
            </div>
        </div>
        <div class="uk-card-body">
            <p><?php echo $recall->text; ?></p>
        </div>
        <div class="uk-card-footer">
            <a href="recall/view?id=<?php echo $recall->id; ?>" class="uk-button uk-button-text">Подробнее</a>
        </div>
    </div>
<?php endforeach; ?>

</div>