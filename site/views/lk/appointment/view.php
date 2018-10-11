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

                                    row
                                    wrap
                                    prev-icon="mdi-chevron-left"
                                    next-icon="mdi-chevron-right"
                            >
                                <div slot="item" slot-scope="props">

                                    <div v-if="props.item.salon_id">
                                        <div>
                                            <a :href="'/site/web/index.php/lk/executor-map/salon-view?id=' + props.item.salon_id">
                                                {{props.item.salname}}
                                            </a>

                                            <span v-if="props.item.status === 0" class="uk-label uk-label-warning">Не подтверждено</span>
                                            <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                            <p @click="props.item.open = !props.item.open">{{ props.item.start_date
                                                }}</p>

                                            <div v-show="props.item.open">
                                                <v-btn @click="cancelSession(props.item.id)" color="error">Отменить
                                                    сеанс
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

                                            <span v-if="props.item.status === 0" class="uk-label uk-label-warning">Не подтверждено</span>
                                            <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                            <p @click="props.item.open = !props.item.open">{{ props.item.start_date
                                                }}</p>

                                            <div v-show="props.item.open">
                                                <v-btn @click="cancelSession(props.item.id)" color="error">Отменить
                                                    сеанс
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

                                            <span v-if="props.item.status === 0" class="uk-label uk-label-warning">Не подтверждено</span>
                                            <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                            <p @click="props.item.open = !props.item.open">{{ props.item.start_date
                                                }}</p>

                                            <div v-show="props.item.open">
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
                                                <div class="uk-grid">
                                                    <div class="uk-width-2-3">
                                                        <v-form v-model="valid">
                                                            <v-text-field
                                                                    v-model="recall"
                                                                    :counter="250"
                                                                    label="Оставьте ваш отзыв"
                                                                    required
                                                            ></v-text-field>
                                                        </v-form>
                                                    </div>
                                                    <div class="uk-width-1-3"><br>
                                                        <i class="mdi mdi-heart" style="color: red; font-size: 30px;"></i>
                                                        <i class="mdi mdi-heart-broken" style="font-size: 30px;"></i>
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

                                            <span v-if="props.item.status === 0" class="uk-label uk-label-warning">Не подтверждено</span>
                                            <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                            <p @click="open = !open">{{ props.item.start_date }}</p>

                                            <div v-show="open">
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
                    headers: [
                        {text: 'Процедура', value: 'service_name'},
                        {text: 'Длительность', value: 'service_duration'},
                        {text: 'Цена', value: 'service_price'}
                    ],
                    tabType: null,

                    countNew: null,
                    countCanceled: null,
                    appointmentsNew: [],
                    appointmentsCanceled: [],

                    pagination: {},
                    paginationCanceled: {},

                    valid: false,
                    recall: '',
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
                        })
                            .done(data => {
                                if (data) {
                                    this.appointmentsNew.forEach(function (item, i, arr) {
                                        if (item.id === id) {
                                            arr.splice(i, 1);
                                        }
                                    });
                                }
                            });
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
