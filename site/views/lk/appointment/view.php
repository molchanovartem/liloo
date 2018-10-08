<?php

use admin\widgets\activeForm\ActiveForm;
use site\widgets\header\Header;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<header class="header bg_color_e4eff9 uk-width-1-1">
    <div class="header__container">

        <?php echo Header::widget(); ?>

        <div class="content-width">

            <div class="row-categories">
                <div class="row-categories__item"><a href="" class="row-categories__link">Главная</a></div>
                <div class="row-categories__item"><a href="" class="row-categories__link">Мастера</a></div>
                <div class="row-categories__item"><a href="" class="row-categories__link">Фотограф</a></div>
                <div class="row-categories__item"><a href="" class="row-categories__link">Москва</a></div>
                <div class="row-categories__item"><a href="" class="row-categories__link row-categories__link_current">Виктор
                        Субботин</a>
                </div>
            </div>

        </div>

    </div>
</header>
<main>
    <div class="content-width content-columns">
        <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
            <div class="uk-position-relative uk-margin-medium">

                <ul uk-tab="" class="uk-tab">
                    <li aria-expanded="true" class="uk-active"><a href="#">Текущие</a></li>
                    <li aria-expanded="false" class=""><a href="#">Завершенные</a></li>
                </ul>

                <ul class="uk-switcher uk-margin">

                    <li class="uk-active">
                        <ul uk-accordion="multiple: true">
                            <?php foreach ($data['appointments']['new'] as $appointment): ?>
                                <li>
                                    <?php echo $appointment->salon_id ?
                                        Html::a($appointment->salon->name, '/site/web/index.php/executor-map/salon-view?id=' . $appointment->salon_id) :
                                        Html::a($appointment->user->profile->name . ' ' . $appointment->user->profile->surname, '/site/web/index.php/executor-map/user-view?id=' . $appointment->user_id); ?>
                                    <?php if ($appointment->status == \common\models\Appointment::STATUS_CONFIRMED): ?>
                                        <span class="uk-label uk-label-success">Подтверждено</span>
                                    <?php else: ?>
                                        <span class="uk-label uk-label-warning">Не подтверждено</span>
                                    <?php endif; ?>
                                    <a class="uk-accordion-title" href="#">
                                        <?php echo $appointment->start_date; ?>
                                    </a>
                                    <div class="uk-accordion-content">
                                        <a id="js-modal-confirm"
                                           class="uk-button uk-button-danger uk-button-small uk-border-rounded uk-float-right"
                                           href="<?= Url::to(['lk/appointment/cancel', 'appointmentId' => $appointment->id]) ?>">
                                            Отменить сеанс
                                        </a>

                                        <table class="uk-table uk-table-hover uk-table-divider">
                                            <thead>
                                            <tr>
                                                <th>Процедура</th>
                                                <th>Длительность</th>
                                                <th>Стоимость</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($appointment->appointmentItems as $appointmentItem): ?>
                                                <tr>
                                                    <td><?php echo $appointmentItem->service_name; ?></td>
                                                    <td><?php echo $appointmentItem->service_duration; ?></td>
                                                    <td><?php echo $appointmentItem->service_price; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                    <li class="">
                        <ul uk-accordion="multiple: true">
                            <?php foreach ($data['appointments']['canceled'] as $appointment): ?>
                                <li>
                                    <?php echo $appointment->salon_id ?
                                        Html::a($appointment->salon->name, '/site/web/index.php/executor-map/salon-view?id=' . $appointment->salon_id) :
                                        Html::a($appointment->user->profile->name . ' ' . $appointment->user->profile->surname, '/site/web/index.php/executor-map/user-view?id=' . $appointment->user_id); ?>

                                    <a class="uk-accordion-title" href="#">
                                        <?php echo $appointment->start_date; ?>
                                    </a>
                                    <div class="uk-accordion-content">
                                        <table class="uk-table uk-table-hover uk-table-divider">
                                            <thead>
                                            <tr>
                                                <th>Процедура</th>
                                                <th>Длительность</th>
                                                <th>Стоимость</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($appointment->appointmentItems as $appointmentItem): ?>
                                                <tr>
                                                    <td><?php echo $appointmentItem->service_name; ?></td>
                                                    <td><?php echo $appointmentItem->service_duration; ?></td>
                                                    <td><?php echo $appointmentItem->service_price; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                        <ul uk-accordion>
                                            <li>

                                                <?php foreach ($appointment->recalls as $recall): ?>

                                                    <?php if ($recall->appointment->client->user->id == Yii::$app->user->identity->id): ?>
                                                        <a class="uk-accordion-title uk-width-1-4" href="#">Посмотреть
                                                            комментарии</a>

                                                        <div class="uk-accordion-content uk-width-1-3">
                                                            <div class="uk-panel uk-margin-small-left">
                                                                <div class="review-slide__content">
                                                                    <div class="review-slide__extra">
                                                                        <div class="vote uk-inline">
                                                                            <div class="review-slide__author-profession">
                                                                                <?php echo Html::encode($recall->create_time); ?>
                                                                            </div>
                                                                            <i class="fas fa-comment-alt-dots vote__icon vote__icon_color_gray"></i>
                                                                            <span class="vote__digits">
                                                                            <?php if (Html::encode($recall->assessment) == \common\models\Recall::ASSESSMENT_DISLIKE): ?>
                                                                                <i class="mdi mdi-heart-broken"></i>
                                                                            <?php else: ?>
                                                                                <i class="mdi mdi-heart"></i>
                                                                            <?php endif; ?>
                                                                        </span>
                                                                        </div>

                                                                        <div class="stars">
                                                                            <div class="fas fa-star stars__star stars__star_active"></div>
                                                                            <div class="fas fa-star stars__star stars__star_active"></div>
                                                                            <div class="fas fa-star stars__star stars__star_active"></div>
                                                                            <div class="fas fa-star stars__star stars__star_active"></div>
                                                                            <div class="fas fa-star stars__star"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="review-slide__text">
                                                                        <?php echo Html::encode($recall->text); ?>
                                                                    </div>
                                                                    <a href="" class="review-slide__more">Читать
                                                                        полностью</a>
                                                                </div>
                                                                <div class="review-slide__author">
                                                                    <div class="review-slide__author-img"
                                                                         style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png);"></div>
                                                                    <div class="review-slide__author-info">
                                                                        <div class="review-slide__author-name">
                                                                            <?php echo Html::encode($recall->appointment->client->user->profile->name); ?>
                                                                            ,
                                                                            <?php echo Html::encode($recall->appointment->client->user->profile->surname); ?>
                                                                        </div>
                                                                        <div class="review-slide__author-profession">
                                                                            <?php echo Html::encode($recall->appointment->client->user->profile->city->name); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                <?php endforeach; ?>


                                                <a class="uk-accordion-title uk-width-1-4" href="#">Оставить
                                                    комментарий</a>
                                                <div class="uk-accordion-content">
                                                    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

                                                    <div class="panel panel-default panel-body">

                                                        <?= $form->errorSummary($data['model']); ?>

                                                        <?= $form->field($data['recall'], 'text')->textarea(['rows' => '3']); ?>

                                                        <?= $form->field($data['recall'], 'assessment')->radio(['label' => 'like']); ?>

                                                        <?= $form->field($data['recall'], 'assessment')->radio(['label' => 'dislike']); ?>

                                                    </div>

                                                    <?php ActiveForm::end(); ?>
                                                </div>


                                            </li>
                                        </ul>
                                    </div>

                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </div>
</main>

<script>
    UIkit.util.on('#js-modal-confirm', 'click', function (e) {
        e.preventDefault();
        e.target.blur();
        UIkit.modal.confirm('Вы уверены, что хотите отменить севнс ?').then(function () {
            var x = new XMLHttpRequest();
            x.open("GET", "cancel?id=", true);
            x.send(null);
        }, function () {
            console.log('Rejected.')
        });
    });
</script>
