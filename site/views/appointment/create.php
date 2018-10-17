<div class="uk-container">
    <div id="appointmentCreate">
        <div v-show="isViewTypeForm()">
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
                                v-for="item in freeTimes"
                                :outline="hasDateTimeSelected(item)"
                                @click="onDateTimeSelected(item)"
                        >{{item | time}}
                        </v-btn>
                    </div>
                </div>
                <div class="uk-width-1-2">
                    <div class="uk-grid uk-grid-small uk-grid-divider uk-hidden">
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

                                    <a class="uk-position-center-left uk-position-small" href="#"
                                       uk-slider-item="previous">
                                        <i class="mdi mdi-chevron-left uk-text-large"></i>
                                    </a>
                                    <a class="uk-position-center-right uk-position-small" href="#"
                                       uk-slider-item="next">
                                        <i class="mdi mdi-chevron-right uk-text-large"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-show="masters.length > 0">
                        <v-select
                                v-model="attributes.masterId"
                                :items="masters"
                                item-value="id"
                                item-text="name"
                                @input="onChangeMaster"
                                append-icon="mdi-chevron-down"
                                label="Мастер"
                        />
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
                            <li>
                                <v-btn @click="onAppointmentCreate" v-show="cpdIsAppointment">Записаться</v-btn>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="isViewTypeCheckout()">
            <div>
                <v-btn icon @click="onForwardForm">
                    <v-icon>mdi-chevron-left</v-icon>
                </v-btn>
            </div>
            <div class="uk-grid uk-flex-center">
                <div class="uk-width-1-2">
                    <div class="uk-margin-small">
                        <ul class="uk-list uk-list-divider">
                            <li>
                                <i class="mdi mdi-calendar"></i> {{attributes.dateTime}}
                            </li>
                            <li>
                                <i class="mdi mdi-clock"></i> {{duration}}
                            </li>
                            <li>
                                <i class="mdi mdi-cash"></i> {{sum}}
                            </li>
                            <li>
                                Данные мастера
                            </li>
                        </ul>
                    </div>
                    <div class="uk-margin-small">
                        <div class="uk-margin-small">
                            <v-text-field
                                    v-model="attributes.name"
                                    label="Имя"
                                    outline
                            />
                        </div>
                        <div class="uk-margin-small">
                            <v-text-field
                                    v-model="attributes.phone"
                                    label="Телефон"
                                    outline
                            />
                        </div>
                    </div>
                    <div class="uk-margin-small">
                        <v-btn>Оформить заказ</v-btn>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Убрать это безобразие

$params = Yii::$app->request->getQueryParams();

$data = [];

if (!empty($params['user_id'])) $data['userId'] = $params['user_id'];
if (!empty($params['salon_id'])) $data['salonId'] = $params['salon_id'];
if (!empty($params['date'])) $data['date'] = $params['date'];

$data = json_encode($data);

$this->registerjs("catalogFormInit({$data});");
?>

<script>
    function catalogFormInit({userId = null, salonId = null, date = null}) {
        const SCENARIO_MASTER = 'master';
        const SCENARIO_SALON = 'salon';

        const VIEW_TYPE_FORM = 'form';
        const VIEW_TYPE_CHECKOUT = 'checkout';

        let wm = null;

        (() => {
            wm = new Vue({
                el: '#appointmentCreate',
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
                    viewType: VIEW_TYPE_CHECKOUT,
                    services: [],
                    masters: [],
                    freeTimes: [],
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
                        name: null,
                        phone: null
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
                    cpdIsAppointment() {
                        if (this.isScenarioSalon()) {
                            if (this.attributes.salonId && this.attributes.masterId &&
                                this.attributes.servicesId.length > 0 && this.attributes.dateTime) return true;
                        } else {
                            if (this.attributes.userId && this.attributes.servicesId.length > 0 &&
                                this.attributes.dateTime) return true;
                        }
                        return false;
                    }
                },
                methods: {
                    loadCommonData() {
                        return new Promise((resolve, reject) => {
                            //cSpinner.show();
                            $.post('http://liloo/api/common', JSON.stringify({
                                query: `query (${this.isScenarioSalon() ? '$salonId: ID!' : '$userId: ID!'}) {
                                     ${this.isScenarioSalon() ? 'masters(salon_id: $salonId) {id, surname, name, patronymic}' : ''}
                                     ${this.isScenarioSalon() ? 'servicesSalon(salon_id: $salonId)' : 'servicesUser(user_id: $userId)'} {
                                        id, specialization_id, name, price, duration
                                     }

                                }`,
                                variables: {
                                    salonId: this.attributes.salonId,
                                    userId: this.attributes.userId
                                }
                            }))
                                .done(({data}) => {
                                    if (this.isScenarioSalon()) {
                                        this.masters = data.masters;

                                        if (this.masters.length > 0) {
                                            this.attributes.masterId = this.masters[1].id;
                                        }
                                    }

                                    if (this.isScenarioSalon()) this.services = data.servicesSalon;
                                    else this.services = data.servicesUser;

                                    //cSpinner.hide();
                                    resolve(true);
                                });
                        });
                    },
                    loadFreeTime() {
                        //cSpinner.show();
                        $.post('http://liloo/api/common', JSON.stringify({
                            query: `query(${this.isScenarioSalon() ? '$masterId: ID!' : '$userId: ID!'}, $date: Date!, $period: Int, $unaccountedTime: Int) {
                                ${this.isScenarioSalon() ? 'masterFreeTimes(master_id: $masterId, date: $date, period: $period, unaccountedTime: $unaccountedTime)' :
                                'userFreeTimes(user_id: $userId, date: $date, period: $period, unaccountedTime: $unaccountedTime)'
                                }
                            }`,
                            variables: {
                                masterId: this.attributes.masterId,
                                userId: this.attributes.userId,
                                date: this.date,
                                period: 30,
                                unaccountedTime: this.duration * 60
                            }
                        }))
                            .done(({data}) => {
                                this.freeTimes = this.isScenarioSalon() ? data.masterFreeTimes : data.userFreeTimes;

                                //cSpinner.hide();
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
                    onChangeMaster() {
                        this.loadFreeTime();
                    },
                    onAppointmentCreate() {
                        this.viewType = VIEW_TYPE_CHECKOUT;
                    },
                    onForwardForm() {
                        this.viewType = VIEW_TYPE_FORM;
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
                    isViewTypeForm() {
                        return this.viewType === VIEW_TYPE_FORM;
                    },
                    isViewTypeCheckout() {
                        return this.viewType === VIEW_TYPE_CHECKOUT;
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