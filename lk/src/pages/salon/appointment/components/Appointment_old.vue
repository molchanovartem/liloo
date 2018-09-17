<template>
    <div class="content-block p-40 content-block_shadow">
        <v-master-list :masters="masters" :salonId="salonId"/>

        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:1000px;'>
            <div class="dhx_cal_navline">
                <div class="dhx_cal_prev_button">&nbsp;</div>
                <div class="dhx_cal_next_button">&nbsp;</div>
                <div class="dhx_cal_today_button"></div>
                <div class="dhx_cal_date"></div>
                <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
                <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
                <div class="dhx_cal_tab" name="timeline_tab" style="right:280px;"></div>
            </div>
            <div class="dhx_cal_header"></div>
            <div class="dhx_cal_data"></div>
        </div>


        <v-dialog v-model="modal" width="80%" max-width="1200px">
            <div class="uk-card uk-card-default uk-height-1-1">
                <div class="uk-card-header uk-padding-small">
                    <v-icon class="uk-float-right" @click="modalClose()">mdi-close</v-icon>
                </div>
                <div class="uk-card-body uk-padding-small">
                    <v-form v-model="valid" lazy-validation ref="form">
                        <div class="uk-grid uk-grid-divider uk-grid-small">
                            <div class="uk-width-1-4">
                                <v-select
                                        v-model="attributes.status"
                                        :items="getStatusList()"
                                        :rules="rules.status"
                                        label="Статус"
                                        required
                                        outline
                                />
                                <v-select
                                        v-model="attributes.client_id"
                                        :items="clients"
                                        :rules="rules.clientId"
                                        label="Клиент"
                                        item-text="name"
                                        item-value="id"
                                        required
                                        outline
                                />
                                <v-text-field v-model="attributes.start_date" label="Date start" outline/>
                                <v-text-field v-model="attributes.end_date" label="Date end" outline/>
                            </div>
                            <div class="uk-width-3-4">
                                <h5>Услуги</h5>
                                <div class="uk-grid uk-grid-small uk-width-2-3">
                                    <div class="uk-width-expand">
                                        <v-select
                                                :items="services"
                                                v-model="serviceSelect"
                                                item-value="id"
                                                item-text="name"
                                                outline
                                        />
                                    </div>
                                    <div class="uk-width-auto">
                                        <v-btn @click="onAddItem()">
                                            Добавить
                                            <v-icon small right>mdi-plus</v-icon>
                                        </v-btn>
                                    </div>
                                </div>

                                <ul>
                                    <li>Время: с {{ attributes.start_date | formatDate }} до {{ endDate | formatDate
                                        }}
                                    </li>
                                    <li>Длительность: {{duration | formatDuration}}</li>
                                    <li>Общая сумма: {{ commonSum | formatCurrency }}</li>
                                </ul>

                                <v-data-table
                                        :headers="headers"
                                        :items="attributes.items"
                                        hide-actions
                                >
                                    <template slot="items" slot-scope="props, index">
                                        <td>{{props.item.service_name}}</td>
                                        <td>{{props.item.service_price | formatCurrency}}</td>
                                        <td>{{props.item.service_duration}}</td>
                                        <td>
                                            <v-text-field
                                                    v-model="props.item.quantity"
                                                    :rules="rules.quantity"
                                                    outline
                                            />
                                        </td>
                                        <td>
                                            <v-btn @click="deleteItem(props.index)" fab small flat>
                                                <v-icon>mdi-minus</v-icon>
                                            </v-btn>
                                        </td>
                                    </template>
                                </v-data-table>
                            </div>
                        </div>
                    </v-form>
                </div>
                <div class="uk-card-footer uk-padding-small">
                    <v-btn color="primary" @click="submit()">Сохранить
                        <v-icon right>mdi-content-save</v-icon>
                    </v-btn>
                </div>
            </div>
        </v-dialog>
    </div>
</template>

