<template>
    <div class="content-block p-40 content-block_shadow">
        <h1>График работы</h1>
        <v-master v-if="masterId" :salonId=" salonId" :masterId="masterId"/>

        <div>
            <div id="masterScheduleList" class="dhx_cal_container" style='width:100%; height:1000px;'>
                <div class="dhx_cal_navline">
                    <div class="dhx_cal_prev_button">&nbsp;</div>
                    <div class="dhx_cal_next_button">&nbsp;</div>
                    <div class="dhx_cal_today_button"></div>
                    <div class="dhx_cal_date"></div>
                </div>
                <div class="dhx_cal_header"></div>
                <div class="dhx_cal_data"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import 'dhtmlx-scheduler/codebase/dhtmlxscheduler_flat.css';
    import 'dhtmlx-scheduler/codebase/dhtmlxscheduler.js';
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_timeline';

    import gql from 'graphql-tag';
    import commonMixin from './commonMixin';
    import VMaster from './MasterSchedule.vue';

    export default {
        name: "MasterSchedule",
        props: {
            salonId: {
                type: String,
                required: true
            }
        },
        mixins: [commonMixin],
        components: {
            VMaster
        },
        mounted() {
            this.loadMasters().then(resolve => {
                this.initScheduler();
            });
        },
        destroyed() {
            delete this.scheduler;
        },
        data() {
            return {
                items: [],
                masters: [],
                masterId: null
            }
        },
        methods: {
            loadMasters() {
                let self = this;

                return new Promise((resolve, reject) => {
                    self.$apollo.query({
                        query: gql`query ($salonId: ID!) {
                            salon(id: $salonId) {
                              id, name, masters {id, surname, name, patronymic}
                             }
                        }`,
                        variables: {salonId: this.salonId}
                    }).then(({data}) => {
                        if (data.salon) {
                            this.masters = data.salon.masters;
                            resolve(data);
                        }
                    });
                });
            },
            initScheduler() {
                this.scheduler = Scheduler.getSchedulerInstance();

                this.initSchedulerConfig();
                this.initSchedulerEvents();
                this.scheduler.init('masterScheduleList', new Date(), "matrix");
            },
            initSchedulerConfig() {
                this.scheduler.config.api_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.xml_date = "%Y-%m-%d %H:%i";
                this.scheduler.locale.labels.matrix_tab = "Matrix";
                this.scheduler.locale.labels.section_custom = "Section";
                this.scheduler.config.details_on_create = false;
                this.scheduler.config.details_on_dblclick = false;
                this.scheduler.config.xml_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.multi_day = false;
                this.scheduler.xy.scale_height = 35;

                this.scheduler.createTimelineView({
                    name: "matrix",
                    x_unit: "day",
                    x_date: "%d %D",
                    x_step: 1,
                    x_size: 7,
                    dx: 180,
                    section_autoheight: false,
                    y_unit: this.masters.map(item => {
                        return {key: item.id, label: item.name}
                    }),
                    y_property: "master_id"
                });

                this.scheduler.templates.matrix_cell_value = (evs, date) => {
                    if (!evs) return '';

                    let startDate, endDate;

                    if (evs.length > 1) {
                        startDate = evs[0].start_date;
                        endDate = evs[evs.length - 1].end_date;
                    } else {
                        startDate = evs[0].start_date;
                        endDate = evs[0].end_date;
                    }
                    return this.formatTime(startDate, endDate);
                };

                this.scheduler.templates.matrix_scale_label = (key, label, section) => {
                     return '<img src="https://getuikit.com/docs/images/avatar.jpg" width="40px" class="uk-border-circle"/>' + label;
                };

                this.scheduler.date['matrix' + '_start'] = this.scheduler.date.week_start;

                this.scheduler.templates.matrix_tooltip =  function () {};
            },
            initSchedulerEvents() {
                this.scheduler.attachEvent("onViewChange", (new_mode, new_date) => {
                    this.loadData();
                });

                // Переопределяем функцию, иначе появляется tooltip при наведении
                this.scheduler._init_matrix_tooltip = () => {};

                this.scheduler.attachEvent("onYScaleClick", (index, section,e) => {
                    this.$router.push({name: 'masterScheduleManager', params: {masterId: section.key}});
                });
            },

            loadData() {
                this.scheduler.getEvents().forEach(item => {
                    this.scheduler.deleteEvent(item.id);
                });

                let state = this.scheduler.getState(),
                    startDate = state.min_date,
                    endDate = state.max_date;

                this.$apollo.query({
                    query: gql`query ($salonId: ID!, $startDate: DateTime, $endDate: DateTime) {
                        masterSchedules(salon_id: $salonId, start_date: $startDate, end_date: $endDate) {
                            id, type, master_id, start_date, end_date
                        }
                    }`,
                    variables: {
                        salonId: this.salonId,
                        startDate: this.dateFormat(startDate),
                        endDate: this.dateFormat(endDate)
                    }
                }).then(({data}) => {
                    if (data.masterSchedules) {
                        let events = [];
                        Array.from(data.masterSchedules).forEach(item => {
                            events.push({
                                id: item.id,
                                type: item.type,
                                master_id: item.master_id,
                                start_date: item.start_date,
                                end_date: item.end_date,
                            });
                        });

                        this.scheduler.parse(events, 'json')
                    }
                });
            },
            addEvent(event) {
                return this.scheduler.addEvent({
                    id: event.id,
                    type: event.type,
                    master_id: event.master_id,
                    start_date: event.start_date,
                    end_date: event.end_date,
                });
            },
        }
    }
</script>