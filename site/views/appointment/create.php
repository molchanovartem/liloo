<div class="uk-container">
    <div id="form">
        <div class="uk-grid uk-grid-small uk-grid-divider">
            <div class="uk-width-1-2 uk-first-column">
                <div class="uk-flex uk-flex-middle">
                    <div class="uk-width-auto">
                        <v-btn icon @click="onPrevDate()">
                            <v-icon>mdi-chevron-left</v-icon>
                        </v-btn>
                    </div>
                    <div class="uk-width-expend uk-text-center">
                        <i class="mdi mdi-calendar" @click="onShowCalendar"></i>
                        {{cpdDate}}
                        <v-menu
                                ref="menu"
                                v-model="calendarShow"
                                :close-on-content-click="false"
                                :position-x="calendarPositionX"
                                :position-y="calendarPositionY"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                        >
                            <v-date-picker
                                    v-model="date"
                                    prev-icon="mdi-chevron-left"
                                    next-icon="mdi-chevron-right"
                                    no-title
                                    scrollable
                            >
                                <v-btn flat color="primary" @click="onCloseCalendar">OK</v-btn>
                            </v-date-picker>
                        </v-menu>
                    </div>
                    <div class="uk-width-auto">
                        <v-btn icon @click="onNextDate()">
                            <v-icon>mdi-chevron-right</v-icon>
                        </v-btn>
                    </div>
                </div>

                <div>
                    <v-btn
                            v-for="item in freeTime"
                            :outline="hasDateTimeSelected(item)"
                            @click="onDateTimeSelected(item)"
                    >{{item | time}}
                    </v-btn>
                </div>
            </div>
            <div class="uk-width-1-2">
                <div class="uk-grid uk-grid-small uk-grid-divider">
                    <div class="uk-width-1-1">
                        <div iv-show="isScenarioSalon()">
                            <div class="uk-position-relative uk-visible-toggle" uk-slider>
                                <div class="uk-slider-items uk-grid">
                                    <div class="uk-width-1-1" v-for="master in masters">
                                        <div class="uk-panel uk-flex uk-flex-center">
                                            <div class="uk-width-small uk-text-center">
                                                <img src="https://getuikit.com/docs/images/avatar.jpg"
                                                     class="uk-border-circle" alt="">
                                                {{master.name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a class="uk-position-center-left uk-position-small" href="#" uk-slider-item="previous">
                                    <i class="mdi mdi-chevron-left uk-text-large"></i>
                                </a>
                                <a class="uk-position-center-right uk-position-small" href="#" uk-slider-item="next">
                                    <i class="mdi mdi-chevron-right uk-text-large"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="uk-grid uk-grid-small uk-flex-middle">
                    <div class="uk-width-expand">
                        <v-autocomplete
                                v-model="serviceSelected"
                                :items="services"
                                item-value="id"
                                item-text="name"
                                label="Услуги"
                                append-icon="mdi-chevron-down"
                                outline
                                hide-details
                        />
                    </div>
                    <div class="uk-width-auto">
                        <v-btn outline fab @click="onAdd">
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                    </div>
                </div>

                <ul class="uk-list uk-list-divider">
                    <li v-for="service in getServicesByServicesId()">
                        <div class="uk-grid uk-grid-small uk-flex-middle">
                            <div class="uk-width-expand">
                                {{service.name}}
                            </div>
                            <div class="uk-width-auto">
                                {{service.price | currency}}
                            </div>
                            <div class="uk-width-auto">
                                <v-btn icon small @click="onDelete(service.id)">
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                            </div>
                        </div>
                    </li>
                </ul>

                <div>
                    <ul>
                        <li>Сумма: {{sum | currency}}</li>
                        <li>Длительность: {{duration | duration}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    catalogFormInit(52, null, '2018-09-04');

    function catalogFormInit(userId = null, salonId = null, date = null) {
        const SCENARIO_MASTER = 'master';
        const SCENARIO_SALON = 'salon';

        let wm = null;

        (() => {
            wm = new Vue({
                el: '#form',
                created() {
                    if (userId) this.scenario = SCENARIO_MASTER;
                    else if (salonId) this.scenario = SCENARIO_SALON;

                    this.attributes.userId = userId;
                    this.attributes.salonId = salonId;
                    this.date = date;
                },
                beforeMount() {
                    this.loadCommonData()
                        .then(() => {
                            this.loadFreeTime();
                        });
                },
                data: {
                    scenario: null,
                    services: [],
                    masters: [],
                    freeTime: [],
                    serviceSelected: null,
                    calendarShow: null,
                    calendarPositionX: null,
                    calendarPositionY: null,
                    date: '',
                    sum: 0,
                    duration: 0,

                    attributes: {
                        userId: null,
                        salonId: null,
                        masterId: null,
                        dateTime: null,
                        servicesId: [],
                    }
                },
                computed: {
                    cpdDate() {
                        let date = new Date();
                        if (this.date) {
                            date = new Date(this.date);
                        }
                        return date.toLocaleString("ru", {day: 'numeric', month: 'long'});
                    },
                },
                methods: {
                    loadCommonData() {
                        return new Promise((resolve, reject) => {
                            $.post('http://liloo/api/common', JSON.stringify({
                                query: `query ($salonId: ID!) {
                                     ${this.isScenarioSalon() ? 'masters(salon_id: $salonId) {id, surname, name, patronymic}' : ''}
                                }`,
                                variables: {
                                    salonId: this.attributes.salonId
                                }
                            }))
                                .done(({data}) => {
                                    if (this.isScenarioSalon()) {
                                        this.masters = data.masters;

                                        if (this.masters.length > 0) {
                                            this.attributes.masterId = this.masters[0].id;
                                        }
                                    }

                                    this.services = [
                                        {id: 1, specialization_id: 1, name: 'Канадка', price: 200, duration: 20},
                                        {
                                            id: 3,
                                            specialization_id: 1,
                                            name: 'Покраска волос',
                                            price: 1500,
                                            duration: 120
                                        },
                                        {id: 2, specialization_id: 2, name: 'Маникюр', price: 300, duration: 40},
                                    ];

                                    resolve(true);
                                });
                        });
                    },
                    loadFreeTime() {
                        $.get(`http://liloo/site/web/appointment/get-${this.isScenarioMaster() ? 'user' : 'master'}-free-time`, {
                            [this.isScenarioMaster() ? 'user_id' : 'master_id']: this.isScenarioMaster() ? this.attributes.userId : this.attributes.masterId,
                            date: this.date,
                            unaccounted_time: this.duration * 60
                        })
                            .then((data) => {
                                this.freeTime = data;
                            });
                    },
                    onShowCalendar(event) {
                        event.preventDefault();

                        this.calendarShow = false;
                        this.calendarPositionX = event.clientX;
                        this.calendarPositionY = event.clientY;

                        this.$nextTick(() => {
                            this.calendarShow = true
                        })
                    },
                    onCloseCalendar() {
                        this.calendarShow = false;
                        this.loadFreeTime();
                    },

                    onAdd() {
                        if (this.serviceSelected) {
                            this.attributes.servicesId.push(+this.serviceSelected);

                            let service = this.getService(this.serviceSelected);

                            if (service) {
                                this.sum += +service.price;
                                this.duration += +service.duration;

                                this.loadFreeTime();
                            }
                        }
                    },
                    onDelete(serviceId) {
                        let index = this.attributes.servicesId.indexOf(+serviceId);

                        if (index !== -1) this.attributes.servicesId.splice(index, 1);

                        let service = this.getService(serviceId);

                        if (service) {
                            this.sum -= +service.price;
                            this.duration -= +service.duration;

                            this.loadFreeTime();
                        }
                    },
                    onPrevDate() {
                        let date = new Date(this.date);

                        date.setDate(date.getDate() - 1);

                        this.date = moment(date).format('YYYY-MM-DD');
                        this.loadFreeTime();
                    },
                    onNextDate() {
                        let date = new Date(this.date);

                        date.setDate(date.getDate() + 1);

                        this.date = moment(date).format('YYYY-MM-DD');
                        this.loadFreeTime();
                    },
                    onDateTimeSelected(item) {
                        this.attributes.dateTime = item;
                    },
                    onServiceSelect(service) {
                        if (this.hasServiceSelected(service)) {
                            this.attributes.servicesId.splice(this.getServicesIdIndex(service), 1);
                        } else {
                            this.attributes.servicesId.push(+service.id);
                        }
                    },

                    hasDateTimeSelected(item) {
                        return this.attributes.dateTime === item
                    },
                    isScenarioMaster() {
                        return this.scenario === SCENARIO_MASTER;
                    },
                    isScenarioSalon() {
                        return this.scenario === SCENARIO_SALON;
                    },

                    hasServiceSelected(service) {
                        return this.getServicesIdIndex(service) !== -1;
                    },
                    getServicesIdIndex(service) {
                        return this.attributes.servicesId.indexOf(+service.id);
                    },
                    getService(serviceId) {
                        return this.services.find(item => {
                            return +item.id === +serviceId;
                        });
                    },
                    getServicesByServicesId() {
                        return this.attributes.servicesId.map(serviceId => {
                            return this.getService(serviceId);
                        });
                    },

                },
                filters: {
                    currency(value) {
                        return new Intl.NumberFormat('ru-RU', {
                            style: 'decimal',
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(value);
                    },
                    duration(minute) {
                        var seconds = minute * 60,
                            minutes = Math.floor(seconds / 60 % 60),
                            hours = Math.floor(seconds / 3600 % 24);

                        function format(value) {
                            return value < 10 ? '0' + value : value;
                        }

                        return format(hours) + ':' + format(minutes);
                    },
                    time(value) {
                        return moment(value).format('HH:mm');
                    }
                }
            })
        })();
    }
</script>