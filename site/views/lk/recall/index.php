<?php use yii\helpers\Html; ?>
<div class="font_type_12 uk-margin-bottom">Отзывы:</div>
<div class="uk-grid">
<?php foreach ($data['recalls'] as $recall): ?>
    <div class="uk-width-1-2">
        <div class="uk-panel uk-margin-small-left uk-margin-bottom">
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
                <a href="" class="review-slide__more">Читать полностью</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
