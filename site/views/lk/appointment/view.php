<?php

use admin\widgets\activeForm\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<!--<div class="content-columns">-->
<!--    <div class="uk-card uk-card-default uk-card-body uk-width-1-1">-->
<!--        <div class="uk-position-relative uk-margin-medium">-->
<!---->
<!--            <ul uk-tab="" class="uk-tab">-->
<!--                <li aria-expanded="true" class="uk-active"><a href="#">Текущие</a></li>-->
<!--                <li aria-expanded="false" class=""><a href="#">Завершенные</a></li>-->
<!--            </ul>-->
<!---->
<!--            <ul class="uk-switcher uk-margin">-->
<!---->
<!--                <li class="uk-active">-->
<!--                    <ul uk-accordion="multiple: true">-->
<!--                        --><?php //foreach ($data['appointments']['new'] as $appointment): ?>
<!--                            <li>-->
<!--                                --><?php //echo $appointment->salon_id ?
//                                    Html::a($appointment->salon->name, '/site/web/index.php/executor-map/salon-view?id=' . $appointment->salon_id) :
//                                    Html::a($appointment->user->profile->name . ' ' . $appointment->user->profile->surname, '/site/web/index.php/executor-map/user-view?id=' . $appointment->user_id); ?>
<!--                                --><?php //if ($appointment->status == \common\models\Appointment::STATUS_CONFIRMED): ?>
<!--                                    <span class="uk-label uk-label-success">Подтверждено</span>-->
<!--                                --><?php //else: ?>
<!--                                    <span class="uk-label uk-label-warning">Не подтверждено</span>-->
<!--                                --><?php //endif; ?>
<!--                                <a class="uk-accordion-title" href="#">-->
<!--                                    --><?php //echo $appointment->start_date; ?>
<!--                                </a>-->
<!--                                <div class="uk-accordion-content">-->
<!--                                    <a id="js-modal-confirm"-->
<!--                                       class="uk-button uk-button-danger uk-button-small uk-border-rounded uk-float-right"-->
<!--                                       href="--><? //= Url::to(['lk/appointment/cancel', 'appointmentId' => $appointment->id]) ?><!--">-->
<!--                                        Отменить сеанс-->
<!--                                    </a>-->
<!---->
<!--                                    <table class="uk-table uk-table-hover uk-table-divider">-->
<!--                                        <thead>-->
<!--                                        <tr>-->
<!--                                            <th>Процедура</th>-->
<!--                                            <th>Длительность</th>-->
<!--                                            <th>Стоимость</th>-->
<!--                                        </tr>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        --><?php //foreach ($appointment->appointmentItems as $appointmentItem): ?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $appointmentItem->service_name; ?><!--</td>-->
<!--                                                <td>--><?php //echo $appointmentItem->service_duration; ?><!--</td>-->
<!--                                                <td>--><?php //echo $appointmentItem->service_price; ?><!--</td>-->
<!--                                            </tr>-->
<!--                                        --><?php //endforeach; ?>
<!--                                        </tbody>-->
<!--                                    </table>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                        --><?php //endforeach; ?>
<!--                    </ul>-->
<!--                </li>-->
<!---->
<!--                <li class="">-->
<!--                    <ul uk-accordion="multiple: true">-->
<!--                        --><?php //foreach ($data['appointments']['canceled'] as $appointment): ?>
<!--                            <li>-->
<!--                                --><?php //echo $appointment->salon_id ?
//                                    Html::a($appointment->salon->name, '/site/web/index.php/executor-map/salon-view?id=' . $appointment->salon_id) :
//                                    Html::a($appointment->user->profile->name . ' ' . $appointment->user->profile->surname, '/site/web/index.php/executor-map/user-view?id=' . $appointment->user_id); ?>
<!---->
<!--                                <a class="uk-accordion-title" href="#">-->
<!--                                    --><?php //echo $appointment->start_date; ?>
<!--                                </a>-->
<!--                                <div class="uk-accordion-content">-->
<!--                                    <table class="uk-table uk-table-hover uk-table-divider">-->
<!--                                        <thead>-->
<!--                                        <tr>-->
<!--                                            <th>Процедура</th>-->
<!--                                            <th>Длительность</th>-->
<!--                                            <th>Стоимость</th>-->
<!--                                        </tr>-->
<!--                                        </thead>-->
<!--                                        <tbody>-->
<!--                                        --><?php //foreach ($appointment->appointmentItems as $appointmentItem): ?>
<!--                                            <tr>-->
<!--                                                <td>--><?php //echo $appointmentItem->service_name; ?><!--</td>-->
<!--                                                <td>--><?php //echo $appointmentItem->service_duration; ?><!--</td>-->
<!--                                                <td>--><?php //echo $appointmentItem->service_price; ?><!--</td>-->
<!--                                            </tr>-->
<!--                                        --><?php //endforeach; ?>
<!--                                        </tbody>-->
<!--                                    </table>-->
<!---->
<!--                                    <ul uk-accordion>-->
<!--                                        <li>-->
<!---->
<!--                                            --><?php //foreach ($appointment->recalls as $recall): ?>
<!---->
<!--                                                --><?php //if ($recall->appointment->client->user->id == Yii::$app->user->identity->id): ?>
<!--                                                    <a class="uk-accordion-title uk-width-1-4" href="#">Посмотреть-->
<!--                                                        комментарии</a>-->
<!---->
<!--                                                    <div class="uk-accordion-content uk-width-1-3">-->
<!--                                                        <div class="uk-panel uk-margin-small-left">-->
<!--                                                            <div class="review-slide__content">-->
<!--                                                                <div class="review-slide__extra">-->
<!--                                                                    <div class="vote uk-inline">-->
<!--                                                                        <div class="review-slide__author-profession">-->
<!--                                                                            --><?php //echo Html::encode($recall->create_time); ?>
<!--                                                                        </div>-->
<!--                                                                        <i class="fas fa-comment-alt-dots vote__icon vote__icon_color_gray"></i>-->
<!--                                                                        <span class="vote__digits">-->
<!--                                                                            --><?php //if (Html::encode($recall->assessment) == \common\models\Recall::ASSESSMENT_DISLIKE): ?>
<!--                                                                                <i class="mdi mdi-heart-broken"></i>-->
<!--                                                                            --><?php //else: ?>
<!--                                                                                <i class="mdi mdi-heart"></i>-->
<!--                                                                            --><?php //endif; ?>
<!--                                                                        </span>-->
<!--                                                                    </div>-->
<!---->
<!--                                                                    <div class="stars">-->
<!--                                                                        <div class="fas fa-star stars__star stars__star_active"></div>-->
<!--                                                                        <div class="fas fa-star stars__star stars__star_active"></div>-->
<!--                                                                        <div class="fas fa-star stars__star stars__star_active"></div>-->
<!--                                                                        <div class="fas fa-star stars__star stars__star_active"></div>-->
<!--                                                                        <div class="fas fa-star stars__star"></div>-->
<!--                                                                    </div>-->
<!--                                                                </div>-->
<!--                                                                <div class="review-slide__text">-->
<!--                                                                    --><?php //echo Html::encode($recall->text); ?>
<!--                                                                </div>-->
<!--                                                                <a href="" class="review-slide__more">Читать-->
<!--                                                                    полностью</a>-->
<!--                                                            </div>-->
<!--                                                            <div class="review-slide__author">-->
<!--                                                                <div class="review-slide__author-img"-->
<!--                                                                     style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png);"></div>-->
<!--                                                                <div class="review-slide__author-info">-->
<!--                                                                    <div class="review-slide__author-name">-->
<!--                                                                        --><?php //echo Html::encode($recall->appointment->client->user->profile->name); ?>
<!--                                                                        ,-->
<!--                                                                        --><?php //echo Html::encode($recall->appointment->client->user->profile->surname); ?>
<!--                                                                    </div>-->
<!--                                                                    <div class="review-slide__author-profession">-->
<!--                                                                        --><?php //echo Html::encode($recall->appointment->client->user->profile->city->name); ?>
<!--                                                                    </div>-->
<!--                                                                </div>-->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                --><?php //endif; ?>
<!---->
<!--                                            --><?php //endforeach; ?>
<!---->
<!--                                            <a class="uk-accordion-title uk-width-1-4" href="#">Оставить комментарий</a>-->
<!--                                            <div class="uk-accordion-content">-->
<!--                                                --><?php //$form = ActiveForm::begin(['enableClientValidation' => false]); ?>
<!---->
<!--                                                <div class="panel panel-default panel-body">-->
<!---->
<!--                                                    --><? //= $form->errorSummary($data['model']); ?>
<!---->
<!--                                                    --><? //= $form->field($data['recall'], 'text')->textarea(['rows' => '3']); ?>
<!---->
<!--                                                    --><? //= $form->field($data['recall'], 'assessment')->radio(['label' => 'like']); ?>
<!---->
<!--                                                    --><? //= $form->field($data['recall'], 'assessment')->radio(['label' => 'dislike']); ?>
<!---->
<!--                                                </div>-->
<!---->
<!--                                                --><?php //ActiveForm::end(); ?>
<!--                                            </div>-->
<!---->
<!---->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!---->
<!--                            </li>-->
<!--                        --><?php //endforeach; ?>
<!--                    </ul>-->
<!--                </li>-->
<!---->
<!--            </ul>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<script>-->
<!--    UIkit.util.on('#js-modal-confirm', 'click', function (e) {-->
<!--        e.preventDefault();-->
<!--        e.target.blur();-->
<!--        UIkit.modal.confirm('Вы уверены, что хотите отменить севнс ?').then(function () {-->
<!--            var x = new XMLHttpRequest();-->
<!--            x.open("GET", "cancel?id=", true);-->
<!--            x.send(null);-->
<!--        }, function () {-->
<!--            console.log('Rejected.')-->
<!--        });-->
<!--    });-->
<!--</script>-->
<?php //var_dump(json_encode($data['appointments']['new'])); die; ?>

