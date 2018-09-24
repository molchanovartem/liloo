<template>
    <div class="content-block p-40 content-block_shadow">
        <!--<ul>@todo-->
            <!--<li>event можно перенести за график, время не урезается</li>-->
            <!--<li>event каскадность</li>-->
            <!--<li>локализация</li>-->
        <!--</ul>-->
        <v-master v-if="masterId" :salonId=" salonId" :masterId="masterId" @save="onMasterScheduleSave"/>

        <div>
            <div id="masterScheduleManager" class="dhx_cal_container" style='width:100%; height:1000px;'>
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
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_daytimeline.js';

    import gql from 'graphql-tag';
    import commonMixin from './commonMixin';
    import VMaster from './MasterSchedule.vue';

    export default {
        name: "MasterSchedule",
        props: {
            salonId: {
                type: String,
                required: true
            },
            masterId: {
                type: String,
                required: true
            }
        },
        mixins: [commonMixin],
        components: {
            VMaster
        },
        mounted() {
            this.initScheduler();
        },
        destroyed() {
            delete this.scheduler;
        },
        methods: {
            initScheduler() {
                this.scheduler = Scheduler.getSchedulerInstance();

                this.initSchedulerConfig();
                this.initSchedulerEvents();

                this.scheduler.init('masterScheduleManager', new Date(), "timeline");
            },
            initSchedulerConfig() {
                this.scheduler.locale.labels.timeline_tab = "Timeline";
                this.scheduler.locale.labels.section_custom = "Section";
                this.scheduler.config.details_on_dblclick = false;
                this.scheduler.config.api_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.xml_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.dblclick_create = false;
                this.scheduler.config.preserve_length = true;
                this.scheduler.xy.scale_height = 35;

                var viewName = 'timeline';
                this.scheduler.createTimelineView({
                    name: viewName,
                    x_unit: "hour",
                    x_date: "%H:%i",
                    x_step: 1,
                    x_size: 9,
                    x_start: 9,
                    render: "days",
                    days: 18,
                    event_dy: 'full',
                });

                this.scheduler.date['add_' + viewName] = (date, step) => {
                    if (step > 0) {
                        step = 1;
                    } else if (step < 0) {
                        step = -1;
                    }
                    return this.scheduler.date.add(date, step, "month")
                };

                this.scheduler.date[viewName + "_start"] = (date) => {
                    var view = this.scheduler.matrix.timeline;
                    date = this.scheduler.date.month_start(date);
                    date = this.scheduler.date.add(date, view.x_step * view.x_start, view.x_unit);
                    return date;
                };

                this.scheduler.templates.event_bar_text = (start,end,event) => {
                    return this.formatTime(start, end);
                };
            },
            initSchedulerEvents() {
                var viewName = 'timeline';

                this.scheduler.showLightbox = function () {};

                this.scheduler.attachEvent("onYScaleClick", (index, section, e) => {
                    if (this.scheduler.getState().mode === viewName) {
                        this.scheduler.setCurrentView(new Date(section.key), "day");
                    }
                });

                this.scheduler._click.buttons.delete = (id) => {
                    if (confirm('Удалить!')) {
                        this.deleteEvent(id);
                    }
                };

                let changeDate = null;
                this.scheduler.attachEvent("onBeforeDrag", (id, mode, e) => {
                    let event = this.scheduler.getEvent(id);

                    if (event) changeDate = event.start_date;
                    return true;
                });

                this.scheduler.attachEvent("onDragEnd", (id, mode, e) => {
                    let event = this.scheduler.getEvent(id);

                    if (+new Date(changeDate) === +new Date(event.start_date)) return;

                    event.isNew = event.isNew == false ? false : true;

                    if (event.isNew) {
                        this.createEvent(event);
                        this.scheduler.deleteEvent(id);
                    } else {
                        this.updateEvent(event);
                    }
                });

                this.scheduler.attachEvent("onBeforeViewChange", (old_mode, old_date, mode, date) => {
                    var year = date.getFullYear();
                    var month = (date.getMonth() + 1);
                    var d = new Date(year, month, 0);

                    this.scheduler.matrix[viewName].days = d.getDate();//numbers of day in month;

                    return true;
                });

                this.scheduler.attachEvent("onViewChange", (new_mode, new_date) => {
                    this.loadData();
                });
            },

            loadData() {
                let state = this.scheduler.getState(),
                    startDate = state.min_date,
                    endDate = state.max_date;

                this.scheduler.getEvents().forEach(item => {
                    this.scheduler.deleteEvent(item.id);
                });

                this.$apollo.query({
                    query: gql`query ($salonId: ID!, $masterId: ID!, $startDate: DateTime, $endDate: DateTime) {
                        masterSchedules(
                            salon_id: $salonId,
                            master_id: $masterId,
                            start_date: $startDate,
                            end_date: $endDate
                         ) {
                            id, type, start_date, end_date
                        }
                    }`,
                    variables: {
                        salonId: this.salonId,
                        masterId: this.masterId,
                        startDate: this.dateFormat(startDate),
                        endDate: this.dateFormat(endDate)
                    }
                }).then(({data}) => {
                    if (data.masterSchedules) {
                        let events = [];
                        Array.from(data.masterSchedules).forEach(item => {
                            events.push({
                                id: item.id,
                                start_date: item.start_date,
                                end_date: item.end_date,
                                isNew: false
                            });
                        });

                        this.scheduler.parse(events, 'json');
                    }
                });
            },
            addEvent(event) {
                return this.scheduler.addEvent({
                    id: event.id,
                    type: event.type,
                    start_date: event.start_date,
                    end_date: event.end_date,
                    isNew: false
                });
            },
            createEvent(event) {
                this.$apollo.mutate({
                    mutation: gql`mutation ($attributes: MasterScheduleCreateInput!) {
                        masterScheduleCreate(attributes: $attributes) {
                            id, master_id, salon_id, type, start_date, end_date
                        }
                    }`,
                    variables: {
                        attributes: {
                            master_id: this.masterId,
                            salon_id: this.salonId,
                            type: 1,
                            start_date: this.dateFormat(event.start_date),
                            end_date: this.dateFormat(event.end_date)
                        }
                    },
                }).then(({data}) => {
                    if (data.masterScheduleCreate) {
                        this.$emit('save');

                        this.addEvent(data.masterScheduleCreate);
                    }
                });
            },
            updateEvent(event) {
                this.$apollo.mutate({
                    mutation: gql`mutation (
                            $id: ID!,
                            $attributes: MasterScheduleUpdateInput!
                        ) {
                        masterScheduleUpdate(id: $id, attributes: $attributes) {
                            id, master_id, type, start_date, end_date
                        }
                    }`,
                    variables: {
                        id: event.id,
                        attributes: {
                            start_date: this.dateFormat(event.start_date),
                            end_date: this.dateFormat(event.end_date)
                        }
                    }
                }).then(({data}) => {
                    if (data.masterScheduleUpdate) {
                        this.$emit('save');

                        this.scheduler.updateEvent(this.addEvent(data.masterScheduleUpdate));
                    }
                });
            },
            deleteEvent(id) {
                this.$apollo.mutate({
                    mutation: gql`mutation ($id: ID!) {
                        masterScheduleDelete(id: $id)
                    }`,
                    variables: {id: id}
                }).then(({data}) => {
                    if (data.masterScheduleDelete) {
                        this.$emit('delete');

                        this.scheduler.deleteEvent(id);
                    }
                });
            },
            onMasterScheduleSave() {
                this.loadData();
            }
        }
    }
</script>