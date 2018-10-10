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
                                    :pagination.sync="appointmentNewPagination"
                                    :total-items="countNew"
                                    row
                                    wrap
                                    prev-icon="mdi-chevron-left"
                                    next-icon="mdi-chevron-right"
                            >
                                <div slot="item" slot-scope="props">

                                    <div v-if="props.item.salon_id">
                                        <div>
                                            <a :href="'/site/web/index.php/lk/executor-map/salon-view?id=' + props.item.salon_id">
                                                {{props.item.salon.name}}
                                            </a>

                                            <span v-if="props.item.status === 0" class="uk-label uk-label-warning">Не подтверждено</span>
                                            <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                            <p @click="props.item.open = !props.item.open">{{ props.item.start_date }}</p>

                                            <div v-show="props.item.open">
                                                <v-btn @click="cancelSession(props.item.id)" color="error">Отменить сеанс</v-btn>
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
                                                {{props.item.userProfile.name + ' ' + props.item.userProfile.surname}}
                                            </a>

                                            <span v-if="props.item.status === 0" class="uk-label uk-label-warning">Не подтверждено</span>
                                            <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                            <p @click="props.item.open = !props.item.open">{{ props.item.start_date }}</p>

                                            <div v-show="props.item.open">
                                                <v-btn @click="cancelSession(props.item.id)" color="error">Отменить сеанс</v-btn>
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
                                                {{props.item.salon.name}}
                                            </a>

                                            <span v-if="props.item.status === 0" class="uk-label uk-label-warning">Не подтверждено</span>
                                            <span v-else class="uk-label uk-label-success">Подтверждено</span>
                                            <p @click="props.item.open = !props.item.open">{{ props.item.start_date }}</p>

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
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div>
                                            <a :href="'/site/web/index.php/lk/executor-map/user-view?id=' + props.item.user_id">
                                                {{props.item.userProfile.name + ' ' + props.item.userProfile.surname}}
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
                    console.log(this.appointmentNewPagination);
                    this.loadAttributesFromQueryParams();
                    this.loadData();
                    if (!this.hasTabType()) this.defaultTabType();

                    if (!this.hasAppointmentNewPage()) this.defaultAppointmentNewPage();
                    if (!this.hasAppointmentCanceledPage()) this.defaultAppointmentCanceledPage();

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

                    appointmentNewPage: null,
                    appointmentCanceledPage: null,

                    appointmentsNew: [],
                    appointmentsCanceled: [],

                    appointmentNewPagination: {},

                    attributes: {
                        userId: null,
                        // specializationId: null,
                        // serviceId: null,
                        // cityId: null,
                        // date: null
                    },
                },
                methods: {
                    hasTabType() {
                        return this.tabType !== null;
                    },
                    hasAppointmentNewPage() {
                        return this.appointmentNewPage !== null;
                    },
                    hasAppointmentCanceledPage() {
                        return this.appointmentCanceledPage !== null;
                    },


                    defaultTabType() {
                        this.tabTypeAppointmentNew();
                    },
                    defaultAppointmentNewPage() {
                        this.AppointmentNewPage();
                    },
                    defaultAppointmentCanceledPage() {
                        this.AppointmentCanceledPage();
                    },

                    tabTypeAppointmentNew() {
                        this.setTabType(TAB_TYPE_APPOINTMENT_NEW);
                    },
                    tabTypeAppointmentCanceled() {
                        this.setTabType(TAB_TYPE_APPOINTMENT_CANCELED);
                    },

                    AppointmentCanceledPage() {
                        this.setAppointmentCanceledPage(1);
                    },
                    AppointmentNewPage() {
                        this.setAppointmentNewPage(1);
                    },

                    onSubmit() {
                        this.locationQueryParamsPush();
                        this.loadData();
                    },
                    loadCommonData() {
                        return new Promise((resolve, reject) => {
                            $.post('http://liloo/api/common/index', JSON.stringify({
                                query: "query {" +
                                    "specializations {id, name}," +
                                    "services {id, name, price, duration}" +
                                    "cities(country_id: 1) {id, name, latitude, longitude}" +
                                    "}"
                            }))
                                .done(({data}) => {
                                    if (data.specializations) this.specializations = Array.from(data.specializations);
                                    if (data.services) this.services = data.services;
                                    if (data.cities) this.cities = data.cities;

                                    resolve(true)
                                })
                                .fail((error) => {
                                    reject(error);
                                });
                        });
                    },

                    loadData() {
                        $.get('http://liloo/site/web/lk/appointment/appointment-data', {
                            id: this.attributes.userId,
                        })
                            .done(data => {
                                this.appointmentsNew = [];
                                this.appointmentsCanceled = [];

                                if (data.appointments.canceled) {

                                    if (data.appointments.canceled) {
                                        for (let i = 0, appointment; appointment = data.appointments.canceled[i]; i++) {
                                            appointment.open = false;
                                            this.appointmentsCanceled.push(appointment)
                                        }
                                    }
                                }

                                if (data.appointments.new) {
                                    if (data.appointments.new) {
                                        for (let i = 0, appointment; appointment = data.appointments.new[i]; i++) {
                                            appointment.open = false;
                                            this.appointmentsNew.push(appointment)
                                        }
                                    }
                                }

                                this.countNew = data.appointments.countNew;
                                this.countCanceled = data.appointments.countCanceled;
                            });
                    },

                    setTabType(type) {
                        this.tabType = type;
                        this.locationQueryParamsPush();
                    },
                    setAppointmentNewPage(page) {
                        this.appointmentNewPage = page;
                        this.locationQueryParamsPush();
                    },
                    setAppointmentCanceledPage(page) {
                        this.appointmentCanceledPage = page;
                        this.locationQueryParamsPush();
                    },

                    locationQueryParamsPush() {
                        let params = new URLSearchParams(document.location.search);
                        params.set('tab_type', this.tabType);
                        params.set('appointmentNewPage', this.appointmentNewPage);
                        params.set('appointmentCanceledPage', this.appointmentCanceledPage);

                        let baseUrl = [location.protocol, '//', location.host, location.pathname].join('');

                        history.replaceState({}, '', [baseUrl, params.toString()].join('?'));
                    },

                    loadAttributesFromQueryParams() {
                        let params = new URLSearchParams(document.location.search),
                            tabType = params.get('tab_type');

                        this.attributes.userId = params.get('id');
                        this.appointmentNewPage = params.get('appointmentNewPage');
                        this.appointmentCanceledPage = params.get('appointmentCanceledPage');


                        if (tabType === TAB_TYPE_APPOINTMENT_NEW) this.tabTypeAppointmentNew();
                        else if (tabType === TAB_TYPE_APPOINTMENT_CANCELED) this.tabTypeAppointmentCanceled();
                    },

                    cancelSession(id) {
                        $.get('http://liloo/site/web/lk/appointment/cancel', {
                            id: id,
                        })
                            .done(data => {
                                if (data) {
                                    this.appointmentsNew.forEach(function(item, i, arr) {
                                       if (item.id === id) {
                                           arr.splice(i, 1);
                                       }
                                    });
                                }
                            });
                    },
                },
                watch: {
                    appointmentNewPagination() {
                        console.log(this.appointmentNewPagination);
                        this.loadData()
                    }
                },
            }
        );
    }
</script>
