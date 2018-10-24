<?php

$this->setBreadcrumbs(['Уведомления']);

?>

<div class="font_type_12 uk-margin-bottom">Отзывы:</div>
<div class="uk-grid">
    <?php foreach ($data['notices'] as $recall): ?>
        <div class="uk-alert-primary" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p><?php echo var_dump($recall->data); ?></p>
        </div>
    <?php endforeach; ?>
</div>
