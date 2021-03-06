<?php use yii\helpers\Html;

$this->setBreadcrumbs(['Записи']); ?>

<div id="appointment-view" class="uk-margin-top uk-border-rounded">

    <div v-if="appointmentsNew.length === 0 && appointmentsCanceled.length === 0">
        <div class="uk-card uk-card-default uk-card-hover uk-card-body uk-margin-top uk-border-rounded">
            <h3 class="uk-text-center">Вы не записаны ни на один сеанс.</h3>
            <h3 class="uk-margin-remove uk-text-center">После записи на этой странице появиться таблица с вашими
                записями.</h3>
            <div class="uk-text-center">
                <?php echo Html::a("<button class='button button_color_red button_in_header uk-margin-top uk-margin-bottom'>Подобрать мастера</button>", ['/executor-map']); ?>
            </div>
        </div>
    </div>
    <div v-else>
        <v-tabs fixed-tabs color="#ffffff" v-model="tabType" slot="extension" centered>
            <v-tabs-slider></v-tabs-slider>
            <v-tab class="uk-padding" href="#tab-appointment-new" @click="tabTypeAppointmentNew">
                <p>Открытые</p>
            </v-tab>

            <v-tab class="uk-padding" href="#tab-appointment-canceled" @click="tabTypeAppointmentCanceled">
                <p>Завершенные</p>
            </v-tab>
        </v-tabs>
        <v-tabs-items v-model="tabType" class="white elevation-1">

            <v-tab-item id='tab-appointment-new'>
                <v-card>
                    <v-card-text>
                        <v-data-iterator
                                :items="appointmentsNew"
                                :total-items="countNew"
                                :pagination.sync="pagination"
                                :rows-per-page-items="5"
                                prev-icon="mdi-chevron-left"
                                next-icon="mdi-chevron-right"
                                row
                                wrap
                        >
                            <div slot="item" slot-scope="props">

                                <div v-if="props.item.salon_id">
                                    <div class="uk-margin-top">
                                        <a :href="'/site/web/index.php/executor-map/salon-view?id=' + props.item.salon_id">
                                            {{props.item.salname}}
                                        </a>
                                        <span v-if="props.item.status == constants.APPOINTMENT_STATUS_NEW"
                                              class="uk-label uk-label-warning">
                                                Не подтверждено
                                            </span>
                                        <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                        <p class="uk-margin-remove-top" @click="props.item.open = !props.item.open">
                                            <i class="mdi mdi-calendar-clock"></i> {{props.item.start_date}}
                                        </p>

                                        <div v-show="props.item.open">
                                            <v-btn class="uk-margin-bottom" slot="activator" color="red lighten-2"
                                                   @click="setCanceledSession(props.item.id)" dark>
                                                Отменить сеанс
                                            </v-btn>
                                            <v-data-table
                                                    :headers="headers"
                                                    :items="props.item.appointmentItems"
                                                    hide-actions
                                                    class="elevation-1"
                                                    sort-icon="mdi-chevron-down"
                                            >
                                                <template slot="items" slot-scope="pro">
                                                    <td>{{ pro.item.service_name }}</td>
                                                    <td>{{ pro.item.service_duration }} мин.</td>
                                                    <td>{{ pro.item.service_price }} <i
                                                                class="mdi mdi-currency-rub"></i></td>
                                                </template>
                                            </v-data-table>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="uk-margin-top">
                                        <a :href="'/site/web/index.php/executor-map/user-view?id=' + props.item.user_id">
                                            {{props.item.userProfile.name + ' ' + props.item.userProfile.surname}}
                                        </a>

                                        <span v-if="props.item.status == constants.APPOINTMENT_STATUS_NEW"
                                              class="uk-label uk-label-warning">
                                                Не подтверждено
                                            </span>
                                        <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                        <p class="uk-margin-remove-top" @click="props.item.open = !props.item.open">
                                            <i class="mdi mdi-calendar-clock"></i> {{props.item.start_date}}
                                        </p>

                                        <div v-show="props.item.open">
                                            <v-btn class="uk-margin-bottom" slot="activator" color="red lighten-2"
                                                   @click="setCanceledSession(props.item.id)" dark>
                                                Отменить сеанс
                                            </v-btn>

                                            <v-data-table
                                                    :headers="headers"
                                                    :items="props.item.appointmentItems"
                                                    hide-actions
                                                    class="elevation-1"
                                                    sort-icon="mdi-chevron-down"
                                            >
                                                <template slot="items" slot-scope="pro">
                                                    <td>{{ pro.item.service_name }}</td>
                                                    <td>{{ pro.item.service_duration }} мин.</td>
                                                    <td>{{ pro.item.service_price }} <i
                                                                class="mdi mdi-currency-rub"></i></td>
                                                </template>
                                            </v-data-table>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                            </div>

                        </v-data-iterator>
                    </v-card-text>
                </v-card>
            </v-tab-item>

            <v-tab-item id='tab-appointment-canceled'>
                <v-card>
                    <v-card-text>

                        <v-data-iterator
                                :total-items="countCanceled"
                                :items="appointmentsCanceled"
                                :pagination.sync="pagination"
                                :rows-per-page-items="5"
                                prev-icon="mdi-chevron-left"
                                next-icon="mdi-chevron-right"
                                row
                                wrap
                        >
                            <div slot="item" slot-scope="props">

                                <div v-if="props.item.salon_id">
                                    <div class="uk-margin-top">
                                        <a :href="'/site/web/index.php/executor-map/salon-view?id=' + props.item.salon_id">
                                            {{props.item.salname}}
                                        </a>

                                        <p class="uk-margin-remove-top" @click="props.item.open = !props.item.open">
                                            <i class="mdi mdi-calendar-clock"></i> {{props.item.start_date}}
                                        </p>

                                        <div v-show="props.item.open">
                                            <div v-if="props.item.recalls.length === 0">

                                                <v-dialog v-model="dialogComment" width="500">

                                                    <v-btn slot="activator" class="uk-margin-bottom" color="light-blue"
                                                           dark>
                                                        Оставить отзыв и оценку
                                                    </v-btn>

                                                    <v-card>
                                                        <v-card-title class="headline grey lighten-2" primary-title>
                                                            Отзыв и оценка.
                                                        </v-card-title>

                                                        <v-card-text>
                                                            Оставьте отзыв
                                                            <v-textarea v-model="comment.text"></v-textarea>

                                                            Вам понравилось качество услуг ?
                                                            <br>
                                                            <i class="mdi mdi-heart red--text"
                                                               @click="like"
                                                               v-bind:style="styleLike"></i>
                                                            <i class="mdi mdi-heart-broken"
                                                               @click="dislike"
                                                               v-bind:style="styleDislike"></i>
                                                        </v-card-text>

                                                        <v-divider></v-divider>

                                                        <v-card-actions>
                                                            <v-spacer></v-spacer>
                                                            <v-btn color="primary" flat
                                                                   @click="toComment(props.item.account_id, props.item.id)">
                                                                Ок
                                                            </v-btn>
                                                        </v-card-actions>
                                                    </v-card>

                                                </v-dialog>

                                            </div>

                                            <v-data-table
                                                    :headers="headers"
                                                    :items="props.item.appointmentItems"
                                                    hide-actions
                                                    class="elevation-1"
                                                    sort-icon="mdi-chevron-down"
                                            >
                                                <template slot="items" slot-scope="pro">
                                                    <td>{{ pro.item.service_name }}</td>
                                                    <td>{{ pro.item.service_duration }} мин.</td>
                                                    <td>{{ pro.item.service_price }} <i
                                                                class="mdi mdi-currency-rub"></i></td>
                                                </template>
                                            </v-data-table>
                                            <br>

                                            <div class="uk-grid uk-margin-bottom">
                                                <div v-for="i in props.item.recalls" class="uk-width-1-2">
                                                    <div v-if="i.parent_id">
                                                        Ответ
                                                        <div class="review-slide__content">
                                                            <div class="review-slide__extra">
                                                                <div class="vote uk-inline">
                                                                    <div class="review-slide__author-profession">
                                                                        {{i.create_time}}
                                                                    </div>
                                                                    <i class="fas fa-comment-alt-dots vote__icon vote__icon_color_gray"></i>
                                                                    <span class="vote__digits">
                                                                        <div v-if="i.assessment == constants.ASSESSMENT_DISLIKE">
                                                                            <i class="mdi mdi-heart-broken"></i>
                                                                        </div>
                                                                        <div v-else-if="i.assessment == constants.ASSESSMENT_LIKE">
                                                                            <i class="mdi mdi-heart"></i>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="review-slide__text">
                                                                {{i.text}} {{i.parent_id}}
                                                            </div>
                                                            <div v-if="i.text.length > 40">
                                                                <div :id="'id-' + i.id"
                                                                     class="toggle-animation-queued  review-slide__text uk-text-truncate">
                                                                    {{i.text}}
                                                                </div>
                                                                <div class=" toggle-animation-queued review-slide__text"
                                                                     hidden>
                                                                    {{i.text}}
                                                                </div>

                                                                <button class="uk-button uk-button-text uk-margin-small-top"
                                                                        type="button"
                                                                        :uk-toggle="'target: #' + i.id + '; animation: uk-animation-fade; queued: true; duration: 0'">
                                                                    Читать полностью
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div v-else>
                                                        <div class="review-slide__content">
                                                            <div class="review-slide__extra">
                                                                <div class="vote uk-inline">
                                                                    <div class="review-slide__author-profession">
                                                                        {{i.create_time}}
                                                                    </div>
                                                                    <span class="vote__digits">
                                                                        <div v-if="i.assessment == constants.ASSESSMENT_DISLIKE">
                                                                            <i class="mdi mdi-heart-broken"></i>
                                                                        </div>
                                                                        <div v-else-if="i.assessment == constants.ASSESSMENT_LIKE">
                                                                            <i class="mdi mdi-heart"></i>
                                                                        </div>
                                                                    </span>

                                                                </div>
                                                                <div v-if="i.status == constants.STATUS_NOT_VERIFIED"
                                                                     class="uk-margin-auto-left">
                                                                    <i uk-tooltip="title: Непроверенный отзыв; delay: 100"
                                                                       class="mdi mdi-alert-circle-outline"></i>
                                                                </div>
                                                                <div v-else class="uk-margin-auto-left">
                                                                    <i uk-tooltip="title: Проверенный отзыв; delay: 100"
                                                                       class="mdi mdi-check"></i>
                                                                </div>
                                                                <button type="button" uk-close
                                                                        @click="deleteRecall(i.id)"></button>
                                                            </div>

                                                            <div v-if="i.text.length > 40">
                                                                <div :id="'id-' + i.id"
                                                                     class="toggle-animation-queued  review-slide__text uk-text-truncate">
                                                                    {{i.text}}
                                                                </div>
                                                                <div :id="'id-' + i.id"
                                                                     class=" toggle-animation-queued review-slide__text"
                                                                     hidden>
                                                                    {{i.text}}
                                                                </div>

                                                                <button class="uk-button uk-button-text uk-margin-small-top"
                                                                        type="button"
                                                                        :uk-toggle="'target: #id-' + i.id + '; animation: uk-animation-fade; queued: true; duration: 0'">
                                                                    Читать полностью
                                                                </button>
                                                            </div>
                                                            <div v-else>
                                                                <div class="review-slide__text">
                                                                    {{i.text}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="uk-margin-top">
                                        <a :href="'/site/web/index.php/executor-map/user-view?id=' + props.item.user_id">
                                            {{props.item.userProfile.name + ' ' + props.item.userProfile.surname}}
                                        </a>

                                        <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                        <p class="uk-margin-remove-top" @click="props.item.open = !props.item.open">
                                            <i class="mdi mdi-calendar-clock"></i> {{props.item.start_date}}
                                        </p>

                                        <div v-show="props.item.open">
                                            <div v-if="props.item.recalls.length === 0">
                                                <v-dialog v-model="dialogComment" width="500">
                                                    <v-btn slot="activator" color="light-blue" dark>
                                                        Оставить отзыв и оценку
                                                    </v-btn>

                                                    <v-card>
                                                        <v-card-title class="headline grey lighten-2" primary-title>
                                                            Отзыв и оценка.
                                                        </v-card-title>

                                                        <v-card-text>
                                                            Оставьте отзыв
                                                            <v-textarea v-model="comment.text"></v-textarea>
                                                            Вам понравилось качество услуг ?
                                                            <br>
                                                            <i class="mdi mdi-heart red--text"
                                                               @click="like"
                                                               v-bind:style="styleLike"></i>
                                                            <i class="mdi mdi-heart-broken"
                                                               @click="dislike"
                                                               v-bind:style="styleDislike"></i>
                                                        </v-card-text>

                                                        <v-divider></v-divider>

                                                        <v-card-actions>
                                                            <v-spacer></v-spacer>
                                                            <v-btn color="primary" flat
                                                                   @click="toComment(props.item.account_id, props.item.id)">
                                                                Ок
                                                            </v-btn>
                                                        </v-card-actions>
                                                    </v-card>
                                                </v-dialog>
                                            </div>

                                            <v-data-table
                                                    :headers="headers"
                                                    :items="props.item.appointmentItems"
                                                    hide-actions
                                                    class="elevation-1"
                                                    sort-icon="mdi-chevron-down"
                                            >
                                                <template slot="items" slot-scope="pro">
                                                    <td>{{ pro.item.service_name }}</td>
                                                    <td>{{ pro.item.service_duration }} мин.</td>
                                                    <td>{{ pro.item.service_price }} <i
                                                                class="mdi mdi-currency-rub"></i></td>
                                                </template>
                                            </v-data-table>
                                            <br>

                                            <div class="uk-grid uk-margin-bottom">
                                                <div v-for="i in props.item.recalls" class="uk-width-1-2">
                                                    <div v-if="i.parent_id">
                                                        Ответ
                                                        <div class="review-slide__content">
                                                            <div class="review-slide__extra">
                                                                <div class="vote uk-inline">
                                                                    <div class="review-slide__author-profession">
                                                                        {{i.create_time}}
                                                                    </div>
                                                                    <i class="fas fa-comment-alt-dots vote__icon vote__icon_color_gray"></i>
                                                                    <span class="vote__digits">
                                                                        <div v-if="i.assessment == constants.ASSESSMENT_DISLIKE">
                                                                            <i class="mdi mdi-heart-broken"></i>
                                                                        </div>
                                                                        <div v-else-if="i.assessment == constants.ASSESSMENT_LIKE">
                                                                            <i class="mdi mdi-heart"></i>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="review-slide__text">
                                                                {{i.text}} {{i.parent_id}}
                                                            </div>
                                                            <div v-if="i.text.length > 40">
                                                                <div :id="'id-' + i.id"
                                                                     class="toggle-animation-queued  review-slide__text uk-text-truncate">
                                                                    {{i.text}}
                                                                </div>
                                                                <div class=" toggle-animation-queued review-slide__text"
                                                                     hidden>
                                                                    {{i.text}}
                                                                </div>

                                                                <button class="uk-button uk-button-text uk-margin-small-top"
                                                                        type="button"
                                                                        :uk-toggle="'target: #' + i.id + '; animation: uk-animation-fade; queued: true; duration: 0'">
                                                                    Читать полностью
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div v-else>
                                                        <div class="review-slide__content">
                                                            <div class="review-slide__extra">
                                                                <div class="vote uk-inline">
                                                                    <div class="review-slide__author-profession">
                                                                        {{i.create_time}}
                                                                    </div>
                                                                    <span class="vote__digits">
                                                                        <div v-if="i.assessment == constants.ASSESSMENT_DISLIKE">
                                                                            <i class="mdi mdi-heart-broken"></i>
                                                                        </div>
                                                                        <div v-else-if="i.assessment == constants.ASSESSMENT_LIKE">
                                                                            <i class="mdi mdi-heart"></i>
                                                                        </div>
                                                                    </span>

                                                                </div>
                                                                <div v-if="i.status == constants.STATUS_NOT_VERIFIED"
                                                                     class="uk-margin-auto-left">
                                                                    <i uk-tooltip="title: Непроверенный отзыв; delay: 100"
                                                                       class="mdi mdi-alert-circle-outline"></i>
                                                                </div>
                                                                <div v-else class="uk-margin-auto-left">
                                                                    <i uk-tooltip="title: Проверенный отзыв; delay: 100"
                                                                       class="mdi mdi-check"></i>
                                                                </div>
                                                                <button type="button" uk-close
                                                                        @click="deleteRecall(i.id)"></button>
                                                            </div>

                                                            <div v-if="i.text.length > 40">
                                                                <div :id="'id-' + i.id"
                                                                     class="toggle-animation-queued  review-slide__text uk-text-truncate">
                                                                    {{i.text}}
                                                                </div>
                                                                <div :id="'id-' + i.id"
                                                                     class=" toggle-animation-queued review-slide__text"
                                                                     hidden>
                                                                    {{i.text}}
                                                                </div>

                                                                <button class="uk-button uk-button-text uk-margin-small-top"
                                                                        type="button"
                                                                        :uk-toggle="'target: #id-' + i.id + '; animation: uk-animation-fade; queued: true; duration: 0'">
                                                                    Читать полностью
                                                                </button>
                                                            </div>
                                                            <div v-else>
                                                                <div class="review-slide__text">
                                                                    {{i.text}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
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

    <v-dialog v-model="dialog" width="500">

        <v-card>
            <v-card-title class="headline grey lighten-2" primary-title>
                Вы уверены ?
            </v-card-title>

            <v-card-text>
                Опишите причину
                <v-textarea
                        name="input-7-1"
                        v-model="reason"
                ></v-textarea>

            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" flat @click="cancelSession()">
                    Я Уверен
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</div>

<script>
    appointmentList();

    function appointmentList() {
        const TAB_TYPE_APPOINTMENT_NEW = 'tab-appointment-new';
        const TAB_TYPE_APPOINTMENT_CANCELED = 'tab-appointment-canceled';

        const ASSESSMENT_LIKE = 1;
        const ASSESSMENT_DEFAULT = 0;
        const ASSESSMENT_DISLIKE = -1;

        const STATUS_NOT_VERIFIED = 0;
        const STATUS_VERIFIED = 1;

        const APPOINTMENT_STATUS_NEW = 2;

        new Vue({
                el: '#appointment-view',
                beforeMount() {
                    this.loadAttributesFromQueryParams();
                    this.loadDataNew();
                    this.loadDataCanceled();
                    if (!this.hasTabType()) this.defaultTabType();
                },

                data: {
                    constants: {
                        STATUS_NOT_VERIFIED: STATUS_NOT_VERIFIED,
                        STATUS_VERIFIED: STATUS_VERIFIED,

                        ASSESSMENT_LIKE: ASSESSMENT_LIKE,
                        ASSESSMENT_DEFAULT: ASSESSMENT_DEFAULT,
                        ASSESSMENT_DISLIKE: ASSESSMENT_DISLIKE,

                        APPOINTMENT_STATUS_NEW: APPOINTMENT_STATUS_NEW
                    },
                    dialogComment: false,
                    reason: '',
                    headers: [
                        {text: 'Процедура', value: 'service_name'},
                        {text: 'Длительность', value: 'service_duration'},
                        {text: 'Цена', value: 'service_price'}
                    ],
                    tabType: null,
                    dialog: false,
                    countNew: null,
                    countCanceled: null,
                    appointmentsNew: [],
                    appointmentsCanceled: [],

                    pagination: {
                        pageNew: 1,
                        pageCanceled: 1
                    },
                    paginationCanceled: {},

                    valid: false,
                    recall: '',
                    comment: {
                        accountId: null,
                        appointmentId: null,
                        assessment: null,
                        text: '',
                    },
                    styleLike: {
                        fontSize: '30px',
                        opacity: 0.4
                    },
                    styleDislike: {
                        fontSize: '30px',
                        opacity: 0.4
                    },
                    isLike: false,
                    isDislike: false,

                    canceledSession: null
                },
                methods: {
                    hasTabType() {
                        return this.tabType !== null;
                    },

                    defaultTabType() {
                        this.tabTypeAppointmentNew();
                    },

                    tabTypeAppointmentNew() {
                        this.setTabType(TAB_TYPE_APPOINTMENT_NEW);
                    },
                    tabTypeAppointmentCanceled() {
                        this.setTabType(TAB_TYPE_APPOINTMENT_CANCELED);
                    },

                    loadDataNew() {
                        $.get(cUrl.create('appointment/appointment-data-new', {
                            page: this.pagination.pageNew
                        }))
                            .done(data => {
                                this.countNew = data.total;
                                this.appointmentsNew = [];

                                if (data.appointments.length !== 0) {
                                    for (let i = 0, appointment; appointment = data.appointments[i]; i++) {
                                        appointment.open = false;
                                        this.appointmentsNew.push(appointment)
                                    }
                                }
                            });
                    },

                    loadDataCanceled() {
                        $.get(cUrl.create('appointment/appointment-data-canceled', {
                            page: this.pagination.pageCanceled
                        }))
                            .done(data => {
                                this.countCanceled = data.total;
                                this.appointmentsCanceled = [];

                                if (data.appointments.length !== 0) {
                                    for (let i = 0, appointment; appointment = data.appointments[i]; i++) {
                                        appointment.open = false;
                                        this.appointmentsCanceled.push(appointment)
                                    }
                                }
                            });
                    },

                    setTabType(type) {
                        this.tabType = type;
                        this.locationQueryParamsPush();
                    },

                    locationQueryParamsPush() {
                        let params = new URLSearchParams(document.location.search);
                        params.set('tab_type', this.tabType);
                        params.set('page_new', this.pagination.pageNew);
                        params.set('page_canceled', this.pagination.pageCanceled);

                        let baseUrl = [location.protocol, '//', location.host, location.pathname].join('');

                        history.replaceState({}, '', [baseUrl, params.toString()].join('?'));
                    },

                    loadAttributesFromQueryParams() {
                        let params = new URLSearchParams(document.location.search),
                            tabType = params.get('tab_type');

                        if (tabType === TAB_TYPE_APPOINTMENT_NEW) this.tabTypeAppointmentNew();
                        else if (tabType === TAB_TYPE_APPOINTMENT_CANCELED) this.tabTypeAppointmentCanceled();
                    },

                    cancelSession() {
                        $.get(cUrl.create('appointment/cancel', {
                            id: this.canceledSession,
                            reason: this.reason
                        }))
                            .done(data => {
                                if (data) {
                                    this.dialog = false;
                                    this.appointmentsNew.forEach(function (item, i, arr) {
                                        if (item.id === this.canceledSession) {
                                            arr.splice(i, 1);
                                        }
                                    });

                                    this.loadDataNew();
                                }
                            });
                    },
                    toComment(accountId, appointmentId) {
                        $.get(cUrl.create('recall/create', {
                            accountId: accountId,
                            appointmentId: appointmentId,
                            assessment: this.comment.assessment,
                            text: this.comment.text
                        }))
                            .done(data => {
                                if (data) {
                                    this.dialogComment = false;
                                    this.loadDataCanceled();
                                }
                            });
                    },
                    like() {
                        if (this.isLike) {
                            this.comment.assessment = 0;
                            this.styleLike.opacity = 0.4;
                            this.isLike = false;
                        } else {
                            this.comment.assessment = 1;
                            this.styleLike.opacity = 1;
                            this.styleDislike.opacity = 0.4;
                            this.isDislike = false;
                            this.isLike = true;
                        }
                    },
                    dislike() {
                        if (this.isDislike) {
                            this.comment.assessment = 0;
                            this.styleDislike.opacity = 0.4;
                            this.isDislike = false;
                        } else {
                            this.comment.assessment = -1;
                            this.styleDislike.opacity = 1;
                            this.styleLike.opacity = 0.4;
                            this.isLike = false;
                            this.isDislike = true;
                        }
                    },
                    deleteRecall(id) {
                        if (confirm('Вы уверены что хотите удалить отзыв ?')) {
                            $.get(cUrl.create('recall/delete', {
                                id: id
                            }))
                                .done(data => {
                                    this.loadDataCanceled();
                                });
                        }
                    },

                    setCanceledSession(id) {
                        this.dialog = true;
                        this.canceledSession = id;
                    }
                },
                watch: {
                    pagination() {
                        this.loadAttributesFromQueryParams();
                        this.loadDataNew();
                        this.loadDataCanceled();
                    }
                },
            }
        );
    }
</script>
