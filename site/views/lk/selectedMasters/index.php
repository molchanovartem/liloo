<?php

use yii\helpers\Html;

$this->setBreadcrumbs(['Избранные мастера']);
?>
        <?php foreach ($data['model'] as $selectedMaster): ?>
            <?php if (!$selectedMaster->is_salon): ?>
                <div class="uk-card uk-card-default uk-card-body uk-margin-bottom uk-padding-remove-vertical">

                    <div class="performers-select__item">
                        <div class="performers-select__performer">
                            <div class="performer">
                                <div class="performer__img"
                                     style="background-image: url(&quot;https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png&quot;);"></div>
                                <div class="performer__info">
                                    <div class="label-status label-status_bg_black label-status_fz_14">Profi
                                    </div>
                                    <a href="executor-map/user-view?id=<?php echo Html::encode($selectedMaster->executor_id); ?>"
                                       data-ajax-content="true" class="uk-link-reset">
                                        <div class="performer__name">
                                            <?php echo Html::encode($selectedMaster->user->profile->name); ?>
                                            <?php echo Html::encode($selectedMaster->user->profile->surname); ?>
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
                            <a href="../appointment/create" class="uk-button uk-link-reset"
                               data-window="true"
                               data-window-type="bigModal">Записаться</a>
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
                                    <div class="label-status label-status_bg_black label-status_fz_14">Profi
                                    </div>
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
                            <a href="../appointment/create" class="uk-button uk-link-reset"
                               data-window="true"
                               data-window-type="bigModal">Записаться</a>
                        </div>
                    </div>

                </div>
            <?php endif; ?>
        <?php endforeach; ?>
