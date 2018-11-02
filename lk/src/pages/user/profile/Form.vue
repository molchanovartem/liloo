<template>
    <div class="content-block p-40 content-block_shadow">
        <v-form ref="form" v-model="valid">
            <div class="uk-grid uk-grid-small uk-child-width-1-3">
                <div>
                    <v-text-field v-model="attributes.surname" label="Фамилия" :rules="rules.surname" outline/>
                </div>
                <div>
                    <v-text-field v-model="attributes.name" label="Имя" :rules="rules.name" outline/>
                </div>
                <div>
                    <v-text-field v-model="attributes.patronymic" label="Отчество" :rules="rules.patronymic" outline/>
                </div>
            </div>
            <v-text-field v-model="attributes.phone" label="Телефон" :rules="rules.phone" outline/>
            <v-textarea rows="3" v-model="attributes.description" label="Описание" outline/>

            <div class="uk-grid uk-grid-small uk-child-width-1-3">
                <div>
                    <v-autocomplete
                            :items="countryList"
                            :value="attributes.country_id"
                            @input="onChangeCountry"
                            item-text="name"
                            item-value="id"
                            label="Страна"
                            outline
                    />
                </div>
                <div>
                    <v-autocomplete
                            label="Город"
                            :value="attributes.city_id"
                            @input="onChangeCity"
                            :items="cities"
                            item-text="name"
                            item-value="id"
                            :disabled="cities.length === 0"
                            outline
                    />
                </div>
                <div>
                    <v-text-field v-model="attributes.address" label="Адрес" outline/>
                </div>
            </div>

            <v-select
                    label="Специализация"
                    v-model="attributes.specializations_id"
                    :items="specializationItems"
                    item-value="id"
                    item-text="name"
                    :rules="rules.specializationsId"
                    multiple
                    outline
            />
            <v-select
                    label="Удобства"
                    v-model="attributes.conveniences_id"
                    :items="convenienceItems"
                    item-value="id"
                    item-text="name"
                    :rules="rules.conveniencesId"
                    multiple
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

        <hr>
        <div>
            <button @click="onTest">test</button>
            <input type="file" ref="file">
        </div>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import {formRules} from "../../../js/formRules";
    import {formMixin} from "../../../js/mixins/formMixin";
    import {EVENT_SAVE} from "../../../js/eventCollection";
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
                this.$router.push({name: 'userProfileView'});
            });
        },
        mounted() {
            this.loadData();
        },
        data() {
            return {
                center: L.latLng(10, 10), // city
                url: 'http://tiles.maps.sputnik.ru/{z}/{x}/{y}.png?apikey=5032f91e8da6431d8605-f9c0c9a00357',
                attribution: '&copy; <a href="http://maps.sputnik.ru/">Спутник</a> | &copy; <a rel="nofollow" href="http://osm.org/copyright">OpenStreetMap</a> | &copy; Ростелеком',

                valid: false,
                countryList: [],
                cities: [],

                attributes: {
                    country_id: null,
                    city_id: null,
                    surname: null,
                    name: null,
                    patronymic: null,
                    date_birth: null,
                    description: null,
                    address: null,
                    phone: null,
                    specializations_id: [],
                    conveniences_id: [],
                    latitude: null,
                    longitude: null
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
                    phone: [
                        v => formRules.required(v),
                        v => formRules.number(v, {strict: true}),
                    ],
                    name: [
                        v => formRules.required(v),
                        v => formRules.length(v, {maximum: 255})
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
                return L.latLng(10, 10);
            }
        },
        methods: {
            onTest() {
                let data = new FormData();

                data.append('query', `mutation {userAvatarUpload(userId: 52, attribute: "123")}`);
                data.append('123', this.$refs.file.files[0]);

                // use the file endpoint
                fetch('http://liloo/api/lk', {
                    method: 'POST',
                    body: data
                }).then(response => {
                    return response.json()
                }).then(value => {
                    console.log(value);
                })
            },

            loadData() {
                this.$apollo.query({
                    query: gql`query {
                            specializations {id, name},
                            conveniences {id, name},
                            countries {id, name, currency_code, phone_code},
                            user {
                                id, specializations {id}, conveniences {id}, profile {
                                    country_id, city_id, surname, name, patronymic, description, date_birth, phone, address, latitude, longitude
                                }
                            }
                        }`

                }).then(({data}) => {
                    this.specializationItems = data.specializations;
                    this.convenienceItems = data.conveniences;
                    this.countryList = data.countries;

                    this.attributes.country_id = data.user.profile.country_id;
                    this.attributes.city_id = data.user.profile.city_id;
                    this.attributes.surname = data.user.profile.surname;
                    this.attributes.name = data.user.profile.name;
                    this.attributes.description = data.user.profile.description;
                    this.attributes.patronymic = data.user.profile.patronymic;
                    this.attributes.date_birth = data.user.profile.date_birth;
                    this.attributes.phone = data.user.profile.phone;
                    this.attributes.address = data.user.profile.address;
                    this.attributes.specializations_id = Array.from(data.user.specializations).map(item => {
                        return item.id
                    });
                    this.attributes.conveniences_id = Array.from(data.user.conveniences).map(item => {
                        return item.id
                    });
                    this.attributes.latitude = data.user.profile.latitude;
                    this.attributes.longitude = data.user.profile.longitude;

                    this.loadCitiesData();
                    this.updateMapCenter();
                });
            },
            loadCitiesData() {
                this.$apollo.query({
                    query: gql`query ($countryId: ID!) {
                            cities(country_id: $countryId) {id, name, latitude, longitude}
                        }`,
                    variables: {
                        countryId: this.attributes.country_id
                    }
                }).then(({data}) => {
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
                    this.$apollo.mutate({
                        mutation: gql`mutation ($specializationsId: [ID], $conveniencesId: [ID], $profile: UserProfileUpdateInput) {
                            userUpdate(attributes: {
                                    specializations_id: $specializationsId,
                                    conveniences_id: $conveniencesId,
                                    profile: $profile
                                }
                            ) {id}
                        }`,
                        variables: {
                            specializationsId: this.attributes.specializations_id,
                            conveniencesId: this.attributes.conveniences_id,
                            profile: {
                                country_id: this.attributes.country_id,
                                city_id: this.attributes.city_id,
                                surname: this.attributes.surname,
                                name: this.attributes.name,
                                patronymic: this.attributes.patronymic,
                                description: this.attributes.description,
                                phone: this.attributes.phone,
                                address: this.attributes.address,
                                latitude: this.attributes.latitude,
                                longitude: this.attributes.longitude
                            }
                        }
                    }).then(({data}) => {
                        if (data.userUpdate) {
                            this.$emit(EVENT_SAVE, data);
                        }
                    });
                }
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