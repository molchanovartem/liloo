<template>
    <div class="content-block p-40 content-block_shadow">
        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:1000px;'>
            <div class="dhx_cal_navline">
                <div class="dhx_cal_prev_button">&nbsp;</div>
                <div class="dhx_cal_next_button">&nbsp;</div>
                <div class="dhx_cal_today_button"></div>
                <div class="dhx_cal_date"></div>
                <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
                <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
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
                    <v-form ref="form" @created="onCreated" @updated="onUpdated"/>
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
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_collision'; // Предотвращение двойное событие во временном интервале
    import 'dhtmlx-scheduler/codebase/locale/locale_ru';

    import gql from 'graphql-tag';
    import dateFormat from 'dateformat';
    import {EVENT_SAVE, EVENT_DELETE} from "../../js/eventCollection";
    import {APPOINTMENT_STATUS_NOT_COME, APPOINTMENT_STATUS_CANCELED} from "./status";
    import VForm from './Form.vue';

    export default {
        name: "Appointment",
        components: {
            VForm
        },
        created() {
            this.scheduler = Scheduler.getSchedulerInstance();

            this.$on(EVENT_SAVE, () => {
                this.$notification.save();
            });

            this.$on(EVENT_DELETE, () => {
                this.$notification.delete();
            });
        },
        mounted() {
            this.initScheduler();
        },
        destroyed() {
            delete this.scheduler;
        },
        data() {
            return {
                modal: false,
                currentAppointment: null,
                config: {
                    mode: 'week'
                },
            }
        },
        methods: {
            reload() {
                this.initScheduler();
            },

            /**
             * Загружает записи, время работы сотрудника
             */
            loadData() {
                let state = this.scheduler.getState(),
                    startDate = state.min_date,
                    endDate = state.max_date;

                this.$apollo.query({
                    query: gql`query ($startDate: DateTime,$endDate: DateTime) {
                            appointments(filter: {start_date: $startDate, end_date: $endDate}, limit: -1) {
                                    id, salon_id, user_id, master_id, client_id, owner_id, status, start_date, end_date,
                                    items {id, appointment_id, service_id, service_name, service_price, service_duration, quantity},
                                    client {id, surname, name, patronymic, date_birth},
                            },
                            userSchedules(start_date: $startDate, end_date: $endDate) {
                                id, type, start_date, end_date
                            }
                        }`,
                    variables: {
                        startDate: this.dateFormat(startDate),
                        endDate: this.dateFormat(endDate)
                    }
                }).then(({data}) => {
                    this.deleteAllAppointment();

                    let appointments = [];
                    Array.from(data.appointments).forEach(appointment => {
                        appointments.push(this.createEvent(appointment));
                    });
                    this.scheduler.parse(appointments, 'json');

                    this.scheduler.deleteMarkedTimespan();

                    this.scheduler.blockTime({
                        start_date: new Date(startDate),
                        end_date: new Date(endDate),
                    });

                    Array.from(data.userSchedules).forEach(item => {
                        this.scheduler.deleteMarkedTimespan({
                            start_date: new Date(item.start_date),
                            end_date: new Date(item.end_date),
                        });
                    });

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
                                id, user_id, client_id, status, start_date, end_date,
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
                this.scheduler.config.icons_select = ['icon_edit'];
                this.scheduler.xy.scale_height = 35;

                this.scheduler.locale.labels.timeline_tab = "Timeline";

                this.scheduler.showLightbox = (id) => {
                    let appointment = this.scheduler.getEvent(id);

                    this.currentAppointment = appointment;

                    if (appointment.isNew) {
                        this.formLoad({
                            start_date: this.dateFormat(appointment.start_date),
                            end_date: this.dateFormat(appointment.end_date)
                        }, 'create');
                    } else {
                        this.loadAppointment(id).then(({data}) => {
                            if (data.appointment) {
                                this.formLoad(data.appointment, 'update');
                            }
                        });
                    }
                };
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
                        '<li>Статус: ' + event.status + '</li>' +
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

                this.scheduler.attachEvent("onClick", (id) => {
                    var event = this.scheduler.getEvent(id);

                    //if (event.important)
                    this.scheduler.config.icons_select = ["icon_details"];
                    //else
                    //this.scheduler.config.icons_select = ["icon_details", "icon_delete"];

                    return true;
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
                let startDateBeforeDrag;

                this.scheduler.attachEvent("onBeforeDrag", (id, mode, e) => {
                    let appointment = self.scheduler.getEvent(id);

                    startDateBeforeDrag = this.dateFormat(appointment.start_date);

                    return true;
                });

                this.scheduler.attachEvent("onDragEnd", (id, mode, e) => {
                    let appointment = this.scheduler.getEvent(id);

                    if (!appointment) return;

                    let startDate = this.dateFormat(appointment.start_date),
                        endDate = this.dateFormat(appointment.end_date);

                    // Если время или masterId изменился
                    if ((startDateBeforeDrag !== this.dateFormat(appointment.start_date)) && !appointment.isNew) {
                        this.saveOnDragAppointment(appointment.id, startDate, endDate).then(({data}) => {
                            this.$emit(EVENT_SAVE, data);
                        });
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
                    client_id: data.client_id,
                    status: +data.status,
                    start_date: data.start_date,
                    end_date: data.end_date,
                    client: data.client || null,
                    items: data.items || [],
                    isNew: isNew
                }
            },
            deleteAllAppointment() {
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
                    if (data.appointmentDelete) {
                        this.scheduler.deleteEvent(id);

                        this.$emit(EVENT_DELETE, id);
                    }
                });
            },

            saveOnDragAppointment(id, startDate, endDate) {
                return this.$apollo.mutate({
                    mutation: gql`mutation ($id: ID!, $attributes: AppointmentUpdateInput!) {
                        appointmentUpdate(id: $id, attributes: $attributes) {
                                id, master_id, start_date, end_date,
                        }
                    }`,
                    variables: {
                        id: id,
                        attributes: {
                            start_date: startDate,
                            end_date: endDate,
                        }
                    }
                });
            },

            onCreated(appointment) {
                if (+appointment.status !== APPOINTMENT_STATUS_NOT_COME && +appointment.status !== APPOINTMENT_STATUS_CANCELED) {
                    this.addAppointment(appointment);
                    //this.scheduler.updateView();
                    this.loadData();
                }

                this.modalClose();
            },
            onUpdated(appointment) {
                if (+appointment.status === APPOINTMENT_STATUS_NOT_COME || +appointment.status === APPOINTMENT_STATUS_CANCELED) {
                    this.scheduler.deleteEvent(appointment.id);
                } else {
                    this.scheduler.updateEvent(this.addAppointment(appointment));
                }
                this.scheduler.updateView();
                this.modalClose();
            },

            /**
             * Форматирует дату для mysql
             *
             * @param date
             */
            dateFormat(date) {
                return dateFormat(date, 'yyyy-mm-dd HH:MM:ss')
            },

            formLoad(attributes, scenario) {
                if (scenario === 'create') this.$refs.form.scenarioCreate();
                else this.$refs.form.scenarioUpdate();

                this.$refs.form.setAttributes(attributes);
                this.$refs.form.loadData();
                this.modal = true;
            },

            modalClose() {
                this.modal = false;
                this.$refs.form.clearData();

                if (this.currentAppointment && this.currentAppointment.isNew) {
                    this.scheduler.deleteEvent(this.currentAppointment.id);
                }
                this.scheduler.endLightbox(false);
            },
        },
    }
</script>

<style>
    .dhx_scale_holder, .dhx_scale_holder_now {
        background-repeat: repeat;
    }
</style>