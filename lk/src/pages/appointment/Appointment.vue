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

        <div :id="appointmentModalFormId" @hidden="onHiddenModal" class="uk-modal-container" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <v-appointment-form
                        @createdAppointment="onCreatedAppointment"
                        @updatedAppointment="onUpdatedAppointment"
                />
            </div>
        </div>
    </div>
</template>

<script>
/*    import 'dhtmlx-scheduler/codebase/dhtmlxscheduler_flat.css';
    import 'dhtmlx-scheduler/codebase/dhtmlxscheduler.js';
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_quick_info.js';
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_limit.js';*/
    import UIkit from 'uikit/dist/js/uikit';

    import gql from 'graphql-tag';
    import dateFormat from 'dateformat';
    import Status from './components/Status';

    import VAppointmentForm from './components/AppointmentForm.vue';

    export default {
        name: "Appointment",
        mounted() {
            // Инициализируем календарь
            this.initScheduler();
        },
        destroyed() {
            delete this.scheduler;
        },
        components: {
            VAppointmentForm
        },
        data() {
            return {
                appointmentModalFormId: 'appointment_modal_form',
                status: new Status,
                config: {
                    mode: 'week'
                }
            }
        },
        methods: {
            onHiddenModal() {
                this.scheduler.endLightbox(false);
            },

            initScheduler() {
                this.scheduler = Scheduler.getSchedulerInstance();

                this.initSchedulerConfig();
                this.initSchedulerTemplates();
                this.initSchedulerEvents();

                this.scheduler.init('scheduler_here', new Date, this.config.mode);
            },
            // Конфигурация
            initSchedulerConfig() {
                let self = this;

                this.scheduler.config.api_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.xml_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.details_on_dblclick = false;
                this.scheduler.config.details_on_create = true;
                this.scheduler.config.drag_create = false;
                this.scheduler.config.drag_resize = false;
                this.scheduler.config.quick_info_detached = true;

                this.scheduler.config.icons_select = ['icon_edit', 'icon_delete'];

                this.scheduler.showLightbox = (id) => {
                    let event = this.scheduler.getEvent(id);

                    UIkit.modal('#' + this.appointmentModalFormId).show();
                    if (event.isNew !== undefined && event.isNew) {
                        this.$emit('createAppointment', {
                            start_date: this.dateFormat(event.start_date),
                            end_date: this.dateFormat(event.end_date),
                        });
                    } else {
                        this.loadAppointment(id).then(({data}) => {
                            this.$emit('updateAppointment', data.appointment);
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

                    if (event.client !== null) {
                        str.push('<i class="mdi mdi-account"></i> <a href="#" style="color: #fff; font-weight: bold">' + event.client.name + '</a>');
                    }

                    event.items.forEach(item => {
                        str.push(item.service_name + ' ' + item.service_duration + 'мин/' + item.service_price);
                    });

                    return str.join('<br/>');
                };

                this.scheduler.templates.quick_info_content = function (start, end, ev) {
                    let str = '<div>';

                    str += '<ul>' +
                        '<li>Статус: ' + self.getStatusName(ev.status) + '</li>' +
                        '<li>Длительнось: 00:20 мин</li>' +
                        '<li>Сумма: 100500 руб.</li>' +
                        '</ul>';

                    if (ev.client !== null) {
                        str += 'Клиент <ul>' +
                            '<li>' + ev.client.name + '</li>' +
                            '</ul>';
                    }

                    str += 'Услуги ';

                    str += '<table class="uk-table uk-table-small uk-table-divider"><thead><tr>' +
                        '<th>Название</th><th>Длительность</th><th>Цена</th>' +
                        '</tr></thead>' +
                        '<tbody>';

                    ev.items.forEach(item => {
                        str += '<tr>' +
                            '<td>' + item.service_name + '</td><td>' + item.service_duration + '</td><td>' + item.service_price + '</td>' +
                            '</tr>';
                    });

                    str += '</tbody></table></div>';

                    return str;
                };
            },
            // Инициализируем события
            initSchedulerEvents() {
                let self = this;

                this.scheduler.attachEvent("onViewChange", (new_mode, new_date) => {
                    let state = this.scheduler.getState();

                    this.loadData(this.dateFormat(state.min_date), this.dateFormat(state.max_date)).then(({data}) => {
                        this.deleteAllAppointmentForSchedule();

                        Array.from(data.appointments).forEach(appointment => {
                            this.addAppointment(appointment);
                        });

                        this.scheduler.deleteMarkedTimespan();
                        this.scheduler.blockTime({
                            start_date: state.min_date,
                            end_date: state.max_date
                        });

                        Array.from(data.userSchedules).forEach(item => {
                            this.scheduler.deleteMarkedTimespan({
                                start_date: new Date(item.start_date),
                                end_date: new Date(item.end_date)
                            });
                        });
                        this.scheduler.updateView();
                    });
                });

                // Обработчик если нажали на пустое место в журнале
                this.scheduler.attachEvent('onEmptyClick', (date, e) => {
                    this.scheduler.deleteEvent(this.scheduler.addEventNow({
                        start_date: new Date(date),
                        end_date: new Date(date),
                        client: null,
                        items: [],
                        isNew: true
                    }), true);
                    return true;
                });

                this.scheduler._click.buttons.edit = function (id) {
                    self.scheduler.showLightbox(id);
                };

                let startDateBeforeDrag;

                this.scheduler.attachEvent("onBeforeDrag", (id, mode, e) => {
                    let event = self.scheduler.getEvent(id);

                    startDateBeforeDrag = this.dateFormat(event.start_date);
                    return true;
                });

                this.scheduler.attachEvent("onDragEnd", (id, mode, e) => {
                    let event = this.scheduler.getEvent(id);

                    if (!event) return;

                    let startDate = this.dateFormat(event.start_date),
                        endDate = this.dateFormat(event.end_date);

                    if ((startDateBeforeDrag !== this.dateFormat(event.start_date)) &&
                        !(event.isNew !== undefined && event.isNew)) {
                        this.saveOnDragAppointment(event.id, startDate, endDate);
                    }
                    return true;
                });
            },
            // Загружаем эвенты
            loadData(startDate, endDate) {
                return this.$apollo.query({
                    query: gql`query (
                        $startDate: DateTime,
                        $endDate: DateTime,
                        $userId: ID!
                    ) {
                        appointments(
                            start_date: $startDate,
                            end_date: $endDate,
                            user_id: $userId
                         ) {
                            id, user_id, client_id, owner_id, status, start_date, end_date,
                            items {id, appointment_id, service_id, service_name, service_price, service_duration, quantity},
                            client {id, surname, name, patronymic, date_birth}
                        },
                        userSchedules(user_id: $userId, start_date: $startDate, end_date: $endDate) {
                            id, user_id, type, start_date, end_date
                        }
                    }`,
                    variables: {
                        startDate: startDate,
                        endDate: endDate,
                        userId: 1
                    }
                });
            },
            loadAppointment(id) {
                return this.$apollo.query({
                    query: gql`query ($id: ID!) {
                            appointment(id: $id) {
                                id, client_id, status, start_date, end_date,
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
            addAppointment(appointment) {
                return this.scheduler.addEvent({
                    id: appointment.id,
                    client_id: appointment.client_id,
                    status: +appointment.status,
                    start_date: appointment.start_date,
                    end_date: appointment.end_date,
                    client: appointment.client || null,
                    items: appointment.items || []
                });
            },
            deleteAllAppointmentForSchedule() {
                this.scheduler.getEvents().forEach(appointment => {
                    this.scheduler.deleteEvent(appointment.id);
                })
            },

            saveOnDragAppointment(id, startDate, endDate) {
                return this.$apollo.mutate({
                    mutation: gql`mutation (
                    $id: ID!,
                    $startDate: DateTime,
                    $endDate: DateTime,
                      ) {
                        appointmentUpdate(
                            id: $id,
                            attributes: {
                                start_date: $startDate,
                                end_date: $endDate
                            }
                          ) {
                                id, start_date, end_date,
                          }
                    }`,
                    variables: {
                        id: id,
                        startDate: startDate,
                        endDate: endDate,
                    }
                });
            },

            onCreatedAppointment(appointment) {
                this.addAppointment(appointment);
                UIkit.modal('#' + this.appointmentModalFormId).hide();
            },
            onUpdatedAppointment(appointment) {
                this.scheduler.updateEvent(this.addAppointment(appointment));
                UIkit.modal('#' + this.appointmentModalFormId).hide();
            },
            getStatusName(status) {
                return this.status.getStatusName(status);
            },
            dateFormat(date) {
                return dateFormat(date, 'yyyy-mm-dd HH:MM:ss')
            }
        },
    }
</script>