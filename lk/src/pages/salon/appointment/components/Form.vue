<template>
    <div>
        <v-form refs="form">
            <v-select
                    v-model="attributes.status"
                    :items="getStatusList()"
                    label="Статус"
                    required
            />
            <v-select
                    v-model="attributes.client_id"
                    :items="clientList"
                    label="Клиент"
                    item-text="name"
                    item-value="id"
                    required
            />
        </v-form>

        <h5>Услуги</h5>
        <div>
            <select name="" id="" v-model="service">
                <option :value="item.id" v-for="item in serviceList">{{item.name}}</option>
            </select>
            <button
                    class="uk-button uk-button-default uk-button-small"
                    @click="onAddItem()"
            >Добавить
            </button>
        </div>

        <ul>
            <li>Время: с {{ attributes.start_date | formatDate }} до {{ endDate | formatDate }}</li>
            <li>Длительность: {{duration | formatDuration}}</li>
            <li>Общая сумма: {{ commonSum | formatCurrency }}</li>
        </ul>

        <table class="uk-table uk-table-small uk-table-divider">
            <thead>
            <tr>
                <th></th>
                <th>Название</th>
                <th>Цена</th>
                <th>Длительность</th>
                <th>Количество</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in attributes.items">
                <td>{{index +1}}</td>
                <td>{{item.service_name}}</td>
                <td>{{item.service_price | formatCurrency}}</td>
                <td>{{item.service_duration}}</td>
                <td>
                    <input
                            type="number"
                            v-model="item.quantity"
                            class="uk-input uk-form-small"
                            min="0"
                            step="1"
                            autocomplete="false"
                    >
                </td>
                <td>
                    <button
                            @click.prevent="deleteItem(index)"
                            class="uk-button uk-button-default uk-button-small"
                    >
                        <i class="mdi mdi-minus"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <v-text-input attribute="start_date" :value="attributes.start_date"/>
        <v-text-input attribute="end_date" :value="attributes.end_date"/>

        <button @click.prevent="save()">save</button>
    </div>
</template>

<script>
    import gql from 'graphql-tag';
    import dateFormat from 'dateformat';
    import Status from './Status';

    import VTextInput from '../../../../components/inputs/TextInput.vue';
    import VHiddenInput from '../../../../components/inputs/HiddenInput.vue';

    const SCENARIO_CREATE = 'create',
        SCENARIO_UPDATE = 'update';

    export default {
        name: "Form",
        props: {
            salonId: {
                type: String
            },
        },
        components: {
            VTextInput, VHiddenInput
        },
        created() {
            // Подписываемся на события родителя
            this.onCreateAppointment();
            this.onUpdateAppointment();
        },
        mounted() {
            this.loadData();
        },
        data() {
            return {
                scenario: null,
                status: new Status,

                attributes: {
                    id: null,
                    master_id: null,
                    client_id: null,
                    status: null,
                    start_date: null,
                    end_date: null,
                    items: []
                },

                duration: 0,
                service: null,
                // Список клиентов
                clientList: [],
                // Список услуг
                serviceList: [],
            }
        },
        computed: {
            // Вычисляемое свойство окончание даты
            endDate() {
                if (!this.attributes.start_date) return;

                for (var index = 0, minutes = 0, item; item = this.attributes.items[index]; index++) {
                    if (!isFinite(item.quantity) && !isFinite(item.service_duration)) continue;
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
                    if (!isFinite(item.quantity) && !isFinite(item.service_price)) continue;
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
                    salonServicesForMaster(salon_id: $salonId master_id: $masterId) {
                        id, service {id, name}, service_price, service_duration
                    },
                    clients {id, name}
                }`,
                    variables: {
                        salonId: this.salonId
                    }
                }).then(({data}) => {
                    this.serviceList = [];

                    Array.from(data.salonServices).forEach(item => {
                        this.serviceList.push({
                            id: item.service.id,
                            name: item.service.name,
                            price: item.service_price,
                            duration: item.service_duration
                        })
                    });
                    this.clientList = Array.from(data.clients);
                });
            },
            onCreateAppointment() {
                this.$parent.$on('createAppointment', appointment => {
                    this.scenarioCreate();

                    this.setAttributesForAppointment(appointment);
                });
            },
            onUpdateAppointment() {
                this.$parent.$on('updateAppointment', appointment => {
                    this.scenarioUpdate();

                    this.setAttributesForAppointment(appointment);
                });
            },

            onAddItem() {
                let index = _.findIndex(this.serviceList, {id: this.service}),
                    service = this.serviceList[index];

                this.addItem(service.id, service.name, service.price, service.duration, 1, null);
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

            setAttributesForAppointment(appointment) {
                this.clearAttributes();

                this.attributes.id = appointment.id || null;
                this.attributes.master_id = appointment.master_id;
                this.attributes.client_id = appointment.client_id || null;
                this.attributes.status = appointment.status || null;
                this.attributes.start_date = appointment.start_date;
                this.attributes.end_date = appointment.end_date;

                if (appointment.items !== undefined && Array.isArray(appointment.items)) this.addItems(appointment.items);
            },

            save() {
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
                    if (this.isScenarioCreate()) this.$emit('createdAppointment', data.appointmentCreate);
                    if (this.isScenarioUpdate()) this.$emit('updatedAppointment', data.appointmentUpdate);

                    this.clearAttributes();
                });
            },

            clearAttributes() {
                this.attributes.master_id = null;
                this.attributes.client_id = null;
                this.attributes.status = null;
                this.attributes.start_date = null;
                this.attributes.end_date = null;
                this.attributes.items = [];
            },
            getStatusList() {
                let statuses = this.status.getStatusList(),
                    statusList = [];

                for (let status in statuses) {
                    statusList.push({value: status, text: statuses[status]});
                }
                return statusList;
            },
            getStatusName(status) {
                return this.status.getStatusName(status);
            },
            scenarioCreate() {
                this.scenario = SCENARIO_CREATE;
            },
            scenarioUpdate() {
                this.scenario = SCENARIO_UPDATE;
            },
            isScenarioCreate() {
                return this.scenario === SCENARIO_CREATE;
            },
            isScenarioUpdate() {
                return this.scenario === SCENARIO_UPDATE;
            }
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
        watch: {
            '$route.params.id': function () {
                this.loadData();
            }
        }
    }
</script>