<template>
    <div>
        <h1>График работы</h1>

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
</template>

<script>
    import 'dhtmlx-scheduler/codebase/dhtmlxscheduler_flat.css';
    import 'dhtmlx-scheduler/codebase/dhtmlxscheduler.js';
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_limit.js';
    import 'dhtmlx-scheduler/codebase/ext/dhtmlxscheduler_daytimeline.js';

    import gql from 'graphql-tag';
    import dateFormat from 'dateformat';

    export default {
        name: "Schedule",
        mounted() {
            this.initScheduler();
        },
        destroyed() {
            delete this.scheduler;
        },
        data() {
            return {
                items: [],
                users: []
            }
        },
        methods: {
            initScheduler() {
                this.scheduler = Scheduler.getSchedulerInstance();

                this.initSchedulerEvents();
                this.initSchedulerConfig();

                this.scheduler.init('timeline', new Date(), "timeline");
            },
            initSchedulerConfig() {
                this.scheduler.locale.labels.timeline_tab = "Timeline";
                this.scheduler.locale.labels.section_custom = "Section";
                this.scheduler.config.details_on_dblclick = false;
                this.scheduler.config.api_date = "%Y-%m-%d %H:%i";
                this.scheduler.config.xml_date = "%Y-%m-%d %H:%i";

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

                this.scheduler.attachEvent("onBeforeLightbox", (id) => {return false;});

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

                this.scheduler.attachEvent("onEventDeleted", function(id,ev){
                    //this.deleteEvent(id);
                });
            },

            loadData() {
                let state = this.scheduler.getState(),
                    startDate = state.min_date,
                    endDate = state.max_date;

                this.$apollo.query({
                    query: gql`query ($userId: ID!, $startDate: DateTime, $endDate: DateTime) {
                        userSchedules(
                            user_id: $userId,
                            start_date: $startDate,
                            end_date: $endDate
                         ) {
                            id, type, start_date, end_date
                        }
                    }`,
                    variables: {
                        userId: 1, // @todo где брать???,
                        startDate: this.dateFormat(startDate),
                        endDate: this.dateFormat(endDate)
                    }
                }).then(({data}) => {
                    this.scheduler.getEvents().forEach(item => {
                        this.scheduler.deleteEvent(item.id);
                    });

                    Array.from(data.userSchedules).forEach(item => {
                        this.addEvent(item);
                    });
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
                    mutation: gql`mutation (
                            $userId: ID!,
                            $type: Int!,
                            $startDate: DateTime!,
                            $endDate: DateTime!
                        ) {
                        userScheduleCreate(attributes: {
                            user_id: $userId,
                            type: $type,
                            start_date: $startDate,
                            end_date: $endDate
                        }) {
                            id, user_id, type, start_date, end_date
                        }
                    }`,
                    variables: {
                        userId: 1,
                        type: 1,
                        startDate: this.dateFormat(event.start_date),
                        endDate: this.dateFormat(event.end_date)
                    }
                }).then(({data}) => {
                    this.addEvent(data.userScheduleCreate);
                });
            },
            updateEvent(event) {
                this.$apollo.mutate({
                    mutation: gql`mutation (
                            $id: ID!,
                            $startDate: DateTime,
                            $endDate: DateTime
                        ) {
                        userScheduleUpdate(id: $id, attributes: {
                            start_date: $startDate,
                            end_date: $endDate
                        }) {
                            id, user_id, type, start_date, end_date
                        }
                    }`,
                    variables: {
                        id: event.id,
                        startDate: this.dateFormat(event.start_date),
                        endDate: this.dateFormat(event.end_date)
                    }
                }).then(({data}) => {
                    let eventId = this.addEvent(data.userScheduleUpdate);

                    this.scheduler.updateEvent(eventId);
                });
            },
            deleteEvent(id) {
                this.$apollo.mutate({
                    mutation: gql`mutation ($id: ID!) {
                        userScheduleDelete(id: $id)
                    }`,
                    variables: {id: id}
                }).then(({data}) => {
                   console.log(data);
                });
            },
            dateFormat(date) {
                return dateFormat(date, 'yyyy-mm-dd HH:MM:ss')
            }
        }
    }
</script>