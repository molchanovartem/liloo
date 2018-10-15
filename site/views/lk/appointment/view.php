<div id="app">
    <v-app id="inspire">
        <div>
            <v-toolbar tabs>
                <v-tabs slot="extension" fixed-tabs color="transparent" v-model="tabType">
                    <v-tabs-slider></v-tabs-slider>
                    <v-tab href="#tab-appointment-new" @click="tabTypeAppointmentNew">
                        <p>Открытые</p>
                    </v-tab>

                    <v-tab href="#tab-appointment-canceled" @click="tabTypeAppointmentCanceled">
                        <p>Завершенные</p>
                    </v-tab>
                </v-tabs>
            </v-toolbar>

            <v-tabs-items v-model="tabType" class="white elevation-1">

                <v-tab-item id='tab-appointment-new'>
                    <v-card>
                        <v-card-text>

                            <v-data-iterator
                                    :items="appointmentsNew"
                                    :total-items="countNew"
                                    :pagination.sync="pagination"
                                    prev-icon="mdi-chevron-left"
                                    next-icon="mdi-chevron-right"
                                    row
                                    wrap
                            >
                                <div slot="item" slot-scope="props">

                                    <div v-if="props.item.salon_id">
                                        <div>
                                            <a :href="'/site/web/index.php/lk/executor-map/salon-view?id=' + props.item.salon_id">
                                                {{props.item.salname}}
                                            </a>

                                            <span v-if="props.item.status === 0" class="uk-label uk-label-warning">
                                                Не подтверждено
                                            </span>
                                            <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                            <p @click="props.item.open = !props.item.open">{{props.item.start_date}}</p>

                                            <div v-show="props.item.open">

                                                <v-dialog v-model="dialog" width="500">
                                                    <v-btn slot="activator" color="red lighten-2" dark>
                                                        Отменить сеанс
                                                    </v-btn>

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
                                                            <v-btn color="primary" flat
                                                                   @click="cancelSession(props.item.id)">
                                                                Я Уверен
                                                            </v-btn>
                                                        </v-card-actions>
                                                    </v-card>
                                                </v-dialog>

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
                                    </div>
                                    <div v-else>
                                        <div>
                                            <a :href="'/site/web/index.php/lk/executor-map/user-view?id=' + props.item.user_id">
                                                {{props.item.name + ' ' + props.item.surname}}
                                            </a>

                                            <span v-if="props.item.status === 0" class="uk-label uk-label-warning">
                                                Не подтверждено
                                            </span>
                                            <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                            <p @click="props.item.open = !props.item.open">{{props.item.start_date}}</p>

                                            <div v-show="props.item.open">
                                                <v-dialog v-model="dialog" width="500">
                                                    <v-btn slot="activator" color="red lighten-2" dark>
                                                        Отменить сеанс
                                                    </v-btn>

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
                                                            <v-btn color="primary" flat
                                                                   @click="cancelSession(props.item.id)">
                                                                Я Уверен
                                                            </v-btn>
                                                        </v-card-actions>
                                                    </v-card>
                                                </v-dialog>
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
                                    :items="appointmentsCanceled"
                                    row
                                    wrap
                                    prev-icon="mdi-chevron-left"
                                    next-icon="mdi-chevron-right"
                                    :total-items="countCanceled"
                            >
                                <div slot="item" slot-scope="props">

                                    <div v-if="props.item.salon_id">
                                        <div>
                                            <a :href="'/site/web/index.php/lk/executor-map/salon-view?id=' + props.item.salon_id">
                                                {{props.item.salname}}
                                            </a>

                                            <span v-if="props.item.status === 0" class="uk-label uk-label-warning">
                                                Не подтверждено
                                            </span>
                                            <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                            <p @click="props.item.open = !props.item.open">{{props.item.start_date}}</p>

                                            <div v-show="props.item.open">
                                                <v-dialog v-model="dialogComment" width="500">
                                                    <v-btn slot="activator" color="primary" dark>
                                                        Оставить комментарий и оценку
                                                    </v-btn>

                                                    <v-card>
                                                        <v-card-title class="headline grey lighten-2" primary-title>
                                                            Комментарий и оценка.
                                                        </v-card-title>

                                                        <v-card-text>
                                                            Оставьте комментарий
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
                                                <br>

                                                <div v-for="i in props.item.recalls">
                                                    <div class="uk-width-1-2">
                                                        <div class="review-slide__content">
                                                            <div class="review-slide__extra">
                                                                <div class="vote uk-inline">
                                                                    <div class="review-slide__author-profession">
                                                                        {{i.create_time}}
                                                                    </div>
                                                                    <i class="fas fa-comment-alt-dots vote__icon vote__icon_color_gray"></i>
                                                                    <span class="vote__digits">
                                                                    <div v-if="i.assessment == -1">
                                                                        <i class="mdi mdi-heart-broken"></i>
                                                                    </div>
                                                                    <div v-else-if="i.assessment == 1">
                                                                        <i class="mdi mdi-heart"></i>
                                                                    </div>
                                                                </span>
                                                                </div>
                                                            </div>
                                                            <div class="review-slide__text">
                                                                {{i.text}}
                                                            </div>
                                                            <a href="" class="review-slide__more">Читать полностью</a>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div>
                                            <a :href="'/site/web/index.php/lk/executor-map/user-view?id=' + props.item.user_id">
                                                {{props.item.name + ' ' + props.item.surname}}
                                            </a>

                                            <span v-if="props.item.status === 0" class="uk-label uk-label-warning">
                                                Не подтверждено
                                            </span>
                                            <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                            <p @click="props.item.open = !props.item.open">{{ props.item.start_date
                                                                                           }}</p>

                                            <div v-show="props.item.open">
                                                <v-dialog v-model="dialogComment" width="500">
                                                    <v-btn slot="activator" color="primary" dark>
                                                        Оставить комментарий и оценку
                                                    </v-btn>

                                                    <v-card>
                                                        <v-card-title class="headline grey lighten-2" primary-title>
                                                            Комментарий и оценка.
                                                        </v-card-title>

                                                        <v-card-text>
                                                            Оставьте комментарий
                                                            <v-textarea v-model="comment.text"></v-textarea>

                                                            Вам понравилось качество услуг ?
                                                            <br>
                                                            <i class="mdi mdi-heart red--text"
                                                               @click="like"
                                                               style="font-size: 30px; opacity: 0.4"></i>
                                                            <i class="mdi mdi-heart-broken"
                                                               @click="dislike"
                                                               style="font-size: 30px; opacity: 0.4"></i>
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

                                                <div class="bill uk-margin-small-top">
                                                    <div v-for="i in props.item.recalls">
                                                        <div class="bill__row">
                                                            <div class="bill__name">{{i.id}}</div>
                                                            <div class="bill__cost">{{i.text}}</div>
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

    </v-app>
