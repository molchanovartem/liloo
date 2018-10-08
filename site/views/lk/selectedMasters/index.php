<?php

use site\widgets\header\Header;

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
                <div class="row-categories__item">
                    <a href="" class="row-categories__link row-categories__link_current">Виктор Субботин</a>
                </div>
            </div>

        </div>

    </div>
</header>
<main>
    <div class="uk-container">
        <?php foreach ($data['model'] as $selectedMaster): ?>
            <?php if ($selectedMaster->master_id): ?>
                <div class="uk-card uk-card-default uk-card-body uk-margin-top uk-padding-remove-vertical">

                    <div class="performers-select__item">
                        <div class="performers-select__performer">
                            <div class="performer">
                                <div class="performer__img"
                                     style="background-image: url(&quot;https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png&quot;);"></div>
                                <div class="performer__info">
                                    <div class="label-status label-status_bg_black label-status_fz_14">Profi
                                    </div>
                                    <a href="./salon-view?id=27" data-ajax-content="true" class="uk-link-reset">
                                        <div class="performer__name">
                                            <?php echo $selectedMaster->user->profile->name; ?>
                                            <?php echo $selectedMaster->user->profile->surname; ?>
                                        </div>
                                    </a>
                                    <div class="performer__profession"><?php $selectedMaster->user->profile->description; ?></div>
                                    <div class="performer__profession"><?php $selectedMaster->user->profile->address; ?></div>
                                    <div class="performer__extra">
                                        <div class="stars">
                                            <div class="fas fa-star stars__star stars__star_active"></div>
                                            <div class="fas fa-star stars__star stars__star_active"></div>
                                            <div class="fas fa-star stars__star stars__star_active"></div>
                                            <div class="fas fa-star stars__star stars__star_active"></div>
                                            <div class="fas fa-star stars__star stars__star_active"></div>
                                        </div>
                                        <div class="vote"><i
                                                    class="fas fa-comment-alt-dots vote__icon vote__icon_color_gray"></i>
                                            <span class="vote__digits"><span
                                                        class="vote__digit vote__digit_color_green">+<?php $selectedMaster->user->account->assessment_like; ?></span> <span
                                                        class="vote__digit vote__digit_color_red">-<?php $selectedMaster->user->account->assessment_dislike; ?></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bill uk-margin-small-top">
                                <?php foreach ($selectedMaster->user->specializations as $specialization): ?>
                                    <div>
                                        <div class="bill__row">
                                            <div class="bill__name"><?php echo $specialization->name; ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                </div>
            <?php else: ?>

            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</main>
