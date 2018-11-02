<template>
    <div class="content-block p-40 content-block_shadow">
        @todo

        <ul>
            <li>Изображение</li>
            <li>Часы работы</li>
        </ul>

        <v-form ref="form" v-model="valid">
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-1-3">
                    <v-autocomplete
                            label="Статус"
                            v-model="attributes.status"
                            :items="statusList"
                            :rules="rules.status"
                            required
                            outline
                    />
                </div>
                <div class="uk-width-2-3">
                    <v-text-field v-model="attributes.name" label="Название" outline :rules="rules.name"/>
                </div>
            </div>
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-1-4">
                    <v-autocomplete
                            :items="countryList"
                            :value="attributes.country_id"
                            @input="onChangeCountry"
                            :rules="rules.countryId"
                            item-text="name"
                            item-value="id"
                            label="Страна"
                            outline
                    />
                </div>
                <div class="uk-width-1-4">
                    <v-autocomplete
                            label="Город"
                            :value="attributes.city_id"
                            @input="onChangeCity"
                            :items="cities"
                            :rules="rules.cityId"
                            item-text="name"
                            item-value="id"
                            :disabled="cities.length === 0"
                            outline
                    />
                </div>
                <div class="uk-width-1-2">
                    <v-text-field
                            v-model="attributes.address"
                            :rules="rules.address"
                            label="Адрес"
                            outline
                    />
                </div>
            </div>

            <v-select
                    label="Специализация"
                    v-model="attributes.specializations_id"
                    :items="specializationItems"
                    item-value="id"
                    item-text="name"
                    multiple
                    :rules="rules.specializationsId"
                    outline
            />
            <v-select
                    label="Удобства"
                    v-model="attributes.conveniences_id"
                    :items="convenienceItems"
                    item-value="id"
                    item-text="name"
                    multiple
                    :rules="rules.conveniencesId"
                    outline
            />

            <l-map
                    :zoom="15"
                    :center="center"
                    @click="onMapClick"
                    style="height: 600px; z-index: 0">
                <l-tile-layer
                        :url="url"
                        :attribution="attribution"/>
                <l-marker :lat-lng="markerCoordinates" @moveend="onMoveMarker" :draggable="true"/>
            </l-map>

            <div class="uk-margin-small-top">
                <v-btn round outline large color="primary" @click="onSubmit">
                    Сохранить
                    <v-icon right>mdi-content-save</v-icon>
                </v-btn>
            </div>
        </v-form>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import {formRules} from "../../js/formRules";
    import {formMixin} from "../../js/mixins/formMixin";
    import {EVENT_SAVE} from "../../js/eventCollection";
    import {LMap, LTileLayer, LMarker, LPopup} from 'vue2-leaflet';

    delete L.Icon.Default.prototype._getIconUrl;

    L.Icon.Default.mergeOptions({
        iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
        iconUrl: require('leaflet/dist/images/marker-icon.png'),
        shadowUrl: require('leaflet/dist/images/marker-shadow.png')
    });

    import "leaflet/dist/leaflet.css";

    export default {
        mixins: [formMixin],
        components: {
            LMap,
            LTileLayer,
            LMarker,
            LPopup
        },
        created() {
            this.$on(EVENT_SAVE, () => {
                this.$router.push({name: 'salonManager'});
            });
        },
        mounted() {
            this.loadData();
        },
        props: {
            type: {
                type: String,
                required: true
            },
            id: null
        },
        data() {
            return {
                center: L.latLng(1, 1), // city
                url: 'http://tiles.maps.sputnik.ru/{z}/{x}/{y}.png?apikey=5032f91e8da6431d8605-f9c0c9a00357',
                attribution: '&copy; <a href="http://maps.sputnik.ru/">Спутник</a> | &copy; <a rel="nofollow" href="http://osm.org/copyright">OpenStreetMap</a> | &copy; Ростелеком',


                valid: false,
                countryList: [],
                cities: [],
                statusList: [
                    {value: 1, text: 'Активный'},
                    {value: 2, text: 'Не активный'}
                ],
                attributes: {
                    country_id: null,
                    city_id: null,
                    status: null,
                    name: null,
                    address: null,
                    latitude: null,
                    longitude: null,
                    specializations_id: [],
                    conveniences_id: [],
                },
                specializationItems: [],
                convenienceItems: [],
                rules: {
                    countryId: [
                        v => formRules.required(v),
                    ],
                    cityId: [
                        v => formRules.required(v),
                    ],
                    status: [
                        v => formRules.required(v),
                    ],
                    name: [
                        v => formRules.required(v),
                        v => formRules.length(v, {maximum: 255})
                    ],
                    address: [
                        v => formRules.required(v),
                    ],
                    specializationsId: [
                        v => formRules.required(v),
                    ],
                    conveniencesId: [
                        v => formRules.required(v),
                    ]
                },
            }
        },
        computed: {
            markerCoordinates() {
                if (this.attributes.latitude !== null && this.attributes.longitude !== null) {
                    return [this.attributes.latitude, this.attributes.longitude];
                }
                return L.latLng(1, 1);
            }
        },
        methods: {
            loadData() {
                if (this.type === 'update') {
                    this.requestQuery(gql`query ($id: ID!) {
                            specializations {id, name},
                            conveniences {id, name},
                            countries {id, name, currency_code, phone_code},
                            salon(id: $id) { id, country_id, city_id, status, name, address, latitude, longitude, specializations {id}, conveniences {id}}
                        }`).then(({data}) => {
                        this.specializationItems = data.specializations;
                        this.convenienceItems = data.conveniences;
                        this.countryList = data.countries;

                        this.attributes.country_id = data.salon.country_id;
                        this.attributes.city_id = data.salon.city_id;
                        this.attributes.status = data.salon.status;
                        this.attributes.name = data.salon.name;
                        this.attributes.address = data.salon.address;
                        this.attributes.specializations_id = Array.from(data.salon.specializations).map(item => {
                            return item.id
                        });
                        this.attributes.conveniences_id = Array.from(data.salon.conveniences).map(item => {
                            return item.id
                        });
                        this.attributes.latitude = data.salon.latitude;
                        this.attributes.longitude = data.salon.longitude;

                        this.loadCitiesData();
                        this.updateMapCenter();
                    });
                } else {
                    this.$apollo.query({
                        query: gql`query {
                        countries {id, name, currency_code, phone_code},
                        specializations {id, name},
                        conveniences {id, name}
                    }`
                    }).then(({data}) => {
                        this.countryList = data.countries;
                        this.specializationItems = data.specializations;
                        this.convenienceItems = data.conveniences;
                    });
                }
            },
            loadCitiesData() {
                this.requestQuery(gql`query ($countryId: ID!) {
                    cities(country_id: $countryId) {id, name, latitude, longitude}
                }`).then(({data}) => {
                    this.cities = data.cities;

                    if (this.attributes.city_id) this.updateMapCenter();
                });
            },

            onChangeCountry(value) {
                this.attributes.country_id = value;
                this.attributes.city_id = null;

                this.loadCitiesData();
            },
            onChangeCity(value) {
                this.attributes.city_id = value;
                this.attributes.latitude = null;
                this.attributes.longitude = null;

                this.updateMapCenter();
            },
            onMoveMarker(event) {
                let latlng = event.target.getLatLng();

                this.attributes.latitude = latlng.lat;
                this.attributes.longitude = latlng.lng;
                this.updateMapCenter();

            },
            onMapClick(event) {
                let latlng = event.latlng;

                this.attributes.latitude = latlng.lat;
                this.attributes.longitude = latlng.lng;
                this.updateMapCenter();
            },
            onSubmit() {
                if (this.$refs.form.validate()) {
                    if (this.type === 'create') {
                        this.add().then(({data}) => {
                            if (data.salonCreate) this.$emit(EVENT_SAVE, data);
                        });
                    } else {
                        this.update().then(({data}) => {
                            if (data.salonUpdate) this.$emit(EVENT_SAVE, data);
                        });
                    }
                }
            },

            add() {
                return this.requestMutate(gql`mutation ($attributes: SalonCreateInput!) {
                        salonCreate(attributes: $attributes) {id, name}
                    }`);
            },
            update() {
                return this.requestMutate(gql`mutation ($id: ID!, $attributes: SalonUpdateInput!) {
                        salonUpdate(id: $id, attributes: $attributes) {id, name}
                    }`);
            },
            requestQuery(ql) {
                return this.$apollo.query({
                    query: ql,
                    variables: {
                        id: this.id,
                        attributes: this.attributes,
                        countryId: this.attributes.country_id
                    }
                });
            },
            requestMutate(ql) {
                return this.$apollo.mutate({
                    mutation: ql,
                    variables: {
                        id: this.id,
                        attributes: this.attributes,
                    }
                });
            },
            updateMapCenter() {
                if (this.attributes.latitude === null && this.attributes.latitude === null) {
                    let city = this.getCitySelected();

                    if (city) {
                        this.attributes.latitude = city.latitude;
                        this.attributes.longitude = city.longitude;
                    }
                }

                this.center = L.latLng(this.attributes.latitude, this.attributes.longitude);
            },
            getCitySelected() {
                let city = this.cities.find(item => {
                    return +item.id === +this.attributes.city_id;
                });
                return city || null;
            },
        }
    }
</script>