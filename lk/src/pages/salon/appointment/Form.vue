<template>
    <div>
        <v-form v-model="valid" lazy-validation ref="form">
            <div class="uk-grid uk-grid-divider uk-grid-small">
                <div class="uk-width-1-4">
                    <!--
                    <v-select
                            v-model="attributes.status"
                            :items="getStatusList()"
                            :rules="rules.status"
                            label="Статус"
                            required
                            outline
                    />
                    -->
                    <v-text-field v-model="attributes.status" label="Статус"/>
                    <v-select
                            v-model="attributes.client_id"
                            :items="clients"
                            :rules="rules.clientId"
                            label="Клиент"
                            item-text="name"
                            item-value="id"
                            required
                            outline
                    />
                    <v-text-field v-model="attributes.start_date" label="Date start" outline/>
                    <v-text-field v-model="attributes.end_date" label="Date end" outline/>
                </div>
                <div class="uk-width-3-4">
                    <div class="uk-grid uk-grid-small uk-width-2-3">
                        <div class="uk-width-expand">
                            <v-select
                                    :items="services"
                                    v-model="serviceSelect"
                                    item-value="id"
                                    item-text="name"
                                    outline
                                    label="Услуги"
                            />
                        </div>
                        <div class="uk-width-auto">
                            <v-btn @click="onAddItem()">
                                Добавить
                                <v-icon small right>mdi-plus</v-icon>
                            </v-btn>
                        </div>
                    </div>

                    <ul>
                        <li>Время: с {{ attributes.start_date | formatDate }} до {{ endDate | formatDate
                            }}
                        </li>
                        <li>Длительность: {{duration | formatDuration}}</li>
                        <li>Общая сумма: {{ commonSum | formatCurrency }}</li>
                    </ul>

                    <v-data-table
                            :headers="headers"
                            :items="attributes.items"
                            hide-actions
                    >
                        <template slot="items" slot-scope="props, index">
                            <td>{{props.item.service_name}}</td>
                            <td>{{props.item.service_price | formatCurrency}}</td>
                            <td>{{props.item.service_duration}}</td>
                            <td>
                                <v-text-field
                                        v-model="props.item.quantity"
                                        :rules="rules.quantity"
                                />
                            </td>
                            <td>
                                <v-btn @click="deleteItem(props.index)" fab small flat>
                                    <v-icon>mdi-minus</v-icon>
                                </v-btn>
                            </td>
                        </template>
                    </v-data-table>
                </div>
            </div>
        </v-form>
        <div class="uk-card-footer uk-padding-small">
            <v-btn color="primary" @click="submit()">Сохранить
                <v-icon right>mdi-content-save</v-icon>
            </v-btn>
        </div>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import dateFormat from 'dateformat';
    import {formRules} from "../../../js/formRules";

    export default {
        name: "SalonAppointmentForm",
        props: {
            salonId: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                valid: false,
                scenario: null,
                // Клиентов
                clients: [],
                // Услуги
                services: [],

                headers: [
                    {text: 'Название', value: 'service_name', sortable: false},
                    {text: 'Цена', value: 'service_price', sortable: false},
                    {text: 'Длительность', value: 'service_duration', sortable: false},
                    {text: 'Количество', value: 'quantity', sortable: false},
                    {text: null, value: null, sortable: false}
                ],

                attributes: {
                    id: null,
                    master_id: null,
                    client_id: null,
                    status: null,
                    start_date: null,
                    end_date: null,
                    items: [
                        {
                            service_id: '1',
                            service_name: 'test',
                            service_price: '300',
                            service_duration: '20',
                            quantity: 1,
                            discount: 0
                        }
                    ]
                },

                duration: 0,
                serviceSelect: null,

                rules: {
                    status: [
                        v => formRules.required(v),
                    ],
                    clientId: [
                        v => formRules.required(v)
                    ],
                    quantity: [
                        v => formRules.required(v),
                        v => formRules.number(v, {numericality: true})
                    ]
                }
            }
        },
        computed: {
            // Вычисляемое свойство окончание даты
            endDate() {
                if (!this.attributes.start_date) return;

                for (var index = 0, minutes = 0, item; item = this.attributes.items[index]; index++) {
                    if (!isFinite(item.quantity) || !isFinite(item.service_duration)) continue;
                    if (item.quantity > 1000 || item.quantity < 0) continue;

                    minutes += +item.quantity * +item.service_duration;
                }

                let startDate = new Date(this.attributes.start_date),
                    endDate = new Date(startDate);

                endDate.setMinutes(startDate.getMinutes() + minutes);
                this.attributes.end_date = dateFormat(endDate, 'yyyy-mm-dd HH:MM:ss');
                this.duration = minutes;

                return endDate;
            },
            // Вычисляемое свойство общая сумма
            commonSum() {
                for (var index = 0, sum = 0, item; item = this.attributes.items[index]; index++) {
                    if (!isFinite(item.quantity) || !isFinite(item.service_price)) continue;
                    if (item.quantity > 1000 || item.quantity < 0 || item.service_price < 0) continue;

                    sum += +item.quantity * +item.service_duration;
                }
                return sum;
            }
        },
        methods: {
            loadData() {
                this.$apollo.query({
                    query: gql`query ($salonId: ID!, $masterId: ID!) {
                        salonServicesForMaster(salon_id: $salonId, master_id: $masterId) {
                            id, salon_id, service_id, service_price, service_duration, service{id, name}
                        }
                        clients {id, surname, name, patronymic, date_birth}
                    }`,
                    variables: {
                        salonId: this.salonId,
                        masterId: this.attributes.master_id
                    }
                }).then(({data}) => {
                    if (data.salonServicesForMaster) {
                        this.services = Array.from(data.salonServicesForMaster).map(item => {
                            return {
                                id: item.service.id,
                                name: item.service.name,
                                price: item.service_price,
                                duration: item.service_duration
                            }
                        });
                    }
                    if (data.clients) {
                        this.clients = data.clients;
                    }
                })
            },
            scenarioCreate() {
                this.scenario = 'create';
            },
            scenarioUpdate() {
                this.scenario = 'update';
            },
            isScenarioCreate() {
                return this.scenario === 'create';
            },
            isScenarioUpdate() {
                return this.scenario === 'update';
            },
            onAddItem() {
                let service = this.services.find(item => {
                    return +item.id === +this.serviceSelect;
                });

                if (service) {
                    this.addItem(service.id, service.name, service.price, service.duration, 1, null);
                }
            },
            addItems(items = []) {
                items.forEach(item => {
                    this.addItem(
                        item.service_id,
                        item.service_name,
                        item.service_price,
                        item.service_duration,
                        item.quantity,
                        null
                    )
                });
            },
            // Добавляет услугу в список услуг
            addItem(
                serviceId,
                serviceName,
                servicePrice,
                serviceDuration,
                quantity,
                discount
            ) {
                this.attributes.items.push({
                    service_id: serviceId,
                    service_name: serviceName,
                    service_price: servicePrice,
                    service_duration: serviceDuration,
                    quantity: quantity,
                    discount: discount
                });
            },
            deleteItem(index) {
                this.attributes.items.splice(index, 1);
            },

            setAttributes(attributes) {
                this.clearData();

                this.attributes.id = attributes.id || null;
                this.attributes.master_id = attributes.master_id;
                this.attributes.client_id = attributes.client_id || null;
                this.attributes.status = attributes.status || null;
                this.attributes.start_date = attributes.start_date;
                this.attributes.end_date = attributes.end_date;

                if (attributes.items !== undefined && Array.isArray(attributes.items)) this.addItems(attributes.items);
            },

            submit() {
                if (this.attributes.items.length === 0) {
                    alert('Нет услуг');
                    return;
                }

                if (!this.$refs.form.validate()) {
                    console.log(this.attributes);
                    return;
                }

                let gl = null;

                if (this.isScenarioCreate()) {
                    gl = gql`mutation (
                            $attributes: AppointmentCreateInput!
                      ) {
                        appointmentCreate(
                            attributes: $attributes
                          ) {
                                id, user_id, master_id, salon_id, client_id, status, start_date, end_date,
                                items {
                                  id, appointment_id, service_id, service_name, service_price, service_duration, quantity
                                },
                                client {id, surname, name, patronymic, date_birth}
                          }
                    }`
                } else if (this.isScenarioUpdate()) {
                    gl = gql`mutation (
                            $id: ID!,
                            $attributes: AppointmentUpdateInput!
                      ) {
                        appointmentUpdate(
                            id: $id,
                            attributes: $attributes
                          ) {
                                id, user_id, master_id, salon_id, client_id, status, start_date, end_date,
                                items {
                                  id, appointment_id, service_id, service_name, service_price, service_duration, quantity
                                },
                                client {id, surname, name, patronymic, date_birth}
                          }
                    }`
                }

                this.$apollo.mutate({
                    mutation: gl,
                    variables: {
                        id: this.attributes.id,
                        attributes: {
                            salon_id: this.salonId,
                            master_id: this.attributes.master_id,
                            client_id: this.attributes.client_id,
                            status: this.attributes.status,
                            start_date: this.attributes.start_date,
                            end_date: this.attributes.end_date,
                            items: this.attributes.items.map(item => {
                                return {service_id: item.service_id, quantity: item.quantity}
                            })
                        }
                    }
                }).then(({data}) => {
                    if (data.appointmentCreate || data.appointmentUpdate) {
                        this.$emit('save', data.appointmentCreate || data.appointmentUpdate);

                        if (this.isScenarioCreate()) this.$emit('created', data.appointmentCreate);
                        else this.$emit('updated', data.appointmentUpdate);
                    }
                });
            },

            clearData() {
                this.clients = [];
                this.services = [];
                this.attributes.id = null;
                this.attributes.master_id = null;
                this.attributes.client_id = null;
                this.attributes.status = null;
                this.attributes.start_date = null;
                this.attributes.end_date = null;
                this.attributes.items = [];
            },
        },
        filters: {
            formatDate(value) {
                var date = new Date(value);

                function format(value) {
                    return value < 10 ? '0' + value : value;
                }

                return format(date.getHours()) + ':' + format(date.getMinutes());
            },
            // Формаирует количество минут
            formatDuration(minute) {
                var seconds = minute * 60,
                    minutes = Math.floor(seconds / 60 % 60),
                    hours = Math.floor(seconds / 3600 % 24);

                function format(value) {
                    return value < 10 ? '0' + value : value;
                }

                return format(hours) + ':' + format(minutes);
            },
            // Форматирует число
            formatCurrency(value) {
                return new Intl.NumberFormat('ru-RU', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(value);
            }
        },
    }
</script>