<?php

use yii\helpers\Html;

$this->setBreadcrumbs(['Избранные мастера']);
$this->setHeading('Избранные мастера');
?>

<?php if (empty($data['model'])) : ?>
    <div class="uk-card uk-card-default uk-card-hover uk-card-body uk-margin-top uk-border-rounded">
        <h3 class="uk-text-center">Вы еще никого не добавили.</h3>
        <h3 class="uk-margin-remove uk-text-center"> Сделать это вы можете в профиле мастера.</h3>
        <div class="uk-text-center">
            <?php echo Html::a("<button class='button button_color_red button_in_header uk-margin-top uk-margin-bottom'>Подобрать мастера</button>", ['/executor-map']); ?>
        </div>

        <img src="/site/web/public/dist/images/selectedMaster.gif" alt="">
    </div>
<?php endif; ?>

<?php foreach ($data['model'] as $selectedMaster): ?>
    <?php if (!$selectedMaster->is_salon): ?>
        <div class="uk-card uk-card-default uk-card-body uk-margin-top uk-margin-bottom uk-padding-remove-vertical uk-border-rounded">

            <div class="performers-select__item">
                <div class="performers-select__performer">
                    <div class="performer">
                        <div class="performer__img"
                             style="background-image: url(&quot;https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png&quot;);"></div>
                        <div class="performer__info">
                            <a href="executor-map/user-view?id=<?php echo Html::encode($selectedMaster->executor_id); ?>"
                               data-ajax-content="true" class="uk-link-reset">
                                <div class="performer__name">
                                    <?php echo Html::encode($selectedMaster->user->profile->name); ?>
                                    <?php echo Html::encode($selectedMaster->user->profile->surname); ?>
                                    <a href="/site/web/selected-masters/add-to-selected?executorId=<?php echo Html::encode($selectedMaster->executor_id); ?>&isSalon=0">
                                        <i class="mdi mdi-star uk-text-warning" uk-tooltip="Убрать из избранного"></i>
                                    </a>
                                </div>

                            </a>
                            <div class="performer__profession">
                                <?php echo Html::encode($selectedMaster->user->profile->description); ?>
                            </div>
                            <div class="performer__profession">
                                <?php echo Html::encode($selectedMaster->user->profile->address); ?>
                            </div>
                            <div class="performer__extra">
                                <div class="stars">
                                    <div class="fas fa-star stars__star stars__star_active"></div>
                                    <div class="fas fa-star stars__star stars__star_active"></div>
                                    <div class="fas fa-star stars__star stars__star_active"></div>
                                    <div class="fas fa-star stars__star stars__star_active"></div>
                                    <div class="fas fa-star stars__star stars__star_active"></div>
                                </div>
                                <div class="vote">
                                    <i class="fas fa-comment-alt-dots vote__icon vote__icon_color_gray"></i>
                                    <span class="vote__digits">
                                        <span class="vote__digit vote__digit_color_green">
                                            +<?php echo Html::encode($selectedMaster->user->account->assessment_like); ?>
                                        </span>
                                        <span class="vote__digit vote__digit_color_red">
                                            -<?php echo Html::encode($selectedMaster->user->account->assessment_dislike); ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bill uk-margin-small-top">
                        <?php foreach ($selectedMaster->user->specializations as $specialization): ?>
                            <div>
                                <div class="bill__row">
                                    <div class="bill__name">
                                        <?php echo Html::encode($specialization->name); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="button button_color_red button_width_270 mt-10">
                    <button class="uk-button uk-link-reset"
                            onclick="modalAppointmentCreate({userId:<?php echo $selectedMaster->executor_id; ?>})">
                        Записаться
                    </button>
                </div>
            </div>

        </div>
    <?php else: ?>
        <div class="uk-card uk-card-default uk-card-body uk-margin-bottom uk-padding-remove-vertical">

            <div class="performers-select__item">
                <div class="performers-select__performer">
                    <div class="performer">
                        <div class="performer__img"
                             style="background-image: url(&quot;https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png&quot;);"></div>
                        <div class="performer__info">
                            <a href="executor-map/salon-view?id=<?php echo Html::encode($selectedMaster->executor_id); ?>"
                               data-ajax-content="true" class="uk-link-reset">
                                <div class="performer__name">
                                    <?php echo Html::encode($selectedMaster->salon->name); ?>
                                </div>
                            </a>
                            <div class="performer__profession">
                                <?php echo Html::encode($selectedMaster->salon->description); ?>
                            </div>
                            <div class="performer__profession">
                                <?php echo Html::encode($selectedMaster->salon->address); ?>
                            </div>
                            <div class="performer__extra">
                                <div class="stars">
                                    <div class="fas fa-star stars__star stars__star_active"></div>
                                    <div class="fas fa-star stars__star stars__star_active"></div>
                                    <div class="fas fa-star stars__star stars__star_active"></div>
                                    <div class="fas fa-star stars__star stars__star_active"></div>
                                    <div class="fas fa-star stars__star stars__star_active"></div>
                                </div>
                                <div class="vote">
                                    <i class="fas fa-comment-alt-dots vote__icon vote__icon_color_gray"></i>
                                    <span class="vote__digits">
                                        <span class="vote__digit vote__digit_color_green">
                                            +<?php echo Html::encode($selectedMaster->salon->account->assessment_like); ?>
                                        </span>
                                        <span class="vote__digit vote__digit_color_red">
                                            -<?php echo Html::encode($selectedMaster->salon->account->assessment_dislike); ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bill uk-margin-small-top">
                        <?php foreach ($selectedMaster->salon->specializations as $specialization): ?>
                            <div>
                                <div class="bill__row">
                                    <div class="bill__name"><?php echo Html::encode($specialization->name); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="button button_color_red button_width_270 mt-10">
                    <button class="uk-button uk-link-reset"
                            onclick="modalAppointmentCreate({salonId:<?php echo $selectedMaster->executor_id; ?>})">
                        Записаться
                    </button>
                </div>
            </div>

        </div>
    <?php endif; ?>
<?php endforeach; ?>
