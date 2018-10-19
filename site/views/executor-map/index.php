<?php
$this->registerJs('executorCatalog();');

$this->setHeading('Лучшие мастера сайта Liloo.ru');
$this->setBreadcrumbs(['Исполнители']);
?>
<div id="catalog" style="display: none" :style="{display: isShow ? 'block' : 'none'}">
    <div class="uk-margin">
        <div class="uk-container">
            <div class="uk-margin-top uk-margin-bottom">
                <form ref="filter">
                    <div class="uk-grid uk-grid-small uk-child-width-1-4">
                        <div>
                            <div class="uk-background-default executor-filter-border-radius">
                                <v-autocomplete
                                        outline
                                        :items="specializations"
                                        v-model="attributes.specializationId"
                                        label="Специализация"
                                        append-icon="mdi-chevron-down"
                                        item-value="id"
                                        item-text="name"
                                        hide-details
                                />
                            </div>
                        </div>
                        <div>
                            <div class="uk-background-default executor-filter-border-radius">
                                <v-autocomplete
                                        outline
                                        :items="services"
                                        v-model="attributes.serviceId"
                                        label="Услуга"
                                        append-icon="mdi-chevron-down"
                                        item-value="id"
                                        item-text="name"
                                        hide-details
                                />
                            </div>
                        </div>
                        <div>
                            <div class="uk-background-default executor-filter-border-radius">
                                <v-menu
                                        lazy
                                        transition="scale-transition"
                                        offset-y
                                        full-width
                                        min-width="290px"
                                >
                                    <v-text-field
                                            slot="activator"
                                            v-model="attributes.date"
                                            label="Выбор даты"
                                            append-icon="mdi-calendar"
                                            readonly
                                            hide-details
                                            outline
                                            height="60px"
                                    ></v-text-field>
                                    <v-date-picker
                                            v-model="attributes.date"
                                            prev-icon="mdi-chevron-left"
                                            next-icon="mdi-chevron-right"
                                            no-title
                                    />
                                </v-menu>
                            </div>
                        </div>
                        <div>
                            <div class="uk-background-default uk-width-4-5 executor-filter-custom-time">
                                <div class="uk-grid uk-grid-small uk-flex-middle">
                                    <div class="uk-width-expand">
                                        <div class="uk-grid uk-grid-small uk-flex-middle">
                                            <div class="uk-width-expand">
                                                <v-select
                                                        v-model="attributes.hour"
                                                        :items="getHourList()"
                                                        :append-icon="null"
                                                        single-line
                                                        hide-details
                                                />
                                            </div>
                                            <div class="uk-width-auto uk-text-lead">:</div>
                                            <div class="uk-width-expand">
                                                <v-select
                                                        v-model="attributes.minute"
                                                        :items="getMinuteList()"
                                                        :append-icon="null"
                                                        hide-details
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid uk-grid-small">
                        <div class="uk-width-1-1">
                            <button @click.prevent="onSubmit"
                                    class="uk-button uk-button-primary uk-button-small">
                                <i class="mdi mdi-magnify uk-text-large"></i>
                            </button>
                            <button @click.prevent="onReset"
                                    class="uk-button uk-button-primary uk-button-small">
                                <i class="mdi mdi-refresh uk-text-large"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="uk-container uk-margin-medium-top">
        <div class="uk-margin-small-bottom">
            <button
                    @click="viewTypeCatalog"
                    class="uk-button uk-button-small"
                    :class="[isViewTypeCatalog() ?  'uk-button-primary': 'uk-button-default']"
            >
                <i class="mdi mdi-menu uk-text-large"></i>
            </button>
            <button
                    @click="viewTypeMap"
                    class="uk-button uk-button-small"
                    :class="[isViewTypeMap() ? 'uk-button-primary': 'uk-button-default']"
            >
                <i class="mdi mdi-map-marker-radius uk-text-large"></i>
            </button>
        </div>
        <div ref="catalog">
            <div v-for="item in executors">
                <div class="performers-select__item">
                    <div class="performers-select__performer">
                        <div class="performer">
                            <div class="performer__img"
                                 style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png)"></div>
                            <div class="performer__info">
                                <div class="label-status label-status_bg_black label-status_fz_14">Profi
                                </div>
                                <a :href="getLinkViewExecutor(item)" data-ajax-content="true" class="uk-link-reset">
                                    <div class="performer__name">{{item.name}}</div>
                                </a>
                                <div class="performer__profession">
                                    <span v-for="specialization in item.specializations">
                                        {{specialization.name}},
                                    </span>
                                </div>
                                <div class="performer__profession">{{item.address}}</div>
                                <div class="performer__extra">
                                    <div class="stars">
                                        <div class="fas fa-star stars__star stars__star_active"></div>
                                        <div class="fas fa-star stars__star stars__star_active"></div>
                                        <div class="fas fa-star stars__star stars__star_active"></div>
                                        <div class="fas fa-star stars__star stars__star_active"></div>
                                        <div class="fas fa-star stars__star stars__star_active"></div>
                                    </div>
                                    <div class="vote">
                                        <i class="fas fa-comment-alt-dots vote__icon vote__icon_color_gray"></i>
                                        <span class="vote__digits">
                                                <span class="vote__digit vote__digit_color_green">+{{item.assessment_like}}</span>
                                                <span class="vote__digit vote__digit_color_red">-{{item.assessment_dislike}}</span>
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bill uk-margin-small-top">
                            <div v-for="item in item.services">
                                <div class="bill__row">
                                    <div class="bill__name">{{item.name}}</div>
                                    <div class="bill__cost">{{item.price}} руб.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="performers-select__schedule">
                        <div class="font_type_3 t-a_c">Ближайшее время:</div>
                        <div class="schedule-items mt-10">
                            <div class="schedule-item schedule-items__item" v-for="freeTime in item.freeTime">
                                <span class="schedule-item__time">{{freeTime | time}}</span>
                            </div>

                            <!--                            <div class="schedule-item schedule-items__item">-->
                            <!--                                <span class="schedule-item__time">17:00</span>-->
                            <!--                                <span class="schedule-item__date">20 мая</span>-->
                            <!--                            </div>-->
                        </div>
                        <div class="t-a_c mt-10">
                            <a href="" class="font_type_11">Все свободное время ???</a>
                        </div>
                        <div class="button button_color_red button_width_270 mt-10">
                            <a href="#" class="uk-button uk-link-reset" @click.prevent="onAppointmentCreate(item)">Записаться</a>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <div id="map" ref="map" style="width: 100%; height: 600px; z-index:1"></div>
    </div>
