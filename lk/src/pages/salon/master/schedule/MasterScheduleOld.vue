<template>
    <div>
        <div class="uk-grid uk-grid-small">
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
            <v-btn @click="onSubmitFormEasy()" color="primary">Ok</v-btn>
        </div>

        <v-tabs>
            <v-tab @click="clearAttributes">Простой</v-tab>
            <v-tab @click="clearAttributes">Расширенный</v-tab>
            <v-tab-item>
                <div class="uk-card uk-card-default">
                    <div class="uk-card-body">
                        <v-form ref="formEasy">
                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-2-5">
                                    <strong>Дни недели</strong>
                                    <v-checkbox
                                            v-for="day in weekDayItems"
                                            v-model="attributes.weekDaysSelected"
                                            :label="day.text"
                                            :value="day.value"
                                            hide-details
                                    />
                                </div>
                                <div class="uk-width-3-5">
                                    <div class="uk-grid uk-child-width-1-1">
                                        <div>
                                            <div class="uk-grid uk-grid-small uk-child-width-1-2">
                                                <div>
                                                    <strong>Тип повтора</strong>
                                                    <v-radio-group
                                                            v-model="attributes.typeRepeatSelected"
                                                            :mandatory="false"
                                                            row
                                                            :rules="rules.typeRepeatSelected"
                                                    >
                                                        <v-radio
                                                                v-for="typeRepeat in typeRepeatItems"
                                                                :label="typeRepeat.text"
                                                                :value="typeRepeat.value"
                                                        />
                                                    </v-radio-group>
                                                </div>
                                                <div>
                                                    <strong>Количество повторений</strong>
                                                    <div class="uk-width-1-3">
                                                        <v-select
                                                                v-model="attributes.quantityRepeatSelected"
                                                                :items="quantityRepeatItems"
                                                                :rules="rules.quantityRepeatSelected"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                            </div>
                        </v-form>
                    </div>
                    <div class="uk-card-footer uk-padding-small">
                        <v-btn @click="onSubmitFormEasy()" color="primary">Ok</v-btn>
                    </div>
                </div>
            </v-tab-item>
            <v-tab-item>
                <div class="uk-card uk-card-default">
                    <div class="uk-card-body">
                        <v-form ref="formExtended">
                            <div class="uk-grid uk-grid-small uk-child-width-1-1">
                                <div>
                                    <strong>Промежуток времени</strong>
                                    <div class="uk-grid uk-grid-small">
                                        <div class="uk-width-1-3">
                                            <v-menu
                                                    ref="menu"
                                                    v-model="dateStartActive"
                                            >
                                                <v-text-field
                                                        slot="activator"
                                                        v-model="attributes.dateStart"
                                                        :rules="rules.dateStart"
                                                        prepend-icon="mdi mdi-calendar"
                                                        readonly
                                                ></v-text-field>
                                                <v-date-picker v-model="attributes.dateStart" no-title scrollable/>
                                            </v-menu>
                                        </div>
                                        <div class="uk-width-1-3">-</div>
                                        <div class="uk-width-1-3">
                                            <v-menu
                                                    ref="menu"
                                                    v-model="dateEndActive"
                                            >
                                                <v-text-field
                                                        slot="activator"
                                                        v-model="attributes.dateEnd"
                                                        :rules="rules.dateEnd"
                                                        prepend-icon="mdi mdi-calendar"
                                                        readonly
                                                ></v-text-field>
                                                <v-date-picker v-model="attributes.dateEnd" no-title scrollable/>
                                            </v-menu>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <strong>График работы</strong>
                                    <div class="uk-grid uk-grid-small uk-child-width-1-2">
                                        <div>
                                            с
                                            <v-select
                                                    v-model="attributes.conditionStart"
                                                    :items="conditionItems"
                                                    :rules="rules.conditionStart"
                                            />
                                        </div>
                                        <div>
                                            через
                                            <v-select
                                                    v-model="attributes.conditionEnd"
                                                    :items="conditionItems"
                                                    :rules="rules.conditionEnd"
                                            />
                                        </div>
                                    </div>
                                </div>
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
                        </v-form>
                    </div>
                    <div class="uk-card-footer uk-padding-small">
                        <v-btn @click="onSubmitFormExtended" color="primary">Ok</v-btn>
                    </div>
                </div>
            </v-tab-item>
        </v-tabs>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import dateformat from 'dateformat';
    import {formRules} from "../../../../js/formRules";

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
        data() {
            return {
                attributes: {
                    dateSelected: [],

                    weekDaysSelected: [],
                    typeRepeatSelected: 1,
                    quantityRepeatSelected: 1,
                    timeStart: '0800',
                    timeEnd: '1800',
                    timeBreakStart: '1300',
                    timeBreakEnd: '1400',
                    dateStart: null,
                    dateEnd: null,
                    conditionStart: 5,
                    conditionEnd: 2,
                },

                weekDayItems: this.getWeekDayItems(),
                typeRepeatItems: this.getTypeRepeatItems(),
                quantityRepeatItems: Array(12).fill(0).map((e, i) => i + 1),
                timeBreak: false,
                dateStartActive: false,
                dateEndActive: false,
                conditionItems: Array(7).fill(0).map((e, i) => i + 1),

                rules: {
                    weekDaysSelected: [
                        v => formRules.required(v),
                        v => formRules.in(v, this.getWeekDayItems().map(item => {
                            return item.value;
                        }))
                    ],
                    typeRepeatSelected: [
                        v => formRules.required(v),
                        v => formRules.in(v, this.getTypeRepeatItems().map(item => {
                            return item.value;
                        }))
                    ],
                    quantityRepeatSelected: [
                        v => formRules.required(v),
                        v => formRules.in(v, this.quantityRepeatItems)
                    ],
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
                    ],
                    dateStart: [
                        v => formRules.required(v),
                        v => {
                            if (!this.attributes.dateEnd) return true;
                            return +new Date(v) < +new Date(this.attributes.dateEnd) || 'Ошибка';
                        }
                    ],
                    dateEnd: [
                        v => formRules.required(v),
                        v => {
                            if (!this.attributes.dateEnd) return true;
                            return +new Date(v) > +new Date(this.attributes.dateStart) || 'Ошибка';
                        }
                    ],
                    conditionStart: [
                        v => formRules.required(v)
                    ],
                    conditionEnd: [
                        v => formRules.required(v)
                    ],
                }
            }
        },
        methods: {
            onSubmitFormEasy() {
                if (this.attributes.weekDaysSelected.length === 0) {
                    alert('Выберите дни недели');
                    return;
                }

                if (this.$refs.formEasy.validate()) {
                    let items = [];
                    this.getDateItemsForFormEasy().forEach(item => {
                        items.push({
                            master_id: this.masterId,
                            salon_id: this.salonId,
                            type: 1,
                            start_date: dateformat(item.startDate, 'yyyy-mm-dd HH:MM:ss'),
                            end_date: dateformat(item.endDate, 'yyyy-mm-dd HH:MM:ss'),
                        })
                    });

                    this.$apollo.mutate({
                        mutation: gql`mutation ($items: [MasterScheduleCreateInput]!) {
                            masterSchedulesCreate(items: $items)
                        }`,
                        variables: {items}
                    }).then(({data}) => {
                        this.$emit('save');
                    });
                }
            },
            onSubmitFormExtended() {
                if (this.$refs.formExtended.validate()) {
                    console.log(this.getDateItemsForFormExtended());
                }
            },
            getDateItemsForFormEasy() {
                let dateItems = [],
                    date = new Date(),
                    currentDate = this.isTypeRepeatMonth() ? new Date(date.getFullYear(), date.getMonth(), 1) : new Date(),
                    quantityRepeatSelected = this.attributes.quantityRepeatSelected,
                    quantityRepeat = this.isTypeRepeatMonth() ? +quantityRepeatSelected * 4 : quantityRepeatSelected;

                console.log(quantityRepeat);
                for (let i = 0; i < quantityRepeat; i++) {
                    this.attributes.weekDaysSelected.forEach(day => {
                        dateItems.push(this.getFragmentsDateTime(this.getWeekDate(day, this.getMondayDate(currentDate))));
                    });
                    currentDate.setDate(currentDate.getDate() + 7);
                }

                console.log(this.getNormalizeDateItems(dateItems));
                return;

                return this.getNormalizeDateItems(dateItems);
            },
            getDateItemsForFormExtended() {
                let items = [];

                let totalDay = this.getTotalDayForMonth(this.attributes.dateStart, this.attributes.dateEnd),
                    conditionStart = +this.attributes.conditionStart,
                    conditionEnd = +this.attributes.conditionEnd,
                    start = 0,
                    end = conditionEnd;

                for (let day = 0; day < totalDay; day++) {
                    let datetime = new Date(this.attributes.dateStart);
                    datetime.setDate(datetime.getDate() + day);

                    if (start < conditionStart && end === conditionEnd) {
                        start++;
                        items.push(this.getFragmentsDateTime(datetime));
                    } else if (start >= conditionStart && end === conditionEnd) {
                        start = 0;
                        end = 1;
                    } else if (end < conditionEnd) {
                        end++;
                        continue;
                    }
                }
                return this.getNormalizeDateItems(items);
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

            getWeekDayItems() {
                return [
                    {value: 1, text: 'Понедельник'},
                    {value: 2, text: 'Вторник'},
                    {value: 3, text: 'Среда'},
                    {value: 4, text: 'Четверг'},
                    {value: 5, text: 'Пятници'},
                    {value: 6, text: 'Суббота'},
                    {value: 7, text: 'Воскресенье'},
                ];
            },
            getTypeRepeatItems() {
                return [
                    {value: 1, text: 'Неделя'},
                    {value: 2, text: 'Месяц'},
                ];
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
            getTotalDayForMonth(date, endDate) {
                function format(stamp) {
                    return stamp / (1000 * 3600 * 24) + 1;
                }

                if (date && endDate) return format(new Date(endDate) - new Date(date));

                let cd = new Date(date);

                return format(new Date(cd.getYear(), cd.getMonth() + 1, 0) - new Date(cd.getYear(), cd.getMonth(), 1));
            },
            getMondayDate(date) {
                let dt = new Date(date);

                if (dt.getDay() === 1) {
                    return dt;
                } else if (dt.getDay()) {
                    dt.setDate(dt.getDate() + 8 - dt.getDay())
                } else {
                    dt.setDate(dt.getDate() + 1)
                }
                dt.setSeconds(0);

                return dt;
            },
            getWeekDate(day, mondayDate) {
                let date = new Date(mondayDate);
                date.setDate(date.getDate() + (day - 1));

                return date;
            },
            isTypeRepeatWeek() {
                return +this.attributes.typeRepeatSelected === 1;
            },
            isTypeRepeatMonth() {
                return !this.isTypeRepeatWeek();
            },
            clearAttributes() {
                this.attributes.weekDaysSelected = [];
                this.attributes.typeRepeatSelected = 1;
                this.attributes.quantityRepeatSelected = 1;
                this.attributes.timeStart = '0800';
                this.attributes.timeEnd = '1800';
                this.attributes.timeBreakStart = '1300';
                this.attributes.timeBreakEnd = '1400';
                this.attributes.dateStart = null;
                this.attributes.dateEnd = null;
                this.attributes.conditionStart = 5;
                this.attributes.conditionEnd = 2;
                this.timeBreak = false;
            }
        }
    }
</script>