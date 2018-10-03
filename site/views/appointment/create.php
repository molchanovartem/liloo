<div class="uk-container">
    <div id="form">
        <v-app>
            <div class="uk-grid uk-grid-small uk-grid-divider">
                <div class="uk-width-1-2 uk-first-column">
                    <div class="uk-flex uk-flex-middle">
                        <div class="uk-width-auto">
                            <v-btn icon @click="onPrevDate()">
                                <v-icon>mdi-chevron-left</v-icon>
                            </v-btn>
                        </div>
                        <div class="uk-width-expend uk-text-center">

                            <v-date-picker v-model="attributes.date" no-title scrollable/>

                            {{cpdDate}}
                        </div>
                        <div class="uk-width-auto">
                            <v-btn icon @click="onNextDate()">
                                <v-icon>mdi-chevron-right</v-icon>
                            </v-btn>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-2">
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
                        <li v-for="serviceId in attributes.servicesId">{{getServiceName(serviceId)}}</li>
                    </ul>
                </div>
            </div>


            <div class="uk-grid uk-grid-small uk-grid-divider">
                <div class="uk-width-2-3 uk-hidden">
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
        </v-app>
    </div>
</div>

<script>
    catalogFormInit(1234);

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
                    this.date = new Date();
                },
                beforeMount() {
                    this.loadServices();
                },
                data: {
                    scenario: null,
                    services: [],
                    masters: [],
                    serviceSelected: null,
                    monthList: [
                        'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
                    ],

                    attributes: {
                        userId: null,
                        salonId: null,
                        masterId: null,
                        date: '2018-10-10',
                        time: null,
                        servicesId: [],
                    }
                },
                computed: {
                    cpdDate() {
                        let date = new Date();
                        if (this.attributes.date) {
                            date = new Date(this.attributes.date);
                        }
                        return date.toLocaleString("ru", {day: 'numeric', month: 'long'});
                    }
                },
                methods: {
                    loadServices() {
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

                        if (this.isScenarioMaster()) {
                            this.masters = [
                                {id: 1, name: 'Kirill'},
                                {id: 2, name: 'Artem'},
                                {id: 3, name: 'Alex'},
                            ];
                        }
                    },

                    onAdd() {
                        if (this.serviceSelected) this.attributes.servicesId.push(this.serviceSelected);
                    },
                    onPrevDate() {
                        let date = new Date(this.attributes.date);

                        date.setDate(date.getDate() - 1);

                        this.attributes.date = moment(date).format('YYYY-MM-DD');
                    },
                    onNextDate() {
                        let date = new Date(this.attributes.date);

                        date.setDate(date.getDate() + 1);

                        this.attributes.date = moment(date).format('YYYY-MM-DD');
                    },

                    isScenarioMaster() {
                        return this.scenario === SCENARIO_MASTER;
                    },
                    isScenarioSalon() {
                        return this.scenario === SCENARIO_SALON;
                    },

                    onServiceSelect(service) {
                        if (this.hasServiceSelected(service)) {
                            this.attributes.servicesId.splice(this.getServicesIdIndex(service), 1);
                        } else {
                            this.attributes.servicesId.push(+service.id);
                        }
                    },
                    hasServiceSelected(service) {
                        return this.getServicesIdIndex(service) !== -1;
                    },
                    getServicesIdIndex(service) {
                        return this.attributes.servicesId.indexOf(+service.id);
                    },
                    getServicesIndex(serviceId) {
                        return this.services.findIndex(item => {
                            return +item.id === +serviceId;
                        });
                    },
                    getServiceName(serviceId) {
                        return this.services[this.getServicesIndex(serviceId)].name || null;
                    }
                },
            })
        })();
    }
</script>