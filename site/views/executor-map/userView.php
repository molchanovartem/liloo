<?php

use site\widgets\header\Header;
use yii\helpers\Html;

$this->setBreadcrumbs([
    ['label' => 'Исполнители', 'url' => ['index']],
    $data['model']->profile->name . ' ' . $data['model']->profile->surname,
]);
?>
<header class="header bg_color_e4eff9 pb-300">
    <div class="header__container">

        <?php echo Header::widget(); ?>

        <div class="content-width">
            <?php echo $this->getBreadcrumbs(); ?>
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
                            <?php echo Html::encode($data['model']->profile->city->name); ?>,
                            <?php echo Html::encode($data['model']->profile->address); ?>
                        </span>
                    </a>
                </div>

                <div class="performer mt-40">
                    <div class="performer__img performer__img_upload"></div>
                    <div class="performer__info">
                        <div class="label-status label-status_bg_gray label-status_fz_14">Обычный</div>
                        <div class="performer__name">
                            <?php echo Html::encode($data['model']->profile->name); ?> <?php echo Html::encode($data['model']->profile->surname); ?>
                        </div>
                        <div class="performer__profession">
                            <?php foreach ($data['specialization'] as $specialization): ?>
                                <?php echo Html::encode($specialization['name']); ?>
                            <?php endforeach; ?>
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
                            <?php echo Html::encode($data['model']->account->assessment_like); ?>
                        </span>

                        <span class="vote__digit vote__digit_color_red">
                            <?php echo Html::encode($data['model']->account->assessment_dislike); ?>
                        </span>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="font_type_3 mt-25">
                    <?php echo Html::encode($data['model']->profile->description); ?>
                </div>

            </div>

            <div class="j-c_s-b a-i_c mt-40">
                <div class="font_type_14">Услуги:</div>
            </div>

            <?php foreach ($data['specialization'] as $specialization): ?>
                <div class="font_type_12 mtb-25"><?php echo Html::encode($specialization['name']) ?></div>
                <?php foreach ($specialization['service'] as $service): ?>
                    <div class="workers-list">
                        <div class="workers-list__item">
                            <div class="workers-list__part">
                                <div class="workers-list__detail"><?php echo Html::encode($service['name']); ?></div>
                            </div>
                            <div class="workers-list__part">
                                <span class="workers-list__detail"><?php echo Html::encode($service['duration']); ?>
                                    мин.</span>
                            </div>
                            <div class="workers-list__part">
                                <span class="workers-list__detail">от <?php echo Html::encode($service['price']); ?>
                                    руб.</span>
                            </div>
                            <div class="workers-list__part">
                                <span class="workers-list__action workers-list__action_type_add uk-icon=" heart"></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>

            <div class="font_type_12 mt-90 mb-25">Контакты:</div>
            <div class="halfs between-60">
                <div class="halfs__half">
                    <div class="advices">
                        <div class="advice">
                            <div class="advice__block">
                            <span class="advice__icon">
                                <span class="fas fa-phone fa-flip-horizontal"></span>
                            </span>
                                <div class="advice__text">Связаться с мастером по телефону Вы сможете после того, как
                                    запишитесь к нему на сеанс.
                                </div>
                            </div>
                        </div>
                        <div class="advice">
                            <div class="advice__block">
                                <span class="advice__icon">
                                    <span class="fas fa-map-marker-alt"></span>
                                </span>
                                <br>
                                <div class="advice__text">
                                    Адрес: <?php echo Html::encode($data['model']->profile->address); ?>
                                </div>
                            </div>
                        </div>
                        <div class="advice">
                            <div class="advice__block">
                            <span class="advice__icon">
                                <span class="far fa-clock"></span>
                            </span>
                                <div class="advice__text">Режим работы:</div>
                            </div>
                            <div class="bill mt-15">
                                <div class="bill__row">
                                    <div class="bill__name">Понедельник</div>
                                    <div class="bill__cost">11:00 − 21:00</div>
                                </div>
                                <div class="bill__row">
                                    <div class="bill__name">Вторник</div>
                                    <div class="bill__cost">11:00 − 21:00</div>
                                </div>
                                <div class="bill__row">
                                    <div class="bill__name">Среда</div>
                                    <div class="bill__cost">11:00 − 21:00</div>
                                </div>
                                <div class="bill__row">
                                    <div class="bill__name">Четверг</div>
                                    <div class="bill__cost">11:00 − 21:00</div>
                                </div>
                                <div class="bill__row">
                                    <div class="bill__name">Пятница</div>
                                    <div class="bill__cost">11:00 − 21:00</div>
                                </div>
                                <div class="bill__row">
                                    <div class="bill__name">Суббота</div>
                                    <div class="bill__cost">11:00 − 21:00</div>
                                </div>
                                <div class="bill__row">
                                    <div class="bill__name">Воскресенье</div>
                                    <div class="bill__cost">11:00 − 21:00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="halfs__half map map_in_half" id="map"></div>
            </div>


            <div class="uk-position-relative uk-visible-toggle" style="max-width: 760px;" uk-slider>
                <div class="mt-90 mb-25 j-c_s-b a-i_c">
                    <div class="font_type_12">Отзывы:</div>

                    <div class="a-i_c">
                        <span class="vote__digits">
                            <span class="vote__digit vote__digit_color_green">
                                +<?php echo Html::encode($data['model']->account->assessment_like); ?>
                            </span>
                            <span class="vote__digit vote__digit_color_red">
                                -<?php echo Html::encode($data['model']->account->assessment_dislike); ?>
                            </span>
                        </span>

                        <div class="uk-clearfix ">
                            <div class="uk-float-right">
                                <a class="uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                                <a class="uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
                            </div>
                        </div>

                    </div>
                </div>

                <ul class="uk-slider-items uk-child-width-1-2">
                    <?php foreach ($data['model']->recalls as $recall): ?>
                        <li>
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
                                            <button class="uk-button uk-button-text uk-margin-small-top" type="button">
                                                Показать ответ
                                            </button>
                                            <div uk-dropdown="mode: click">
                                                <b><?php echo Html::encode($recall->answer->create_time); ?></b>
                                                <?php echo Html::encode($recall->answer->text); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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

                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>

        <div class="content-columns__column content-column__column_side">

            <div class="content-block p-40 content-block_shadow uk-background-default">
                <div class="t-a_c font_type_2">Выберите услуги, нажав на кнопку +</div>
                <div class="bill mt-40">
                    <div class="bill__row">
                        <div class="bill__name">Мужская стрижка</div>
                        <div class="bill__cost">от 500 руб.</div>
                    </div>
                    <div class="bill__row">
                        <div class="bill__name">Биоревитализация с применением биоматрецы</div>
                        <div class="bill__cost">от 4500 руб.</div>
                    </div>
                    <div class="bill__row">
                        <div class="bill__name">Окрашивание краской клиента</div>
                        <div class="bill__cost">от 3000 руб.</div>
                    </div>
                </div>
                <div class="t-a_c">
                    <div class="button button_color_red button_width_270 mt-40">Выбрать время</div>
                </div>
            </div>

            <div class="content-block p-40 content-block_shadow">
                <div class="t-a_c font_type_2">Выберите услуги, нажав на кнопку +</div>
                <div class="t-a_c">
                    <div class="button button_color_red button_width_270 button_color_red_disabled mt-40">Записаться
                    </div>
                </div>
            </div>

        </div>

    </div>
</main>