</div>

<script>
    appointmentList();

    function appointmentList() {
        const TAB_TYPE_APPOINTMENT_NEW = 'tab-appointment-new';
        const TAB_TYPE_APPOINTMENT_CANCELED = 'tab-appointment-canceled';

        new Vue({
                el: '#app',
                beforeMount() {
                    this.loadAttributesFromQueryParams();
                    this.loadDataNew();
                    this.loadDataCanceled();
                    if (!this.hasTabType()) this.defaultTabType();
                },

                data: {
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

                    pagination: {},
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
                        $.get('http://liloo/site/web/lk/appointment/appointment-data-new', {
                            page: this.pagination.page
                        })
                            .done(data => {
                                this.countNew = data.total;
                                this.appointmentsNew = [];

                                if (data.appointments) {
                                    for (let i = 0, appointment; appointment = data.appointments[i]; i++) {
                                        appointment.open = false;
                                        this.appointmentsNew.push(appointment)
                                    }
                                }
                            });
                    },

                    loadDataCanceled() {
                        $.get('http://liloo/site/web/lk/appointment/appointment-data-canceled', {
                            page: this.pagination.page
                        })
                            .done(data => {
                                this.countCanceled = data.total;
                                this.appointmentsCanceled = [];

                                if (data.appointments) {
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
                        params.set('page_new', this.pagination.page);

                        let baseUrl = [location.protocol, '//', location.host, location.pathname].join('');

                        history.replaceState({}, '', [baseUrl, params.toString()].join('?'));
                    },

                    loadAttributesFromQueryParams() {
                        let params = new URLSearchParams(document.location.search),
                            tabType = params.get('tab_type');

                        if (tabType === TAB_TYPE_APPOINTMENT_NEW) this.tabTypeAppointmentNew();
                        else if (tabType === TAB_TYPE_APPOINTMENT_CANCELED) this.tabTypeAppointmentCanceled();
                    },

                    cancelSession(id) {
                        $.get('http://liloo/site/web/lk/appointment/cancel', {
                            id: id,
                            reason: this.reason
                        })
                            .done(data => {
                                if (data) {
                                    this.dialog = false;
                                    this.appointmentsNew.forEach(function (item, i, arr) {
                                        if (item.id === id) {
                                            arr.splice(i, 1);
                                        }
                                    });
                                }
                            });
                    },
                    toComment(accountId, appointmentId) {
                        $.get('http://liloo/site/web/lk/recall/create', {
                            accountId: accountId,
                            appointmentId: appointmentId,
                            assessment: this.comment.assessment,
                            text: this.comment.text
                        })
                            .done(data => {
                                if (data) {
                                    this.dialogComment = false;
                                    loadDataCanceled();
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
                            console.log(this.comment.assessment);

                        } else {
                            this.comment.assessment = -1;
                            this.styleDislike.opacity = 1;
                            this.styleLike.opacity = 0.4;
                            this.isLike = false;
                            this.isDislike = true;
                            console.log(this.comment.assessment);

                        }
                    },
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
