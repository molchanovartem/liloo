function cityWidget() {
    new Vue({
        el: '#cities',
        created() {
            this.show = true;
        },
        mounted() {
            if (!this.isCityLocalStorage()) {
                this.loadData()
                    .then(() => {
                        this.defineClientCity();
                    });
            } else this.setCity(this.getCityLocalStorage());
        },
        data: {
            show: false,
            open: false,
            city: null,
            defaultCityId: 1250,
            cities: [],
            attributes: {
                cityId: null,
            }
        },
        computed: {
            cmdCityName() {
                return this.city ? this.city.name : 'Город не определен'
            }
        },
        methods: {
            loadData() {
                return new Promise((resolve, reject) => {
                    cSpinner.show();
                    $.post('http://liloo/api/common', JSON.stringify({
                        query: `query ($countryId: ID!) {
                        cities(country_id: $countryId) {id, prefix, name, latitude, longitude}
                    }`,
                        variables: {
                            countryId: 1
                        }
                    }))
                        .then(({data}) => {
                            cSpinner.hide();
                            this.cities = data.cities;
                            resolve(true);
                        });
                });
            },
            defineClientCity() {
                $.get('http://ip-api.com/json')
                    .done(data => {
                        if (data) {
                            let city = this.getCityByName(data.city);

                            this.setCity(city);
                            this.setCityLocalStorage(city);
                        }
                    })
                    .fail(

                    );
            },
            onToggle() {
                if (this.open) {
                    this.open = false;
                    return;
                }

                if (this.cities.length === 0) {
                    this.loadData()
                        .then(() => {
                            this.open = true;
                        });
                } else this.open = true;
            },
            onChangeCityId(id) {
                let city = this.getCityById(id);

                if (city) {
                    this.setCity(city);
                    this.setCityLocalStorage(city);
                }
            },
            getCityById(id) {
                let city = this.cities.find(item => {
                    return +item.id === +id;
                });

                return city || null;
            },
            getCityByName(name) {
                let defaultCity = null,
                    city = null;

                this.cities.forEach(item => {
                    if (item.prefix.toLowerCase() === name.toLowerCase()) city = item;
                    if (+item.id === this.defaultCityId) defaultCity = item;
                });

                return city || defaultCity || null
            },
            isCityLocalStorage() {
                return this.getCityLocalStorage() !== null;
            },
            getCityLocalStorage() {
                let city = localStorage.getItem('city');

                return city !== null ? JSON.parse(city) : null;
            },
            setCity(city) {
                this.city = city;
                this.attributes.cityId = city.id;
            },
            setCityLocalStorage(city) {
                localStorage.setItem('city', JSON.stringify(city));
            },
        }
    });
}