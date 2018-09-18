<div class="uk-card uk-card-default uk-width-auto uk-margin-top">
    <div class="uk-card-header">
        <div class="uk-grid uk-grid-small uk-flex-middle">
            <div class="uk-width-auto">
                <span uk-icon="user"></span>
            </div>
            <div class="uk-width-expand">
                <h3 class="uk-card-title uk-margin-remove-bottom">
                    <?= $model['profile']['name'] ?> <?= $model['profile']['surname'] ?>
                </h3>
                <p class="uk-text-meta uk-margin-remove-top">
                    <time datetime="2016-04-01T19:00">April 01, 2016</time>
                </p>
            </div>
        </div>
    </div>
    <div class="uk-card-body">
        <?php foreach ($model['specializations'] as $specialization): ?>
            <p><?= $specialization['name'] ?></p>
        <?php endforeach; ?>
    </div>
    <div class="uk-card-footer">
        <a href="#" class="uk-button uk-button-text">Read more</a>
    </div>
</div>
