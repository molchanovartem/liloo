<div class="uk-container">
    <div id="catalog">
        <div class="uk-card uk-card-default uk-padding-small uk-margin">
            <form ref="filter">
                <div class="uk-grid uk-grid-small uk-child-width-1-6">
                    <div>
                        <label>Специализация</label>
                        <select class="uk-form uk-select" v-model="attributes.specializationId">
                            <option v-for="item in specializations" :value="item.id">{{item.name}}</option>
                        </select>
                    </div>
                    <div>
                        <label>Услуга</label>
                        <select class="uk-form uk-select" v-model="attributes.serviceId">
                            <option v-for="item in services" :value="item.id">{{item.name}}</option>
                        </select>
                    </div>
                    <div>
                        <label>Город</label>
                        <select class="uk-form uk-select" v-model="attributes.cityId">
                            <option v-for="item in cities" :value="item.id">{{item.name}}</option>
                        </select>
                    </div>
                    <div>
                        <label>Выбор даты</label>
                        <select class="uk-form uk-select" v-model="attributes.cityId">
                            <option v-for="item in cities" :value="item.id">{{item.name}}</option>
                        </select>
                    </div>
                    <div>
                        <label>Выбор времени</label>
                        <select class="uk-form uk-select" v-model="attributes.cityId">
                            <option v-for="item in cities" :value="item.id">{{item.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="uk-grid uk-grid-small">
                    <div class="uk-width-1-1">
                        <button @click.prevent="onSubmit" class="uk-button uk-button-primary uk-button-small">
                            <i class="mdi mdi-magnify uk-text-large"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="uk-margin">
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
                    :class="[isViewTypeMap() ?  'uk-button-primary': 'uk-button-default']"
            >
                <i class="mdi mdi-map-marker-radius uk-text-large"></i>
            </button>
        </div>

        <div id="map" ref="map" style="width: 100%; height: 600px;"></div>
        <div ref="catalog">
            <div v-for="item in executors">
                <div class="performers-select__item">
                    <div class="performers-select__performer">
                        <div class="performer">
                            <div class="performer__img"
                                 style="background-image: url(https://i.pinimg.com/favicons/e68f90563f3f2328774620cfc5ef4f800f0b4756e5b58f65220fb81b.png)"></div>
                            <div class="performer__info">
                                <div class="label-status label-status_bg_black label-status_fz_14">Profi</div>
                                <a :href="getLinkViewExecutor(item)" data-ajax-content="true">
                                    <div class="performer__name">{{item.name}}</div>
                                </a>
                                <div class="performer__profession">Парикмахер, Стилист по прическам</div>
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
                                        <span class="vote__digit vote__digit_color_green">+{{item.like}}</span>
                                        <span class="vote__digit vote__digit_color_red">-{{item.dislike}}</span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bill" v-for="item in services">
                            <div class="bill__row">
                                <div class="bill__name">{{item.name}}</div>
                                <div class="bill__cost">{{item.price}} руб.</div>
                            </div>
                        </div>
                    </div>
                    <div class="performers-select__schedule">
                        <div class="font_type_3 t-a_c">Ближайшее время:</div>
                        <div class="schedule-items mt-10">
                            <div class="schedule-item schedule-items__item">
                                <span class="schedule-item__time">17:00</span>
                                <span class="schedule-item__date">20 мая</span>
                            </div>
                            <div class="schedule-item schedule-items__item">
                                <span class="schedule-item__time">17:00</span>
                                <span class="schedule-item__date">20 мая</span>
                            </div>
                        </div>
                        <div class="t-a_c mt-10">
                            <a href="" class="font_type_11">Все свободное время</a>
                        </div>
                        <div class="button button_color_red button_width_270 mt-10">Записаться</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    executorCatalog();

    function executorCatalog() {
        const VIEW_TYPE_CATALOG = 'catalog';
        const VIEW_TYPE_MAP = 'map';

        const map = new MapCatalog('map');

        new Vue({
            el: '#catalog',
            mounted() {
                map.init();
            },
            beforeMount() {
                this.loadCommonData()
                    .then(() => {
                        this.loadAttributesFromQueryParams();
                        if (!this.hasViewType()) this.defaultViewType();

                        this.loadData();
                    });
            },
            destroyed() {
                map.destroy();
            },
            data: {
                viewType: null,

                specializations: [],
                services: [],
                cities: [],
                executors: [],

                attributes: {
                    specializationId: null,
                    serviceId: null,
                    cityId: null
                },
            },
            methods: {
                onSubmit() {
                    this.locationQueryParamsPush();

                    this.loadData();
                },

                loadCommonData() {
                    return new Promise((resolve, reject) => {
                        $.post('http://liloo/api/common/index', JSON.stringify({
                            query: "query {" +
                                "specializations {id, name}," +
                                "services {id, name, price, duration}" +
                                "cities(country_id: 1) {id, name, latitude, longitude}" +
                                "}"
                        }))
                            .done(({data}) => {
                                if (data.specializations) this.specializations = data.specializations;
                                if (data.services) this.services = data.services;
                                if (data.cities) this.cities = data.cities;

                                resolve(true)
                            })
                            .fail((error) => {
                                reject(error);
                            });
                    });
                },
                loadData() {
                    $.get('http://liloo/site/web/executor-map/catalog-data', {
                        specialization: this.attributes.specializationId,
                        city: this.attributes.cityId,
                        service: this.attributes.serviceId
                    })
                        .done(data => {
                            if (data.items) {
                                this.executors = data.items;

                                this.showMapCity();
                                map.removeExecutors();
                                data.items.forEach(item => {
                                    if (item.latitude && item.longitude) map.addExecutor(item);
                                });
                            }
                        });
                },

                loadAttributesFromQueryParams() {
                    let params = new URLSearchParams(document.location.search);

                    if (params.get('view_type') === VIEW_TYPE_MAP) this.viewTypeMap();
                    else if (params.get('view_type') === VIEW_TYPE_CATALOG) this.viewTypeCatalog();

                    this.attributes.specializationId = params.get('specialization_id');
                    this.attributes.serviceId = params.get('service_id');
                    this.attributes.cityId = params.get('city_id');
                },
                locationQueryParamsPush() {
                    let params = new URLSearchParams(document.location.search);

                    if (this.attributes.specializationId) params.set('specialization_id', this.attributes.specializationId);
                    if (this.attributes.serviceId) params.set('service_id', this.attributes.serviceId);
                    if (this.attributes.cityId) params.set('city_id', this.attributes.cityId);
                    params.set('view_type', this.viewType);

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
                    this.viewTypeMap();
                },
                setViewType(type) {
                    this.viewType = type;
                },

                showMapCity() {
                    let city = this.getCitySelected();

                    if (city && city.latitude && city.longitude) {
                        map.showCity(city.latitude, city.longitude);
                    }
                },

                getCitySelected() {
                    let index = this.cities.findIndex(item => {
                        return +item.id === +this.attributes.cityId;
                    });
                    return index !== -1 ? this.cities[index] : null;
                },
                getLinkViewExecutor(executor) {
                    /*
                     * @todo
                     * улучшить
                     */
                    let str = executor.isSalon ? 'salon-view' : 'user-view';

                    return './' + str + '?id=' + executor.id;
                }
            },
        });
    }

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
                buttonAppointment = document.createElement('a');

            buttonInfo.setAttribute('class', 'uk-button uk-button-small uk-button-default uk-float-left');
            buttonInfo.innerText = 'i';
            buttonInfo.addEventListener('click', () => {
                console.log(executor);
            });

            buttonAppointment.setAttribute('class', 'uk-button uk-button-small uk-button-link uk-float-right');
            buttonAppointment.setAttribute('href', '../appointment/create');
            buttonAppointment.setAttribute('data-window', 'true');
            buttonAppointment.setAttribute('data-window-type', 'normalModal');
            buttonAppointment.innerText = 'Записаться';
            // buttonAppointment.addEventListener('click', () => {
            //     console.log(executor);
            // });

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
</script>