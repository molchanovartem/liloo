<?php

use common\models\Appointment;
use site\widgets\header\Header;
use yii\helpers\Html;

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
                </div>

                <div class="performer mt-40">
                    <div class="performer__img performer__img_upload"></div>
                    <div class="performer__info">
                        <div class="label-status label-status_bg_gray label-status_fz_14">Обычный</div>
                        <div class="performer__name">
                            <?php echo Html::encode($data['model']->profile->name); ?><?php echo Html::encode($data['model']->profile->surname); ?>
                        </div>
                    </div>
                </div>

                <div class="font_type_3 mt-25">
                    <?php echo Html::encode($data['model']->profile->description); ?>
                </div>
                <div class="font_type_3 mt-25">
                    <?php echo Html::encode($data['model']->profile->city->name); ?>
                </div>

                <div class="font_type_3 mt-25">
                    <?php echo Html::encode($data['model']->profile->country->name); ?>
                </div>

                <div class="font_type_3 mt-25">
                    <?php echo Html::encode($data['model']->profile->date_birth); ?>
                </div>

                <div class="font_type_3 mt-25">
                    <?php echo Html::encode($data['model']->profile->phone); ?>
                </div>

            </div>

            <div class="uk-card uk-card-default uk-card-body uk-width-1-1 uk-margin-top">
                <div class="uk-position-relative uk-margin-medium">

                    <ul uk-tab="" class="uk-tab">
                        <li aria-expanded="true" class="uk-active"><a href="#">Новые</a></li>
                        <li aria-expanded="false" class=""><a href="#">Не подтвержденные</a></li>
                        <li aria-expanded="false" class=""><a href="#">Подтвержденные</a></li>
                        <li aria-expanded="false" class=""><a href="#">Закрытые</a></li>
                    </ul>

                    <ul class="uk-switcher uk-margin">

                        <li class="uk-active">
                            <ul uk-accordion="multiple: true">
                                <?php foreach ($data['appointments']['new'] as $appointment): ?>
                                    <li>
                                        <?php echo $appointment->salon_id ?
                                            Html::a($appointment->salon->name , '/site/web/index.php/executor-map/salon-view?id=' . $appointment->salon_id) :
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
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>

                        <li class="">
                            <ul uk-accordion="multiple: true">
                                <?php foreach ($data['appointments']['notConfirmed'] as $appointment): ?>
                                    <li>
                                        <?php echo $appointment->salon_id ?
                                            Html::a($appointment->salon->name , '/site/web/index.php/executor-map/salon-view?id=' . $appointment->salon_id) :
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
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>

                        <li class="">
                            <ul uk-accordion="multiple: true">
                                <?php foreach ($data['appointments']['confirmed'] as $appointment): ?>
                                    <li>
                                        <a class="uk-accordion-title" href="#">
                                            <?php echo $appointment->start_date; ?>
                                        </a>
                                        <div class="uk-accordion-content">
                                            <?php foreach ($appointment->appointmentItems as $appointmentItem): ?>
                                                <p><?php echo $appointmentItem->service_name; ?></p>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>

                        <li class="">
                            <ul uk-accordion="multiple: true">
                                <?php foreach ($data['appointments']['canceled'] as $appointment): ?>
                                    <li>
                                        <a class="uk-accordion-title" href="#">
                                            <?php echo $appointment->start_date; ?>
                                        </a>
                                        <div class="uk-accordion-content">
                                            <?php foreach ($appointment->appointmentItems as $appointmentItem): ?>
                                                <p><?php echo $appointmentItem->service_name; ?></p>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>

                    </ul>

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