</div>

<script>
    function executorCatalog() {
        const VIEW_TYPE_CATALOG = 'catalog';
        const VIEW_TYPE_MAP = 'map';

        const map = new MapCatalog('map');

        cSpinner.show();
        let wm = new Vue({
            el: '#catalog',
            mounted() {
                cSpinner.hide();
                map.init();
            },
            beforeMount() {
                this.isShow = true;
                this.loadCommonData()
                    .then(() => {
                        this.setDefaultQueryParams();
                        this.loadAttributesFromQueryParams();
                        if (!this.hasViewType()) this.defaultViewType();

                        this.loadData();
                    });
            },
            destroyed() {
                map.destroy();
            },
            data: {
                isShow: false,
                viewType: null,

                specializations: [],
                services: [],
                executors: [],

                attributes: {
                    specializationId: null,
                    serviceId: null,
                    cityId: null,
                    date: null,
                    hour: null,
                    minute: null,
                },
            },
            methods: {
                onSubmit() {
                    this.locationQueryParamsPush();
                    this.loadData();
                },
                onReset() {
                    this.clearAttributes();
                    this.onSubmit();
                },
                onAppointmentCreate(item) {
                    appointmentCreate({
                        [item.isSalon ? 'salonId' : 'userId']: +item.id,
                        date: this.attributes.date
                    });
                },

                loadCommonData() {
                    return new Promise((resolve, reject) => {
                        $.post('http://liloo/api/common/index', JSON.stringify({
                            query: `query {
                                     specializations {id, name}
                                     commonServices {id, name, price, duration}
                                }`
                        }))
                            .done(({data}) => {
                                if (data.specializations) this.specializations = Array.from(data.specializations);
                                if (data.commonServices) this.services = data.commonServices;
                                resolve(true);
                            })
                            .fail((error) => {
                                reject(error);
                            });
                    });
                },
                loadData() {
                    cSpinner.show();
                    this.setCityId().then(() => {
                        $.get('http://liloo/site/web/executor-map/catalog-data', {
                            specialization_id: this.attributes.specializationId,
                            city_id: this.attributes.cityId,
                            service_id: this.attributes.serviceId,
                            date_time: this.getDateTime(),
                        })
                            .done(data => {
                                this.executors = [];
                                this.showMapCity();
                                map.removeExecutors();

                                if (data.items) {
                                    this.executors = data.items;

                                    data.items.forEach(item => {
                                        if (item.latitude && item.longitude) map.addExecutor(item);
                                    });
                                }
                                cSpinner.hide();
                            });
                    });
                },

                loadAttributesFromQueryParams() {
                    let params = new URLSearchParams(document.location.search),
                        viewType = params.get('view_type');

                    this.attributes.specializationId = params.get('specialization_id');
                    this.attributes.serviceId = params.get('service_id');
                    this.attributes.date = params.get('date');
                    this.attributes.hour = params.get('hour');
                    this.attributes.minute = params.get('minute');

                    if (viewType === VIEW_TYPE_MAP) this.viewTypeMap();
                    else if (viewType === VIEW_TYPE_CATALOG) this.viewTypeCatalog();
                },
                locationQueryParamsPush() {
                    let params = new URLSearchParams(document.location.search);

                    params.set('view_type', this.viewType);
                    params.set('specialization_id', this.attributes.specializationId || '');
                    params.set('service_id', this.attributes.serviceId || '');
                    params.set('date', this.attributes.date || '');
                    params.set('hour', this.attributes.hour || '');
                    params.set('minute', this.attributes.minute || '');

                    let baseUrl = [location.protocol, '//', location.host, location.pathname].join('');

                    history.replaceState({}, '', [baseUrl, params.toString()].join('?'));
                },

                setDefaultQueryParams() {
                    let params = new URLSearchParams(document.location.search),
                        date = params.get('date'),
                        hour = params.get('hour'),
                        minute = params.get('minute');

                    if (date === null || date === '') {
                        params.set('date', moment().format('YYYY-MM-DD'));
                    }

                    if (hour === null || hour === '') {
                        let hour = +moment().format('H'),
                            minute = +moment().format('m');

                        if (minute > 30) hour++;

                        params.set('hour', hour);
                    }

                    if (minute === null || minute === '') {
                        let minute = +moment().format('m');

                        if (minute > 30 || minute === 0) minute = '00';
                        else minute = '30';

                        params.set('minute', minute);
                    }

                    let baseUrl = [location.protocol, '//', location.host, location.pathname].join('');

                    history.replaceState({}, '', [baseUrl, params.toString()].join('?'));
                },

                hasViewType() {
                    return this.viewType !== null;
                },
                isViewTypeCatalog() {
                    return this.viewType === VIEW_TYPE_CATALOG;
                },
                isViewTypeMap() {
                    return this.viewType === VIEW_TYPE_MAP;
                },
                viewTypeCatalog() {
                    this.setViewType(VIEW_TYPE_CATALOG);
                    this.$refs.catalog.style.display = 'block';
                    this.$refs.map.style.display = 'none';
                },
                viewTypeMap() {
                    this.setViewType(VIEW_TYPE_MAP);
                    this.$refs.map.style.display = 'block';
                    this.$refs.catalog.style.display = 'none';
                },
                defaultViewType() {
                    this.viewTypeCatalog();
                },
                setViewType(type) {
                    this.viewType = type;
                    this.locationQueryParamsPush();
                },

                showMapCity() {
                    let city = this.getCity();

                    if (city && city.latitude && city.longitude) {
                        map.showCity(city.latitude, city.longitude);
                    }
                },
                getLinkViewExecutor(executor) {
                    let str = executor.isSalon ? 'salon-view' : 'user-view';

                    return './' + str + '?id=' + executor.id;
                },
                clearAttributes() {
                    this.attributes.specializationId = null;
                    this.attributes.serviceId = null;
                },

                getHourList() {
                    return Array.apply(null, {length: 25}).map((el, index) => {
                        return String(index).length === 1 ? '0' + index : String(index);
                    });
                },
                getMinuteList() {
                    return ['00', '30']
                },
                getDateTime() {
                    let date = moment(this.attributes.date);

                    date.hour(this.attributes.hour);
                    date.minute(this.attributes.minute);

                    return date.format('YYYY-MM-DD HH:mm:ss');
                },
                getCity() {
                    let city = localStorage.getItem('city');

                    return city ? JSON.parse(city) : null;
                },
                setCityId() {
                    let self = this,
                        city = self.getCity();

                    return new Promise((resolve, reject) => {
                        if (city === null) {
                            setTimeout(function run() {
                                city = self.getCity();

                                if (city) {
                                    self.attributes.cityId = city.id;

                                    resolve(true);
                                } else {
                                    setTimeout(run, 1000)
                                }
                            }, 1000);
                        } else {
                            self.attributes.cityId = city.id;
                            resolve(true);
                        }
                    });
                }
            },
            filters: {
                time(value) {
                    return moment(value).format('HH:mm');
                }
            }
        });

        function MapCatalog(id) {
            'use strict';

            let self = this,
                map = null,
                executors = [];

            this.init = () => {
                map = L.map(id).setView([51.505, -0.09], 13);

                L.tileLayer('http://tiles.maps.sputnik.ru/{z}/{x}/{y}.png?apikey=5032f91e8da6431d8605-f9c0c9a00357', {
                    attribution: '&copy; <a href="http://maps.sputnik.ru/">Спутник</a> | &copy; <a rel="nofollow" href="http://osm.org/copyright">OpenStreetMap</a> | &copy; Ростелеком'
                }).addTo(map);
            };

            this.showCity = (lat, lng) => {
                map.setView([lat, lng], 12);
            };

            this.addExecutor = (executor) => {
                let exec = L.marker([executor.latitude, executor.longitude]).addTo(map)
                    .bindPopup(getPopupContent(executor));

                executors.push(exec);
            };

            this.removeExecutors = () => {
                executors.forEach(item => {
                    map.removeLayer(item);
                });
            };

            this.destroy = function () {
                this.removeExecutors();
                map = null;
            };

            function getPopupContent(executor) {
                let wrapper = stringToHtml('<div class="uk-width-large"></div>'),
                    grid = stringToHtml('<div class="uk-grid uk-grid-small"></div>'),
                    columnLeft = stringToHtml('<div class="uk-width-1-3"><img src="https://getuikit.com/docs/images/avatar.jpg" class="uk-border-circle"></div>'),
                    columnRight = stringToHtml('<div class="uk-width-2-3"></div>');

                let title = stringToHtml('<div><strong>' + executor.name + '</strong></div>'),
                    description = stringToHtml('<div><p>Описание ???</p></div>'),
                    navWrapper = stringToHtml('<div></div>'),
                    buttonInfo = document.createElement('button'),
                    buttonAppointment = document.createElement('button');

                buttonInfo.setAttribute('class', 'uk-button uk-button-small uk-button-default uk-float-left');
                buttonInfo.innerText = 'i';
                buttonInfo.addEventListener('click', () => {
                    console.log(executor);
                });

                buttonAppointment.setAttribute('class', 'uk-button uk-button-small uk-button-link uk-float-right');
                buttonAppointment.addEventListener('click', () => {
                    appointmentCreate({
                        [executor.isSalon ? 'salonId' : 'userId']: +executor.id,
                        date: wm.attributes.date
                    })
                });
                buttonAppointment.innerText = 'Записаться';

                //navWrapper.appendChild(buttonInfo);
                navWrapper.appendChild(buttonAppointment);

                columnRight.appendChild(title);
                columnRight.appendChild(description);
                columnRight.appendChild(navWrapper);

                grid.appendChild(columnLeft);
                grid.appendChild(columnRight);
                wrapper.appendChild(grid);

                return wrapper;
            }

            function stringToHtml(string) {
                var wrapper = document.createElement('div');

                wrapper.innerHTML = string;
                return wrapper.firstChild;
            }
        }

        function appointmentCreate({userId = null, salonId = null, date}) {
            let window = cWindow.getWindowByType('normalModal');

            if (window) {
                $.get('http://liloo/site/web/appointment/create', {
                    [userId ? 'user_id' : 'salon_id']: userId || salonId,
                    date: date
                })
                    .done(({content}) => {
                        if (content !== undefined) {
                            window.html(content);
                            window.dialog('open');
                        }
                    });
            }
        }
    }
</script>