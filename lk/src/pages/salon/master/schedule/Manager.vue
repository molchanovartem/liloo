<template>
    <div class="content-block p-40 content-block_shadow">
        <ul>@todo
            <li>Добавить отображение, список мастеров в одном графике</li>
        </ul>

        <h1>График работы</h1>
        <v-master-list :salonId="salonId"/>

        <v-master v-if="masterId" :salonId=" salonId" :masterId="masterId"/>

        <div>
            <div id="timeline" class="dhx_cal_container" style='width:100%; height:1000px;'>
                <div class="dhx_cal_navline">
                    <div class="dhx_cal_prev_button">&nbsp;</div>
                    <div class="dhx_cal_next_button">&nbsp;</div>
                    <div class="dhx_cal_today_button"></div>
                    <div class="dhx_cal_date"></div>
                    <div class="dhx_cal_tab" name="timeline_tab" style="right:280px;"></div>
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
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_limit.js';
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_daytimeline.js';

    import gql from 'graphql-tag';
    import dateFormat from 'dateformat';
    import VMasterList from '../../components/MasterList.vue';
    import VMaster from './MasterSchedule.vue';

    export default {
        name: "MasterSchedule",
        props: {
            salonId: {
                type: String,
                required: true
            }
        },
        components: {
            VMasterList, VMaster
        },
        mounted() {
            this.initScheduler();
            //this.changeMasterId();
        },
        destroyed() {
            delete this.scheduler;
        },
        data() {
            return {
                items: [],
                masterId: null
            }
        },
        methods: {
            initScheduler() {
                this.scheduler = Scheduler.getSchedulerInstance();

                this.scheduler.locale.labels.matrix_tab = "Matrix";
                this.scheduler.locale.labels.section_custom = "Section";
                this.scheduler.config.details_on_create = true;
                this.scheduler.config.details_on_dblclick = true;
                this.scheduler.config.xml_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.multi_day = false;

                var sections = [
                    {key: 1, label: "Section A"},
                    {key: 2, label: "Section B"},
                    {key: 3, label: "Section C"},
                    {key: 4, label: "Section D"}
                ];

                this.scheduler.createTimelineView({
                    name: "matrix",
                    x_unit: "day",
                    x_date: "%d %M",
                    x_step: 1,
                    x_size: 7,
                    y_unit: sections,
                    y_property: "section_id"
                });

                /*
                this.scheduler.templates.matrix_cell_value = function (evs, date) {
                    let startDate, endDate;

                    if (evs) {
                        if (evs.length > 1) {
                            let countEvent = evs.length;
                            startDate = evs[0].start_date;
                            endDate = evs[evs.length - 1].end_date;
                        } else {
                            startDate = evs[0].start_date;
                            endDate = evs[0].end_date;
                        }
                    }

                    return evs ? startDate.getHours() + ' - ' + endDate.getHours() : '';
                };
                */

                /*
                this.scheduler.attachEvent("onBeforeViewChange", function(old_mode,old_date,mode,date){

                    var year = date.getFullYear();
                    var month= (date.getMonth() + 1);
                    var d = new Date(year, month, 0);
                    var days = d.getDate();//numbers of day in month
                    this.scheduler.matrix['matrix'].x_size = days;
                    return true;
                });
                this.scheduler.date['add_' + 'matrix'] = function(date, step){
                    if(step > 0){
                        step = 1;
                    }else if(step < 0){
                        step = -1;
                    }
                    return this.scheduler.date.add(date, step, "month")
                };
                */
                this.scheduler.date['matrix' + '_start'] = this.scheduler.date.week_start;

                this.scheduler.init('timeline', new Date(), "matrix");

                //this.scheduler.load("./data/units.json", "json");
                this.scheduler.parse([
                    {
                        "id": "2",
                        "start_date": "2017-06-30 12:00:00",
                        "end_date": "2017-06-30 14:00:00",
                        "text": "Section A test",
                        "section_id": "1"
                    },
                    {
                        "id": "213132",
                        "start_date": "2017-06-30 15:00:00",
                        "end_date": "2017-06-30 17:00:00",
                        "text": "Section A test",
                        "section_id": "1"
                    },
                    {
                        "id": "3",
                        "start_date": "2017-06-30 10:00:00",
                        "end_date": "2017-06-30 11:00:00",
                        "text": "Section B test",
                        "section_id": "2"
                    },
                    {
                        "id": "3",
                        "start_date": "2017-06-1 10:00:00",
                        "end_date": "2017-07-30 11:00:00",
                        "text": "Section B test",
                        "section_id": "2"
                    },
                    {
                        "id": "4",
                        "start_date": "2017-06-30 16:00:00",
                        "end_date": "2017-06-30 18:00:00",
                        "text": "Section C test",
                        "section_id": "3"
                    },
                    {
                        "id": "5",
                        "start_date": "2017-06-30 10:00:00",
                        "end_date": "2017-06-30 15:00:00",
                        "text": "Section D test",
                        "section_id": "4"
                    },
                    {
                        "id": "6",
                        "start_date": "2017-06-29 12:00:00",
                        "end_date": "2017-06-29 14:00:00",
                        "text": "day before test",
                        "section_id": "1"
                    },
                    {
                        "id": "7",
                        "start_date": "2017-07-1 12:00:00",
                        "end_date": "2017-07-1 14:00:00",
                        "text": "day after test",
                        "section_id": "1"
                    }
                ], 'json');

                //this.initSchedulerEvents();
                //this.initSchedulerConfig();

                //this.scheduler.init('timeline', new Date(), "timeline");
            },
            initSchedulerConfig() {
                this.scheduler.locale.labels.timeline_tab = "Timeline";
                this.scheduler.locale.labels.section_custom = "Section";
                this.scheduler.config.details_on_dblclick = false;
                this.scheduler.config.api_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.xml_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.dblclick_create = false;

                var viewName = 'timeline';
                this.scheduler.createTimelineView({
                    name: viewName,
                    x_unit: "minute",
                    x_date: "%H:%i",
                    x_step: 30,
                    x_size: 24,
                    x_start: 16,
                    render: "days",
                    days: 18
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
            },
            initSchedulerEvents() {
                var viewName = 'timeline';

                this.scheduler.attachEvent("onYScaleClick", (index, section, e) => {
                    if (this.scheduler.getState().mode == viewName) {
                        this.scheduler.setCurrentView(new Date(section.key), "day");
                    }
                });

                this.scheduler._click.buttons.delete = (id) => {
                    if (confirm('Удалить!')) {
                        this.deleteEvent(id);
                    }
                };

                this.scheduler.attachEvent("onDragEnd", (id, mode, e) => {
                    let event = this.scheduler.getEvent(id);

                    event.isNew = event.isNew === false ? false : true;

                    if (event.isNew) {
                        this.scheduler.deleteEvent(id);
                        this.createEvent(event);
                    } else {
                        this.updateEvent(event);
                    }
                });

                this.scheduler.attachEvent("onBeforeLightbox", (id) => {
                    return false;
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

                this.scheduler.attachEvent("onEventDeleted", function (id, ev) {
                    //this.deleteEvent(id);
                });
            },

            loadData() {
                this.scheduler.getEvents().forEach(item => {
                    this.scheduler.deleteEvent(item.id);
                });

                if (this.masterId === null) return;

                let state = this.scheduler.getState(),
                    startDate = state.min_date,
                    endDate = state.max_date;

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
                    Array.from(data.masterSchedules).forEach(item => {
                        this.addEvent(item);
                    });
                });
            },
            changeMasterId() {
                this.masterId = this.$route.query.master_id || null;
                this.loadData();

                this.setCanCreateEvent();
            },
            setCanCreateEvent() {
                if (this.masterId === null) {
                    this.scheduler.config.drag_create = false;
                } else {
                    this.scheduler.config.drag_create = true;
                }
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
                    }
                }).then(({data}) => {
                    this.addEvent(data.masterScheduleCreate);
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
                    this.scheduler.updateEvent(this.addEvent(data.masterScheduleUpdate));
                });
            },
            deleteEvent(id) {
                this.$apollo.mutate({
                    mutation: gql`mutation ($id: ID!) {
                        masterScheduleDelete(id: $id)
                    }`,
                    variables: {id: id}
                }).then(({data}) => {
                    if (data.masterScheduleDelete) this.scheduler.deleteEvent(id);
                });
            },
            dateFormat(date) {
                return dateFormat(date, 'yyyy-mm-dd HH:MM:ss')
            },
        },
        watch: {
            '$route.query.master_id': function (masterId) {
                this.changeMasterId();
            },
        }
    }
</script>