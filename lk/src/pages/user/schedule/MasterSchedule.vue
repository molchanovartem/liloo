<template>
    <div>
        <v-form ref="form">
            <div class="uk-grid">
                <div class="uk-width-1-2">
                    <v-date-picker
                            v-model="attributes.dateSelected"
                            locale="ru-RU"
                            first-day-of-week="1"
                            full-width
                            multiple
                            no-title
                    />
                </div>
                <div class="uk-width-1-2">
                    <div>
                        <strong>Время работы</strong>
                        <div class="uk-grid uk-grid-small uk-flex uk-flex-middle">
                            <div class="uk-width-1-3">
                                <v-text-field
                                        v-model="attributes.timeStart"
                                        mask="##:##"
                                        :rules="rules.timeStart"
                                />
                            </div>
                            <div class="uk-width-auto uk-padding-remove">
                                <v-icon>mdi-minus</v-icon>
                            </div>
                            <div class="uk-width-1-3 uk-padding-remove">
                                <v-text-field
                                        v-model="attributes.timeEnd"
                                        mask="##:##"
                                        :rules="rules.timeEnd"
                                />
                            </div>
                        </div>
                    </div>
                    <div>
                        <v-checkbox v-model="timeBreak" label="Перерыв"></v-checkbox>
                        <div
                                class="uk-grid uk-grid-small uk-flex uk-flex-middle"
                                v-show="timeBreak"
                        >
                            <div class="uk-width-1-3">
                                <v-text-field
                                        v-model="attributes.timeBreakStart"
                                        mask="##:##"
                                        :rules="rules.timeBreakStart"
                                />
                            </div>
                            <div class="uk-width-auto uk-padding-remove">
                                <v-icon>mdi-minus</v-icon>
                            </div>
                            <div class="uk-width-1-3 uk-padding-remove">
                                <v-text-field
                                        v-model="attributes.timeBreakEnd"
                                        mask="##:##"
                                        :rules="rules.timeBreakEnd"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-card-footer uk-padding-small">
                <v-btn @click="onSubmit()" color="primary">Ok</v-btn>
            </div>
        </v-form>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import dateformat from 'dateformat';
    import {formRules} from "../../../js/formRules";

    export default {
        name: "UserMasterSchedule",
        data() {
            return {
                attributes: {
                    dateSelected: [],
                    timeStart: '0900',
                    timeEnd: '1800',
                    timeBreakStart: '1300',
                    timeBreakEnd: '1400',
                },
                timeBreak: false,

                rules: {
                    timeStart: [
                        v => formRules.required(v),
                        v => /^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(v) || 'Неправильное значение',
                        v => +v < +this.attributes.timeEnd || 'Неправильное значение'
                    ],
                    timeEnd: [
                        v => formRules.required(v),
                        v => /^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(v) || 'Неправильное значение',
                        v => +v > +this.attributes.timeStart || 'Неправильное значение'
                    ],
                    timeBreakStart: [
                        v => /^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(v) || 'Неправильное значение',
                        v => +v < +this.attributes.timeBreakEnd || 'Неправильное значение',
                        v => +v > +this.attributes.timeStart || 'Неправильное значение',
                        v => +v < +this.attributes.timeEnd || 'Неправильное значение',
                    ],
                    timeBreakEnd: [
                        v => /^([0-1][0-9]|2[0-3])([0-5][0-9])$/.test(v) || 'Неправильное значение',
                        v => +v > +this.attributes.timeBreakStart || 'Неправильное значение',
                        v => +v < +this.attributes.timeEnd || 'Неправильное значение',
                        v => +v > +this.attributes.timeStart || 'Неправильное значение',
                    ]
                }
            }
        },
        methods: {
            onSubmit() {
                if (this.attributes.dateSelected.length === 0) {
                    alert ('Выберите дни');
                    return;
                }

                if (this.$refs.form.validate()) {
                    let items = this.attributes.dateSelected.map(item => {
                        return this.getFragmentsDateTime(item);
                    });

                    let itemsOnSave = [];
                    this.getNormalizeDateItems(items).forEach(item => {
                        itemsOnSave.push({
                            type: 1,
                            start_date: dateformat(item.startDate, 'yyyy-mm-dd HH:MM:ss'),
                            end_date: dateformat(item.endDate, 'yyyy-mm-dd HH:MM:ss'),
                        })
                    });

                    this.$apollo.mutate({
                        mutation: gql`mutation ($items: [UserScheduleCreateInput]!) {
                            userSchedulesCreate(items: $items)
                        }`,
                        variables: {items: itemsOnSave}
                    }).then(({data}) => {
                        if (data.userSchedulesCreate) {
                            this.$emit('save');
                        }
                        this.clearAttributes();
                    });
                }
            },
            getNormalizeDateItems(dateItems) {
                let items = [];

                dateItems.forEach(item => {
                    item.forEach(it => {
                        items.push(it);
                    })
                });
                return items;
            },
            getFragmentsDateTime(date) {
                let dateItems = [],
                    dateStart = new Date(date),
                    dateEnd = new Date(date);

                if (this.timeBreak) {

                    dateStart.setHours(this.getStartHour());
                    dateStart.setMinutes(this.getStartMinutes());

                    dateEnd.setHours(this.getBreakStartHour());
                    dateEnd.setMinutes(this.getBreakStartMinutes());

                    dateItems.push({startDate: new Date(dateStart), endDate: new Date(dateEnd)});

                    dateStart.setHours(this.getBreakEndHour());
                    dateStart.setMinutes(this.getBreakEndMinutes());

                    dateEnd.setHours(this.getEndHour());
                    dateEnd.setMinutes(this.getEndMinutes());

                    dateItems.push({startDate: new Date(dateStart), endDate: new Date(dateEnd)});
                } else {
                    dateStart.setHours(this.getStartHour());
                    dateStart.setMinutes(this.getStartMinutes());

                    dateEnd.setHours(this.getEndHour());
                    dateEnd.setMinutes(this.getEndMinutes());

                    dateItems.push({startDate: new Date(dateStart), endDate: new Date(dateEnd)});
                }
                return dateItems;
            },
            getStartHour() {
                return this.attributes.timeStart.substr(0, 2) || '09';
            },
            getStartMinutes() {
                return this.attributes.timeStart.substr(2, 4) || '00';
            },
            getEndHour() {
                return this.attributes.timeEnd.substr(0, 2) || '18';
            },
            getEndMinutes() {
                return this.attributes.timeEnd.substr(2, 4) || '00';
            },
            getBreakStartHour() {
                return this.attributes.timeBreakStart.substr(0, 2) || '13';
            },
            getBreakStartMinutes() {
                return this.attributes.timeBreakStart.substr(2, 4) || '00';
            },
            getBreakEndHour() {
                return this.attributes.timeBreakEnd.substr(0, 2) || '14';
            },
            getBreakEndMinutes() {
                return this.attributes.timeBreakEnd.substr(2, 4) || '00';
            },
            clearAttributes() {
                this.attributes.dateSelected = [];
                this.attributes.timeStart = '0800';
                this.attributes.timeEnd = '1800';
                this.attributes.timeBreakStart = '1300';
                this.attributes.timeBreakEnd = '1400';
                this.timeBreak = false;
            }
        }
    }
</script>