<div id="app">
    <v-app id="inspire">
        <div>
            <v-toolbar tabs>
                <v-tabs
                    slot="extension"
                    v-model="tabs"
                    fixed-tabs
                    color="transparent"
                >
                    <v-tabs-slider></v-tabs-slider>
                    <v-tab href="#mobile-tabs-5-1">
                        <p>Открытые</p>
                    </v-tab>

                    <v-tab href="#mobile-tabs-5-2">
                        <p>Завершенные</p>
                    </v-tab>
                </v-tabs>
            </v-toolbar>

            <v-tabs-items v-model="tabs" class="white elevation-1">

                <v-tab-item id='mobile-tabs-5-1'>
                    <v-card>
                        <v-card-text>

                            <v-data-iterator
                                :items="appointmentsNew"
                                row
                                wrap
                                prev-icon="mdi-chevron-left"
                                next-icon="mdi-chevron-right"
                            >
                                <div
                                    slot="item"
                                    slot-scope="props"
                                >

                                    <div>

                                        <a :href="'/site/web/index.php/executor-map/user-view?id=' + props.item.user_id">
                                            {{props.item.userProfile.name + ' ' + props.item.userProfile.surname}}
                                        </a>

                                        <span v-if="props.item.status === 0" class="uk-label uk-label-warning">Не подтверждено</span>
                                        <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                        <p @click="open = !open">{{ props.item.start_date }}</p>

                                        <div v-show="open">
                                            <v-btn color="error">Отменить сеанс</v-btn>
                                            <v-data-table
                                                :headers="headers"
                                                :items="props.item.appointmentItems"
                                                hide-actions
                                                class="elevation-1"

                                                sort-icon="mdi-chevron-down"
                                            >
                                                <template slot="items" slot-scope="pro">
                                                    <td>{{ pro.item.service_name }}</td>
                                                    <td>{{ pro.item.service_duration }}</td>
                                                    <td>{{ pro.item.service_price }}</td>
                                                </template>
                                            </v-data-table>
                                        </div>

                                    </div>
                                    <hr>

                                </div>
                            </v-data-iterator>

                        </v-card-text>
                    </v-card>
                </v-tab-item>

                <v-tab-item id='mobile-tabs-5-2'>
                    <v-card>
                        <v-card-text>

                            <v-data-iterator
                                    :items="appointmentsCanceled"
                                    row
                                    wrap
                            >
                                <div
                                        slot="item"
                                        slot-scope="props"
                                >

                                    <div>

                                        <a :href="'/site/web/index.php/executor-map/user-view?id=' + props.item.user_id">
                                            {{props.item.userProfile.name + ' ' + props.item.userProfile.surname}}
                                        </a>

                                        <span v-if="props.item.status === 0" class="uk-label uk-label-warning">Не подтверждено</span>
                                        <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                        <p @click="open = !open">{{ props.item.start_date }}</p>

                                        <div v-show="open">
                                            <v-btn color="error">Отменить сеанс</v-btn>
                                            <v-data-table
                                                    :headers="headers"
                                                    :items="props.item.appointmentItems"
                                                    hide-actions
                                                    class="elevation-1"
                                            >
                                                <template slot="items" slot-scope="pro">
                                                    <td>{{ pro.item.service_name }}</td>
                                                    <td>{{ pro.item.service_duration }}</td>
                                                    <td>{{ pro.item.service_price }}</td>
                                                </template>
                                            </v-data-table>
                                        </div>

                                    </div>
                                    <hr>

                                </div>
                            </v-data-iterator>

                        </v-card-text>
                    </v-card>
                </v-tab-item>

            </v-tabs-items>
        </div>

    </v-app>
</div>

<script>
    new Vue({
            el: '#app',
            data() {
                return {
                    open: false,
                    headers: [
                        {text: 'Процедура', value: 'service_name'},
                        {text: 'Длительность', value: 'service_duration'},
                        {text: 'Цена', value: 'service_price'}
                    ],
                    appointmentsNew: <?php
                        echo json_encode($data['appointments']['new']);
                    ?>,
                    appointmentsCanceled: <?php
                        echo json_encode($data['appointments']['canceled']);
                    ?>,
                    tabs: null,
                }
            }
        }
    );
</script>
