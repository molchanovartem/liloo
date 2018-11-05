<template>
    <div class="content-block p-40 content-block_shadow">
        <v-master-list :masters="masters" :salonId="salonId"/>

        <div id="scheduler_here" class="dhx_cal_container uk-margin-top" style='width:100%; height:1000px;'>
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
                    <v-form ref="form" :salonId="salonId" @created="onCreated" @updated="onUpdated"/>
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
    import VMasterList from './components/MasterList.vue';
    import VForm from './Form.vue';

    export default {
        name: "SalonAppointment",
        props: {
            salonId: {
                type: String,
                required: true
            }
        },
        components: {
            VMasterList, VForm
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
                masters: [],
                currentAppointment: null,
                config: {
                    mode: 'week'
                },
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
                        }`,
                        variables: {
                            salonId: self.salonId
                        }
                    }).then(({data}) => {
                        self.masters = Array.from(data.salon.masters);

                        resolve(true)
                    }).catch(({error}) => {
                        reject(error);
                    });
                });
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
                            appointments(filter: {
                                salon_id: $salonId,
                                master_id: $masterId
                                start_date: $startDate,
                                end_date: $endDate
                            }) {
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
                    this.deleteAllAppointment();

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
                        this.formLoad({
                            start_date: this.dateFormat(appointment.start_date),
                            end_date: this.dateFormat(appointment.end_date),
                            master_id: appointment.master_id || this.masterId
                        }, 'create');
                    } else {
                        this.loadAppointment(id).then(({data}) => {
                            if (data.appointment) {
                                this.formLoad(data.appointment, 'update');
                            }
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

            onCreated(appointment) {
                this.addAppointment(appointment);
                this.scheduler.updateView();
                this.modalClose();
            },
            onUpdated(appointment) {
                this.scheduler.updateEvent(this.addAppointment(appointment));
                this.scheduler.updateView();
                this.modalClose();
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