<?php

use site\widgets\header\Header;

?>
<header class="header bg_color_e4eff9 pb-300">
    <div class="header__container">

        <?php echo Header::widget(); ?>

        <div class="content-width">

            <div class="row-categories">
                <div class="row-categories__item"><a href="" class="row-categories__link">Главная</a></div>
                <div class="row-categories__item"><a href="" class="row-categories__link">Мастера</a></div>
                <div class="row-categories__item"><a href="" class="row-categories__link">Фотограф</a></div>
                <div class="row-categories__item"><a href="" class="row-categories__link">Москва</a></div>
                <div class="row-categories__item"><a href="" class="row-categories__link row-categories__link_current">Виктор
                        Субботин</a></div>
            </div>

        </div>

    </div>
</header>
<main class="mt--300">
    <div class="content-width content-columns mt-40">

        <div class="content-columns__column content-column__column_main">

            <div class="uk-position-relative uk-visible-toggle uk-light" uk-slider>

                <ul class="uk-slider-items uk-child-width-1-3">
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

            <div class="content-block p-40 content-block_shadow uk-background-default">

                <div class="j-c_s-b">
                    <div class="content-block__title">Информация обо мне</div>
                    <a href="" class="choose-city">
                        <span class="choose-city__fa fas fa-map-marker-alt"></span>
                        <span class="choose-city__text">
<!--                            --><?php //echo Html::encode($data['model']->profile->city->name); ?><!--,-->
<!--                            --><?php //echo Html::encode($data['model']->profile->address); ?>
                        </span>
                    </a>
                </div>

                <div class="performer mt-40">
                    <div class="performer__img performer__img_upload"></div>
                    <div class="performer__info">
                        <div class="label-status label-status_bg_gray label-status_fz_14">Обычный</div>
                        <div class="performer__name">
<!--                            --><?php //echo Html::encode($data['model']->profile->name); ?><!----><?php //echo Html::encode($data['model']->profile->surname); ?>
                        </div>
                        <div class="performer__profession">
<!--                            --><?php //foreach ($data['specialization'] as $specialization): ?>
<!--                                --><?php //echo Html::encode($specialization['name']); ?>
<!--                            --><?php //endforeach; ?>
                        </div>
                        <div class="performer__extra">
                            <div class="stars">
                                <div class="fas fa-star stars__star"></div>
                                <div class="fas fa-star stars__star"></div>
                                <div class="fas fa-star stars__star"></div>
                                <div class="fas fa-star stars__star"></div>
                                <div class="fas fa-star stars__star"></div>
                            </div>
                            <div class="vote">
                                <i class="fas fa-comment-alt-dots vote__icon vote__icon_color_gray"></i>
                                <span class="vote__digits">
                        <span class="vote__digit vote__digit_color_green">
<!--                            --><?php //echo Html::encode($data['model']->account->assessment_like); ?>
                        </span>

                        <span class="vote__digit vote__digit_color_red">
<!--                            --><?php //echo Html::encode($data['model']->account->assessment_dislike); ?>
                        </span>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="font_type_3 mt-25">
<!--                    --><?php //echo Html::encode($data['model']->profile->description); ?>
                </div>

            </div>

            <div class="uk-position-relative uk-visible-toggle" style="max-width: 760px;" uk-slider>
                <div class="mt-90 mb-25 j-c_s-b a-i_c">
                    <div class="font_type_12">Мои отзывы:</div>

                    <div class="a-i_c">

<!--                        <span class="vote__digits">-->
<!--                            <span class="vote__digit vote__digit_color_green">-->
<!--                                +--><?php //echo Html::encode($data['model']->account->assessment_like); ?>
<!--                            </span>-->
<!--                            <span class="vote__digit vote__digit_color_red">-->
<!--                                ---><?php //echo Html::encode($data['model']->account->assessment_dislike); ?>
<!--                            </span>-->
<!--                        </span>-->

                    </div>
                </div>

            </div>
        </div>



    </div>
</main>
