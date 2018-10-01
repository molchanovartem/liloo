<div class="uk-container">
    <div id="form">
        {{attributes.servicesId}}
        <div class="uk-grid uk-grid-small uk-grid-divider">
            <div class="uk-width-1-3 uk-first-column">
                <ul
                        v-for="item in services"
                        v-if="item.items.length > 0"
                        class="uk-list uk-list-divider"
                >
                    <h4>{{item.specialization}}</h4>
                    <li
                            v-for="service in item.items"
                            @click="onServiceSelect(service)"
                            class="uk-padding-small"
                            :class="{'uk-background-muted': hasServiceSelected(service)}"
                    >
                        {{service.name}}
                    </li>
                </ul>
            </div>
            <div class="uk-width-2-3">
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
                <div>
                    <v-date-picker
                            v-model="attributes.date"
                            prev-icon="mdi-chevron-left"
                            next-icon="mdi-chevron-right"
                            full-width
                            no-title
                    />
                </div>

                <div>time</div>
            </div>
        </div>
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
                    this.attributes.date = date;
                },
                beforeMount() {
                    this.loadServices();
                },
                data: {
                    scenario: null,
                    services: [],
                    masters: [],

                    attributes: {
                        userId: null,
                        salonId: null,
                        masterId: null,
                        date: null,
                        time: null,
                        servicesId: [],
                    }
                },
                methods: {
                    loadServices() {
                        this.services = [
                            {
                                specialization: 'Стрижка', items: [
                                    {id: 1, specialization_id: 1, name: 'Канадка', price: 200, duration: 20},
                                    {
                                        id: 3,
                                        specialization_id: 1,
                                        name: 'Покраска волос',
                                        price: 1500,
                                        duration: 120
                                    },
                                ]
                            },
                            {
                                specialization: 'Ногти', items: [
                                    {id: 2, specialization_id: 2, name: 'Маникюр', price: 300, duration: 40},
                                ]
                            },
                        ];

                        if (this.isScenarioMaster()) {
                            this.masters = [
                                {id: 1, name: 'Kirill'},
                                {id: 2, name: 'Artem'},
                                {id: 3, name: 'Alex'},
                            ];
                        }
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
                    }
                }
            })
        })();
    }
</script>