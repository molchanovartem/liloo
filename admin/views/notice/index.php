<?php

$this->setTitle('Уведомления');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="notice-index">

    <?php foreach ($notices as $notice) : ?>
        <div class="uk-card uk-card-default uk-width-1-4 uk-margin-bottom uk-float-left uk-margin-left">
            <div class="uk-card-header">
                <div class="uk-grid uk-grid-small uk-flex-middle">
                    <div class="uk-width-auto">
                        <?php if ($notice->status) : ?>
                            <a href="check?id=<?php echo $notice->id; ?>"
                               class="uk-icon-button uk-margin-small-right uk-background-primary uk-light"
                               uk-icon="check"></a>
                        <?php else: ?>
                            <a href="check?id=<?php echo $notice->id; ?>" class="uk-icon-button uk-margin-small-right"
                               uk-icon="check"></a>
                        <?php endif; ?>
                    </div>
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title uk-margin-remove-bottom"><?php echo $notice->getType($notice->type); ?></h3>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <p><?php echo $notice->text; ?></p>
            </div>
            <div class="uk-card-footer">
                <a href="view?id=<?php echo $notice->id; ?>" class="uk-button uk-button-text">Подробнее</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>