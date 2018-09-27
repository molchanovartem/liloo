<div class="uk-container">

    <div class="uk-grid uk-margin-top ">
        <div class="uk-width-2-3 uk-padding-remove-left">
            <div class="uk-position-relative uk-visible-toggle uk-light" uk-slider>

                <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m">
                    <li>
                        <img src="https://mysekret.ru/wp-content/uploads/2017/05/00-2.jpg" alt="">
                        <div class="uk-position-center uk-panel"><h1>1</h1></div>
                    </li>
                    <li>
                        <img src="https://mysekret.ru/wp-content/uploads/2017/05/00-2.jpg" alt="">
                        <div class="uk-position-center uk-panel"><h1>2</h1></div>
                    </li>
                    <li>
                        <img src="https://mysekret.ru/wp-content/uploads/2017/05/00-2.jpg" alt="">
                        <div class="uk-position-center uk-panel"><h1>3</h1></div>
                    </li>
                    <li>
                        <img src="https://mysekret.ru/wp-content/uploads/2017/05/00-2.jpg" alt="">
                        <div class="uk-position-center uk-panel"><h1>4</h1></div>
                    </li>
                    <li>
                        <img src="https://mysekret.ru/wp-content/uploads/2017/05/00-2.jpg" alt="">
                        <div class="uk-position-center uk-panel"><h1>5</h1></div>
                    </li>
                    <li>
                        <img src="https://mysekret.ru/wp-content/uploads/2017/05/00-2.jpg" alt="">
                        <div class="uk-position-center uk-panel"><h1>6</h1></div>
                    </li>
                    <li>
                        <img src="https://mysekret.ru/wp-content/uploads/2017/05/00-2.jpg" alt="">
                        <div class="uk-position-center uk-panel"><h1>7</h1></div>
                    </li>
                    <li>
                        <img src="https://mysekret.ru/wp-content/uploads/2017/05/00-2.jpg" alt="">
                        <div class="uk-position-center uk-panel"><h1>8</h1></div>
                    </li>
                    <li>
                        <img src="https://mysekret.ru/wp-content/uploads/2017/05/00-2.jpg" alt="">
                        <div class="uk-position-center uk-panel"><h1>9</h1></div>
                    </li>
                    <li>
                        <img src="https://mysekret.ru/wp-content/uploads/2017/05/00-2.jpg" alt="">
                        <div class="uk-position-center uk-panel"><h1>10</h1></div>
                    </li>
                </ul>

                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
                   uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
                   uk-slider-item="next"></a>

            </div>

        </div>
        <div class="uk-width-1-3">
            <div class="uk-card uk-card-default uk-card-body">
                <ul class="uk-list uk-list-divider">
                    <?php /* foreach ($data['model']->specializations as $specialization): ?>
                        <li>
                            <?php echo $specialization->name; ?>
                            <ul class="uk-list">
                                <?php foreach ($specialization->getServiceByAccount($data['model']->account_id) as $service): ?>
                                    <li><?php echo $service->name; ?> - <?php echo $service->price; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; */ ?>
                </ul>
            </div>
        </div>
    </div>

    <div class=" uk-card uk-card-default uk-width-2-3 uk-margin-top">
        <div class="uk-card-header">
            <div class="uk-grid uk-grid-small uk-flex-middle">
                <div class="uk-width-auto">
                    <img class="uk-border-circle" width="60" height="60"
                         src="http://mycs.net.au/wp-content/uploads/2016/03/person-icon-flat.png">
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom">
                        <?php echo $data['model']->profile->name ?> <?php echo $data['model']->profile->surname ?>
                    </h3>
                    <p class="uk-text-meta uk-margin-remove-top">
                        <time datetime="2016-04-01T19:00">На сайте с <?php echo $data['model']->create_time ?></time>
                    </p>
                </div>
            </div>
        </div>
        <div class="uk-card-body">
            <h4>Информация о мастере</h4>
            <p><?php echo $data['model']->profile->description; ?></p>
            <p><?php echo $data['model']->profile->city->name; ?>, <?php echo $data['model']->profile->address; ?> </p>
        </div>
    </div>

    <div class="uk-card uk-card-default uk-card-body uk-width-2-3 uk-margin-top">
        <ul class="uk-list uk-list-striped">
            <?php /* foreach ($data['model']->specializations as $specialization): ?>
                <h4 class="uk-margin-top"><?php echo $specialization->name; ?></h4>
                <?php foreach ($specialization->getServiceByAccount($data['model']->account_id) as $service): ?>
                    <li><?php echo $service->name; ?> - <?php echo $service->duration; ?>
                        - <?php echo $service->price; ?></li>
                <?php endforeach; ?>
            <?php endforeach; */ ?>
        </ul>
    </div>

    <div class="uk-card uk-card-default uk-card-body uk-width-2-3 uk-margin-top">
        <h4>Контакты</h4>
        <div class="uk-margin-top">
            <p><span uk-icon="phone"></span> <?php echo $data['model']->profile->phone ?></p>
            <hr>
            <p><span uk-icon="location"></span> <?php echo $data['model']->profile->address ?></p>
            <hr>
            <p><span uk-icon="clock"></span> Режим работы</p>
        </div>
    </div>

    <br>

    <h4>Отзывы</h4>
    <div class="uk-grid">
        <?php /* foreach ($data['model']->recalls as $recall): ?>
            <div class="uk-card uk-card-default uk-width-1-3 uk-margin-top">
                <div class="uk-card-header">
                    <div class="uk-grid uk-grid-small uk-flex-middle">
                        <div class="uk-width-auto">
                            <img class="uk-border-circle" width="60" height="60"
                                 src="http://mycs.net.au/wp-content/uploads/2016/03/person-icon-flat.png">
                        </div>
                        <div class="uk-width-expand">
                            <h3 class="uk-card-title uk-margin-remove-bottom">
                                <?php echo $recall->appointment->client->user->profile->name; ?>
                                <?php echo $recall->appointment->client->user->profile->surname; ?>
                            </h3>
                            <p class="uk-text-meta uk-margin-remove-top">
                                <time datetime="2016-04-01T19:00"><?php echo $recall->create_time; ?></time>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="uk-card-body">
                    <p><?php echo $recall->text; ?></p>
                    <?php if ($recall->assessment == \common\models\Recall::ASSESSMENT_DISLIKE): ?>
                        <p><img src="https://png.icons8.com/material-outlined/50/000000/thumbs-down.png"></p>
                    <?php else: ?>
                        <p><img src="https://png.icons8.com/material-outlined/50/000000/facebook-like.png"></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; */ ?>
    </div>
</div>
