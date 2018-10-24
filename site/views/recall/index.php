<?php

use yii\helpers\Html;
use site\models\Recall;
use site\widgets\complaint\Complaint;

$this->setBreadcrumbs(['Отзывы']);
Yii::$app->timeZone = 'Asia/Omsk';
?>

<div class="uk-margin-top font_type_12 uk-margin-bottom">Отзывы:</div>
<div class="uk-grid">
    <?php foreach ($data['recalls'] as $recall): ?>
        <div class="uk-width-1-2" id="recall-<?php echo $recall->id; ?>">
            <div class="uk-panel uk-margin-small-left uk-margin-bottom">
                <div class="review-slide__content recall-list-shadow">
                    <div class="review-slide__extra">
                        <div class="vote uk-inline">
                            <div class="review-slide__author-profession">
                                <?php echo Html::encode(Yii::$app->formatter->asTime($recall->create_time, 'Y.m.d H:i:s')); ?>
                            </div>
                            <i class="fas fa-comment-alt-dots vote__icon vote__icon_color_gray"></i>
                            <span class="vote__digits">
                                <?php if (Html::encode($recall->assessment) == Recall::ASSESSMENT_DISLIKE): ?>
                                    <i class="mdi mdi-heart-broken"></i>
                                <?php elseif (Html::encode($recall->assessment) == Recall::ASSESSMENT_LIKE): ?>
                                    <i class="mdi mdi-heart"></i>
                                <?php endif; ?>
                            </span>
                        </div>

                        <div class="uk-margin-auto-left">
                            <?php if ($recall->status == Recall::STATUS_NOT_VERIFIED) : ?>
                                <i uk-tooltip="title: Непроверенный отзыв; delay: 100"
                                   class="mdi mdi-alert-circle-outline"></i>
                            <?php else : ?>
                                <i uk-tooltip="title: Проверенный отзыв; delay: 100" class="mdi mdi-check"></i>
                            <?php endif; ?>
                        </div>

                        <div class="stars">
                            <div class="fas fa-star stars__star stars__star_active"></div>
                            <div class="fas fa-star stars__star stars__star_active"></div>
                            <div class="fas fa-star stars__star stars__star_active"></div>
                            <div class="fas fa-star stars__star stars__star_active"></div>
                            <div class="fas fa-star stars__star"></div>
                        </div>
                        <button type="button" uk-close onclick="recallDelete(this)"
                                value="<?php echo $recall->id; ?>"></button>
                    </div>

                    <?php if (strlen($recall->text) > 40) : ?>
                        <div class="toggle-animation-queued  review-slide__text uk-text-truncate">
                            <?php echo Html::encode($recall->text); ?>
                        </div>
                        <div class=" toggle-animation-queued review-slide__text" hidden>
                            <?php echo Html::encode($recall->text); ?>
                        </div>

                        <button class="uk-button uk-button-text uk-margin-small-top" type="button"
                                uk-toggle="target: .toggle-animation-queued; animation: uk-animation-fade; queued: true; duration: 0">
                            Читать полностью
                        </button>
                    <?php else : ?>
                        <div class="review-slide__text">
                            <?php echo Html::encode($recall->text); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($recall->answer)) : ?>
                        <div class="uk-inline">

                            <a href="#modal-example" uk-toggle>Показать ответ</a>

                            <div id="modal-example" uk-modal>
                                <div class="uk-modal-dialog uk-modal-body">
                                    <h2 class="uk-modal-title"><?php echo Html::encode(Yii::$app->formatter->asTime($recall->answer->create_time, 'Y.m.d H:i:s')); ?></h2>
                                    <p><?php echo Html::encode($recall->answer->text); ?></p>
                                    <p class="uk-text-right">
                                        <button class="uk-button uk-button-default uk-modal-close" type="button">
                                            Закрыть
                                        </button>

                                        <?php echo Complaint::widget([
                                            'complaint' => $data['complaint'],
                                            'recallId' => $recall->answer->id,
                                        ]); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                <div class="review-slide__author">
                    <div class="review-slide__author-img"
                         style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png);"></div>
                    <div class="review-slide__author-info">
                        <div class="review-slide__author-name">
                            <?php echo $recall->profile->name; ?>,
                            <?php echo $recall->profile->surname; ?>
                        </div>
                        <div class="review-slide__author-profession">
                            <?php echo $recall->profile->city->name; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function recallDelete(recall) {
        var $recall = $(recall);

        if (confirm('Вы уверены что хотите удалить отзыв ?')) {
            $.get(cUrl.create('recall/delete', {
                id: $recall.attr('value')
            }))
                .done(function () {
                    $('#recall-' + $recall.attr('value')).hide();
                })
                .fail(function () {
                    console.log('fail');
                });
        }
    }
</script>