<script>
    import 'dhtmlx-scheduler/codebase/dhtmlxscheduler_flat.css';
    import 'dhtmlx-scheduler/codebase/dhtmlxscheduler.js';
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_quick_info.js';
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_limit.js';
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_timeline';

    import gql from 'graphql-tag';
    import dateFormat from 'dateformat';
    import {formRules} from "../../../js/formRules";

    import Status from '../../appointment/components/Status';
    import VMasterList from './components/MasterList.vue';

    const SCENARIO_CREATE = 'create',
        SCENARIO_UPDATE = 'update';

    export default {
        name: "SalonAppointment",
        props: {
            salonId: {
                type: String,
                required: true
            }
        },
        components: {
            VMasterList,
        },
        created() {
            this.$on('save', (appointment) => {
                alert('save');
            });
            this.scheduler = Scheduler.getSchedulerInstance();
        },
        mounted() {
            this.setMasterId();
            this.loadCommonData().then(() => {
                // Инициализируем календарь
                this.initScheduler();
            });
        },
        destroyed() {
            delete this.scheduler;
        },
        data() {
            return {
                modal: false,
                masterId: null,
                // Мастера
                masters: [],
                // Клиентов
                clients: [],
                // Услуги
                services: [],
                status: new Status,
                currentAppointment: null,
                config: {
                    mode: 'week'
                },

                // form
                valid: false,
                headers: [
                    {text: 'Название', value: 'service_name', sortable: false},
                    {text: 'Цена', value: 'service_price', sortable: false},
                    {text: 'Длительность', value: 'service_duration', sortable: false},
                    {text: 'Количество', value: 'quantity', sortable: false},
                    {text: null, value: null, sortable: false}
                ],
                attributes: {
                    id: null,
                    master_id: null,
                    client_id: null,
                    status: null,
                    start_date: null,
                    end_date: null,
                    items: [
                        {
                            service_id: '1',
                            service_name: 'test',
                            service_price: '300',
                            service_duration: '20',
                            quantity: 1,
                            discount: 0
                        }
                    ]
                },
                duration: 0,
                serviceSelect: null,
                rules: {
                    status: [
                        v => formRules.required(v),
                    ],
                    clientId: [
                        v => formRules.required(v)
                    ],
                    quantity: [
                        v => formRules.required(v),
                        v => formRules.number(v, {numericality: true})
                    ]
                }
                // end form
            }
        },
        computed: {
            // Вычисляемое свойство окончание даты
            endDate() {
                if (!this.attributes.start_date) return;

                for (var index = 0, minutes = 0, item; item = this.attributes.items[index]; index++) {
                    if (!isFinite(item.quantity) || !isFinite(item.service_duration)) continue;
                    if (item.quantity > 1000 || item.quantity < 0) continue;

                    minutes += +item.quantity * +item.service_duration;
                }

                let startDate = new Date(this.attributes.start_date),
                    endDate = new Date(startDate);

                endDate.setMinutes(startDate.getMinutes() + minutes);
                this.attributes.end_date = dateFormat(endDate, 'yyyy-mm-dd HH:MM:ss');
                this.duration = minutes;

                return endDate;
            },
            // Вычисляемое свойство общая сумма
            commonSum() {
                for (var index = 0, sum = 0, item; item = this.attributes.items[index]; index++) {
                    if (!isFinite(item.quantity) || !isFinite(item.service_price)) continue;
                    if (item.quantity > 1000 || item.quantity < 0 || item.service_price < 0) continue;

                    sum += +item.quantity * +item.service_duration;
                }
                return sum;
            }
        },
        methods: {
            reload() {
                this.loadCommonData().then(() => {
                    // Инициализируем календарь
                    this.initScheduler();
                });
            },
            /**
             * Загружает общие данные
             */
            loadCommonData() {
                let self = this;

                return new Promise(function (resolve, reject) {
                    self.$apollo.query({
                        query: gql`query ($salonId: ID!) {
                            salon(id: $salonId) {
                                id, name, masters {id, surname, name}
                            },
                            clients {id, surname, name, patronymic, date_birth}
                        }`,
                        variables: {
                            salonId: self.salonId
                        }
                    }).then(({data}) => {
                        self.masters = Array.from(data.salon.masters);
                        self.clients = data.clients;

                        resolve(true)
                    }).catch(({error}) => {
                        reject(error);
                    });
                });
            },

            loadServicesData(masterId) {
                this.$apollo.query({
                    query: gql`query ($salonId: ID!, $masterId: ID!) {
                        salonServicesForMaster(salon_id: $salonId, master_id: $masterId) {
                            id, salon_id, service_id, service_price, service_duration, service{id, name}
                        }
                    }`,
                    variables: {
                        salonId: this.salonId,
                        masterId: masterId
                    }
                }).then(({data}) => {
                    this.services = Array.from(data.salonServicesForMaster).map(item => {
                        return {
                            id: item.service.id,
                            name: item.service.name,
                            price: item.service_price,
                            duration: item.service_duration
                        }
                    });
                })
            },
            /**
             * Загружает записи, время работы сотрудника
             */
            loadData() {
                let state = this.scheduler.getState(),
                    startDate = state.min_date,
                    endDate = state.max_date;

                this.$apollo.query({
                    query: gql`query (
                        $salonId: ID,
                        $masterId: ID,
                        $startDate: DateTime,
                        $endDate: DateTime
                    ) {
                            appointments(
                                salon_id: $salonId,
                                master_id: $masterId
                                start_date: $startDate,
                                end_date: $endDate
                            ) {
                                    id, salon_id, user_id, master_id, client_id, owner_id, status, start_date, end_date,
                                    items {id, appointment_id, service_id, service_name, service_price, service_duration, quantity},
                                    client {id, surname, name, patronymic, date_birth},
                            },
                            masterSchedules(salon_id: $salonId, master_id: $masterId, start_date: $startDate, end_date: $endDate) {
                                id, master_id, salon_id, type, start_date, end_date
                            }
                        }`,
                    variables: {
                        salonId: this.salonId,
                        masterId: this.masterId,
                        startDate: this.dateFormat(startDate),
                        endDate: this.dateFormat(endDate)
                    }
                }).then(({data}) => {
                    this.deleteAllAppointmentForSchedule();

                    let appointments = [];
                    Array.from(data.appointments).forEach(appointment => {
                        appointments.push(this.createEvent(appointment));
                    });
                    this.scheduler.parse(appointments, 'json');

                    this.scheduler.deleteMarkedTimespan();

                    if (this.masterId !== null) {
                        this.scheduler.blockTime({
                            start_date: new Date(startDate),
                            end_date: new Date(endDate),
                        });

                        Array.from(data.masterSchedules).forEach(item => {
                            this.scheduler.deleteMarkedTimespan({
                                start_date: new Date(item.start_date),
                                end_date: new Date(item.end_date),
                            });
                        });
                    }

                    this.blockTimFromTimeline(this.getMastersId(), startDate, endDate);
                    this.unblockTimFromTimeline(Array.from(data.masterSchedules));
                    this.scheduler.updateView();
                });
            },
            /**
             * Загружает визит
             */
            loadAppointment(id) {
                return this.$apollo.query({
                    query: gql`query ($id: ID!) {
                            appointment(id: $id) {
                                id, user_id, salon_id, master_id, client_id, status, start_date, end_date,
                                items {
                                  id, appointment_id, service_id, service_name, service_price, service_duration, quantity
                                },
                                client {id, surname, name, patronymic, date_birth}
                            }
                        }`,
                    variables: {
                        id: id
                    }
                });
            },

            /**
             * Создается календарь
             */
            initScheduler() {
                let self = this;

                this.scheduler._on_dbl_click = function (e, src) {
                    src = src || (e.target || e.srcElement);
                    if (this.config.readonly) return;
                    var name = scheduler._getClassName(src).split(" ")[0];
                    switch (name) {
                        case "dhx_scale_holder":
                        case "dhx_scale_holder_now":
                        case "dhx_month_body":
                        case "dhx_wa_day_data":
                            //  Если не выбран мастер, то блокируем создание по 2му клику
                            if (self.masterId === null) break;

                            if (!scheduler.config.dblclick_create) break;
                            this.addEventNow(this.getActionData(e).date, null, e);
                            break;
                        case "dhx_cal_event":
                        case "dhx_wa_ev_body":
                        case "dhx_agenda_line":
                        case "dhx_grid_event":
                        case "dhx_cal_event_line":
                        case "dhx_cal_event_clear":
                            var id = this._locate_event(src);
                            if (!this.callEvent("onDblClick", [id, e])) return;
                            if (this.config.details_on_dblclick || this._table_view || !this.getEvent(id)._timed || !this.config.select)
                                this.showLightbox(id);
                            else
                                this.edit(id);
                            break;
                        case "dhx_time_block":
                        case "dhx_cal_container":
                            return;
                        default:
                            var t = this["dblclick_" + name];
                            if (t) {
                                t.call(this, e);
                            }
                            else {
                                if (src.parentNode && src != this)
                                    return scheduler._on_dbl_click(e, src.parentNode);
                            }
                            break;
                    }
                };

                this.initSchedulerConfig();
                this.initSchedulerTemplates();
                this.initSchedulerEvents();

                this.scheduler.init('scheduler_here', new Date, this.config.mode);

            },
            // Конфигурация
            initSchedulerConfig() {
                this.scheduler.config.api_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.xml_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.details_on_dblclick = false;
                this.scheduler.config.details_on_create = true;
                this.scheduler.config.dblclick_create = true;
                this.scheduler.config.drag_create = false;
                this.scheduler.config.drag_resize = false;
                this.scheduler.config.quick_info_detached = true;
                this.scheduler.config.icons_select = ['icon_edit', 'icon_delete'];
                this.scheduler.xy.scale_height = 35;

                this.scheduler.locale.labels.timeline_tab = "Timeline";

                this.scheduler.showLightbox = (id) => {
                    let appointment = this.scheduler.getEvent(id);

                    this.currentAppointment = appointment;

                    if (appointment.isNew) {
                        this.modalOpen({
                            start_date: this.dateFormat(appointment.start_date),
                            end_date: this.dateFormat(appointment.end_date),
                            master_id: appointment.master_id || this.masterId
                        }, SCENARIO_CREATE);
                    } else {
                        this.loadAppointment(id).then(({data}) => {
                            this.modalOpen(data.appointment, SCENARIO_UPDATE);
                        });
                    }
                };

                this.scheduler.createTimelineView({
                    name: "timeline",
                    x_unit: "minute",//measuring unit of the X-Axis.
                    x_date: "%H:%i", //date format of the X-Axis
                    x_step: 30,      //X-Axis step in 'x_unit's
                    x_size: 24,      //X-Axis length specified as the total number of 'x_step's
                    x_start: 0,     //X-Axis offset in 'x_unit's
                    x_length: 48,    //number of 'x_step's that will be scrolled at a time
                    y_unit: this.masters.map(item => {
                        return {key: item.id, label: item.name}
                    }),
                    y_property: "master_id", //mapped data property
                    render: "bar",             //view mode
                    dy: 60,
                    event_dy: 'full',
                    section_autoheight: false
                });
            },
            // Шаблоны
            initSchedulerTemplates() {
                let self = this;

                this.scheduler.templates.event_header = function (start, end, ev) {

                    function formatDuration(minute) {
                        var seconds = minute * 60,
                            minutes = Math.floor(seconds / 60 % 60),
                            hours = Math.floor(seconds / 3600 % 24);

                        function format(value) {
                            return value < 10 ? '0' + value : value;
                        }

                        return format(hours) + ':' + format(minutes);
                    }

                    return '<i class="mdi mdi-clock"></i> ' + formatDuration(((new Date(end) - new Date(start)) / 1000) / 60);
                };

                this.scheduler.templates.event_text = function (start, end, event) {
                    let str = [];

                    if (event.client) {
                        str.push('<i class="mdi mdi-account"></i> <a href="#" style="color: #fff; font-weight: bold">' + event.client.name + '</a>');
                    }

                    if (event.items !== undefined && Array.isArray(event.items)) {
                        event.items.forEach(item => {
                            str.push(item.service_name + ' ' + item.service_duration + 'мин/' + item.service_price);
                        });
                    }

                    return str.join('<br/>');
                };

                this.scheduler.templates.quick_info_content = function (start, end, event) {
                    let str = '<div>';

                    str += '<ul>' +
                        '<li>Статус: ' + self.getStatusName(event.status) + '</li>' +
                        '<li>Длительнось: 00:20 мин</li>' +
                        '<li>Сумма: 100500 руб.</li>' +
                        '</ul>';

                    if (event.client) {
                        str += 'Клиент <ul>' +
                            '<li>' + event.client.name + '</li>' +
                            '</ul>';
                    }

                    if (event.items !== undefined && Array.isArray(event.items)) {
                        str += 'Услуги ';

                        str += '<table class="uk-table uk-table-small uk-table-divider"><thead><tr>' +
                            '<th>Название</th><th>Длительность</th><th>Цена</th>' +
                            '</tr></thead>' +
                            '<tbody>';


                        event.items.forEach(item => {
                            str += '<tr>' +
                                '<td>' + item.service_name + '</td><td>' + item.service_duration + '</td><td>' + item.service_price + '</td>' +
                                '</tr>';
                        });

                        str += '</tbody></table>';
                    }
                    str += '</div>';

                    return str;
                };
            },
            // Инициализируем события
            initSchedulerEvents() {
                let self = this;

                this.scheduler.attachEvent("onViewChange", (new_mode, new_date) => {
                    let state = this.scheduler.getState();

                    this.loadData(this.salonId, this.userId, state.min_date, state.max_date);
                });

                this.scheduler.attachEvent("onEventCreated", (id, e) => {
                    this.scheduler.getEvent(id).isNew = true;
                    this.scheduler.updateEvent(id);
                });

                this.scheduler._click.buttons.edit = function (id) {
                    self.scheduler.showLightbox(id);
                };

                this.scheduler._click.buttons.delete = (id) => {
                    this.deleteAppointment(id);
                };

                // Если двигаем записи
                let startDateBeforeDrag, masterId;

                this.scheduler.attachEvent("onBeforeDrag", (id, mode, e) => {
                    let appointment = self.scheduler.getEvent(id),
                        state = this.scheduler.getState();

                    startDateBeforeDrag = this.dateFormat(appointment.start_date);
                    masterId = appointment.master_id;

                    if (state.mode === 'timeline') return true;

                    return this.masterId !== null;
                });

                this.scheduler.attachEvent("onDragEnd", (id, mode, e) => {
                    let appointment = this.scheduler.getEvent(id);

                    if (!appointment) return;

                    let startDate = this.dateFormat(appointment.start_date),
                        endDate = this.dateFormat(appointment.end_date);

                    // Если время или masterId изменился
                    if ((startDateBeforeDrag !== this.dateFormat(appointment.start_date) || (masterId !== appointment.master_id)) && !appointment.isNew) {
                        this.saveOnDragAppointment(appointment.id, appointment.master_id, startDate, endDate);
                    }
                    return true;
                });
            },
            addAppointment(appointment, isNew = false) {
                return this.scheduler.addEvent(this.createEvent(appointment, isNew));
            },
            createEvent(data, isNew = false) {
                return {
                    id: data.id,
                    salon_id: data.salon_id || null,
                    master_id: data.master_id || null,
                    client_id: data.client_id,
                    status: +data.status,
                    start_date: data.start_date,
                    end_date: data.end_date,
                    client: data.client || null,
                    items: data.items || [],
                    isNew: isNew
                }
            },
            deleteAllAppointmentForSchedule() {
                this.scheduler.getEvents().forEach(appointment => {
                    this.scheduler.deleteEvent(appointment.id);
                })
            },
            deleteAppointment(id) {
                this.$apollo.mutate({
                    mutation: gql`mutation ($id: ID!) {
                        appointmentDelete(id: $id)
                    }`,
                    variables: {
                        id
                    }
                }).then(({data}) => {
                    if (data.appointmentDelete) this.scheduler.deleteEvent(id);
                });
            },

            blockTimFromTimeline(mastersId, startDate, endDate) {
                this.scheduler.blockTime({
                    start_date: startDate,
                    end_date: endDate,
                    sections: {
                        timeline: mastersId
                    }
                });
            },
            unblockTimFromTimeline(masterSchedules) {
                masterSchedules.forEach(item => {
                    this.scheduler.deleteMarkedTimespan({
                        start_date: new Date(item.start_date),
                        end_date: new Date(item.end_date),
                        sections: {
                            timeline: item.master_id
                        }
                    });
                });
            },

            saveOnDragAppointment(id, masterId, startDate, endDate) {
                return this.$apollo.mutate({
                    mutation: gql`mutation (
                    $id: ID!,
                    $attributes: AppointmentUpdateInput!
                      ) {
                        appointmentUpdate(
                            id: $id,
                            attributes: $attributes
                          ) {
                                id, master_id, start_date, end_date,
                          }
                    }`,
                    variables: {
                        id: id,
                        attributes: {
                            master_id: masterId,
                            start_date: startDate,
                            end_date: endDate,
                        }
                    }
                });
            },

            createdAppointment(appointment) {
                this.addAppointment(appointment);
                this.scheduler.updateView();
                this.modalClose();
                this.clearAttributes();
            },
            updatedAppointment(appointment) {
                this.scheduler.updateEvent(this.addAppointment(appointment));
                this.scheduler.updateView();
                this.modalClose();
                this.clearAttributes();
            },

            /**
             * Возвращает массив значения id мастеров
             *
             * @return Array
             */
            getMastersId() {
                return this.masters.map(item => {
                    return item.id;
                });
            },

            /**
             * Устанавливает параметр query.masterId
             */
            setMasterId() {
                this.masterId = this.$route.query.master_id || null;
            },

            /**
             * Возвращает название статуса
             *
             * @return String
             */
            getStatusName(status) {
                return this.status.getStatusName(status);
            },

            /**
             * Форматирует дату для mysql
             *
             * @param date
             */
            dateFormat(date) {
                return dateFormat(date, 'yyyy-mm-dd HH:MM:ss')
            },

            // Modal and form
            modalOpen(appointment, scenario) {
                this.modal = true;
                this.scenario = scenario;
                this.setAttributesForAppointment(appointment);
                this.loadServicesData(appointment.master_id);
            },
            modalClose() {
                this.modal = false;
                if (this.currentAppointment && this.currentAppointment.isNew) {
                    this.scheduler.deleteEvent(this.currentAppointment.id);
                }
                this.scheduler.endLightbox(false);
            },

            onAddItem() {
                let index = _.findIndex(this.services, {id: this.serviceSelect}),
                    service = this.services[index];

                this.addItem(service.id, service.name, service.price, service.duration, 1, null);
            },
            addItems(items = []) {
                items.forEach(item => {
                    this.addItem(
                        item.service_id,
                        item.service_name,
                        item.service_price,
                        item.service_duration,
                        item.quantity,
                        null
                    )
                });
            },
            // Добавляет услугу в список услуг
            addItem(
                serviceId,
                serviceName,
                servicePrice,
                serviceDuration,
                quantity,
                discount
            ) {
                this.attributes.items.push({
                    service_id: serviceId,
                    service_name: serviceName,
                    service_price: servicePrice,
                    service_duration: serviceDuration,
                    quantity: quantity,
                    discount: discount
                });
            },
            deleteItem(index) {
                this.attributes.items.splice(index, 1);
            },

            setAttributesForAppointment(appointment) {
                this.clearAttributes();

                this.attributes.id = appointment.id || null;
                this.attributes.master_id = appointment.master_id;
                this.attributes.client_id = appointment.client_id || null;
                this.attributes.status = appointment.status || null;
                this.attributes.start_date = appointment.start_date;
                this.attributes.end_date = appointment.end_date;

                if (appointment.items !== undefined && Array.isArray(appointment.items)) this.addItems(appointment.items);
            },

            submit() {
                if (this.attributes.items.length === 0) {
                    alert('Нет услуг');
                    return;
                }

                if (!this.$refs.form.validate()) {
                    console.log(this.attributes);
                    return;
                }

                let gl = null;

                if (this.isScenarioCreate()) {
                    gl = gql`mutation (
                            $attributes: AppointmentCreateInput!
                      ) {
                        appointmentCreate(
                            attributes: $attributes
                          ) {
                                id, user_id, master_id, salon_id, client_id, status, start_date, end_date,
                                items {
                                  id, appointment_id, service_id, service_name, service_price, service_duration, quantity
                                },
                                client {id, surname, name, patronymic, date_birth}
                          }
                    }`
                } else if (this.isScenarioUpdate()) {
                    gl = gql`mutation (
                            $id: ID!,
                            $attributes: AppointmentUpdateInput!
                      ) {
                        appointmentUpdate(
                            id: $id,
                            attributes: $attributes
                          ) {
                                id, user_id, master_id, salon_id, client_id, status, start_date, end_date,
                                items {
                                  id, appointment_id, service_id, service_name, service_price, service_duration, quantity
                                },
                                client {id, surname, name, patronymic, date_birth}
                          }
                    }`
                }

                this.$apollo.mutate({
                    mutation: gl,
                    variables: {
                        id: this.attributes.id,
                        attributes: {
                            salon_id: this.salonId,
                            master_id: this.attributes.master_id,
                            client_id: this.attributes.client_id,
                            status: this.attributes.status,
                            start_date: this.attributes.start_date,
                            end_date: this.attributes.end_date,
                            items: this.attributes.items.map(item => {
                                return {service_id: item.service_id, quantity: item.quantity}
                            })
                        }
                    }
                }).then(({data}) => {
                    if (data.appointmentCreate || data.appointmentUpdate) this.$emit('save', data.appointmentCreate || data.appointmentUpdate);

                    if (this.isScenarioCreate()) {
                        this.createdAppointment(data.appointmentCreate);
                    }
                    if (this.isScenarioUpdate()) {
                        this.updatedAppointment(data.appointmentUpdate);
                    }
                });
            },

            clearAttributes() {
                this.attributes.master_id = null;
                this.attributes.client_id = null;
                this.attributes.status = null;
                this.attributes.start_date = null;
                this.attributes.end_date = null;
                this.attributes.items = [];
                this.services = [];
            },
            getStatusList() {
                let statuses = this.status.getStatusList(),
                    statusList = [];

                for (let status in statuses) {
                    statusList.push({value: +status, text: statuses[status]});
                }
                return statusList;
            },
            scenarioCreate() {
                this.scenario = SCENARIO_CREATE;
            },
            scenarioUpdate() {
                this.scenario = SCENARIO_UPDATE;
            },
            isScenarioCreate() {
                return this.scenario === SCENARIO_CREATE;
            },
            isScenarioUpdate() {
                return this.scenario === SCENARIO_UPDATE;
            }
        },
        filters: {
            formatDate(value) {
                var date = new Date(value);

                function format(value) {
                    return value < 10 ? '0' + value : value;
                }

                return format(date.getHours()) + ':' + format(date.getMinutes());
            },
            // Формаирует количество минут
            formatDuration(minute) {
                var seconds = minute * 60,
                    minutes = Math.floor(seconds / 60 % 60),
                    hours = Math.floor(seconds / 3600 % 24);

                function format(value) {
                    return value < 10 ? '0' + value : value;
                }

                return format(hours) + ':' + format(minutes);
            },
            // Форматирует число
            formatCurrency(value) {
                return new Intl.NumberFormat('ru-RU', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(value);
            }
        },

        watch: {
            '$route.query.master_id': function () {
                this.setMasterId();
                this.loadData();
            },
            '$route.params.id': function () {
                this.reload();
            }
        }
    }
</script>

<style>
    .dhx_scale_holder, .dhx_scale_holder_now {
        background-repeat: repeat;
    }
</style>