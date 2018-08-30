<template>
    <div>
        <v-appointment-user-list :salonId="salonId"/>

        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:1000px;'>
            <div class="dhx_cal_navline">
                <div class="dhx_cal_prev_button">&nbsp;</div>
                <div class="dhx_cal_next_button">&nbsp;</div>
                <div class="dhx_cal_today_button"></div>
                <div class="dhx_cal_date"></div>
                <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
                <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
            </div>
            <div class="dhx_cal_header"></div>
            <div class="dhx_cal_data"></div>
        </div>

        <div id="scheduller_modal" class="uk-modal-container" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="modal-content">
                    <v-form @success="successForm" :request="request">
                        <v-select formName="AppointmentForm"
                                  attribute="status"
                                  label="Статус"
                                  v-model="attributes.status"
                                  :items="statusList"
                                  valueAttribute="value"
                                  textAttribute="text"
                        />

                        <v-select
                                formName="AppointmentForm"
                                attribute="clientId"
                                label="Клиент"
                                v-model="attributes.clientId"
                                :items="clientList"
                                valueAttribute="id"
                                textAttribute="name"
                        />

                        <h5>Услуги</h5>

                        <div>
                            <select name="" id="" v-model="service">
                                <option :value="item.id" v-for="item in serviceList">{{item.name}}</option>
                            </select>
                            <button
                                    class="uk-button uk-button-default uk-button-small"
                                    @click="onAddServices()"
                            >Добавить
                            </button>
                        </div>

                        <ul>
                            <li>Время: с {{ attributes.startDate | formatDate }} до {{ endDate | formatDate }}</li>
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
                            <tr v-for="(appointmentService, index) in attributes.services">
                                <td>{{index +1}}</td>
                                <td>{{appointmentService.serviceName}}</td>
                                <td>{{appointmentService.servicePrice | formatCurrency}}</td>
                                <td>{{appointmentService.serviceDuration}}</td>
                                <td>
                                    <input
                                            type="number"
                                            name="AppointmentForm"
                                            v-model="appointmentService.quantity"
                                            class="uk-input uk-form-small"
                                            min="0"
                                            step="1"
                                            autocomplete="false"
                                    >
                                </td>
                                <td>
                                    <button
                                            @click.prevent="deleteService(index)"
                                            class="uk-button uk-button-default uk-button-small"
                                    >
                                        <i class="mdi mdi-minus"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <v-hidden-input formName="AppointmentForm" attribute="start_date"
                                        :value="attributes.startDate"/>
                        <v-hidden-input formName="AppointmentForm" attribute="end_date"
                                        :value="attributes.endDate"/>

                        <button @click.prevent="onSave()">save</button>
                    </v-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import 'dhtmlx-scheduler/codebase/dhtmlxscheduler.css';
    import 'dhtmlx-scheduler/codebase/dhtmlxscheduler.js';
    import _ from 'lodash';
    import UIkit from 'uikit/dist/js/uikit';
    import dateFormat from 'dateformat';
    import {API} from "../../js/api";
    import VForm from '../Form.vue';
    import VTextInput from '../inputs/TextInput.vue';
    import VSelect from '../inputs/Select.vue';
    import VHiddenInput from '../inputs/HiddenInput.vue';
    import VAppointmentUserList from './AppointmentUserList';

    export default {
        name: "Appointment",
        props: {
            salonId: null,
            userId: null,
            employeeId: null
        },
        mounted() {
            // Инициализируем календарь
            this.initScheduller();

            // Загружаем список клиентов
            API.clientGetItems({}, response => {
                this.clientList = response;
            });
            // Загружаем список услуг
            API.serviceGetItems(response => {
                this.serviceList = response;
            });
        },
        components: {
            VForm, VTextInput, VSelect, VHiddenInput, VAppointmentUserList
        },
        data() {
            return {
                isOpen: true,
                attributes: {
                    status: null,
                    clientId: null,
                    services: [],
                    startDate: null,
                    endDate: null
                },
                statusList: [
                    {value: 1, text: 'Выполнен'},
                    {value: 0, text: 'Не выполнен'},
                ],
                duration: 0, // ??? не помню для чего сделал
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
                if (!this.attributes.startDate) return;

                let minutes = 0;

                for (let index = 0, appointmentService; appointmentService = this.attributes.services[index]; index++) {
                    if (!isFinite(appointmentService.quantity) && !isFinite(appointmentService.serviceDuration)) continue;
                    if (appointmentService.quantity > 1000 || appointmentService.quantity < 0) continue;

                    minutes += +appointmentService.quantity * +appointmentService.serviceDuration;
                }

                let startDate = new Date(this.attributes.startDate),
                    endDate = new Date(startDate);

                endDate.setMinutes(startDate.getMinutes() + minutes);
                this.attributes.endDate = dateFormat(endDate, 'yyyy-mm-dd HH:MM:ss');
                this.duration = minutes;

                return endDate;
            },
            // Вычисляемое свойство общая сумма
            commonSum() {
                let sum = 0;

                for (let index = 0, appointmentService; appointmentService = this.attributes.services[index]; index++) {
                    if (!isFinite(appointmentService.quantity) && !isFinite(appointmentService.servicePrice)) continue;
                    if (appointmentService.quantity > 1000 || appointmentService.quantity < 0 || appointmentService.servicePrice < 0) continue;

                    sum += +appointmentService.quantity * +appointmentService.serviceDuration;
                }

                return sum;
            }
        },
        methods: {
            initScheduller() {
                this.scheduller = Scheduler.getSchedulerInstance();

                this.initSchedullerConfig();
                this.initSchedullerEvents();

                this.scheduller.init('scheduler_here', new Date, 'month');
            },
            // Конфигурация
            initSchedullerConfig() {
                this.scheduller.config.api_date = "%Y-%m-%d %H:%i";
                this.scheduller.config.xml_date = "%Y-%m-%d %H:%i";
                this.scheduller.config.details_on_dblclick = false;
                this.scheduller.config.details_on_create = true;
                this.scheduller.config.drag_create = false;
                this.scheduller.config.drag_resize = false;

                this.scheduller.showLightbox = (id) => {
                    let modal = UIkit.modal('#scheduller_modal');

                    let event = this.scheduller.getEvent(id);

                      if (event) {
                        // Загрузка данных
                        this.attributes.clientId = event.client_id;
                        this.attributes.status = event.status;
                        this.attributes.startDate = dateFormat(event.start_date, 'yyyy-mm-dd HH:MM:ss');
                        this.attributes.endDate = dateFormat(event.end_date, 'yyyy-mm-dd HH:MM:ss');
                    }
                    modal.show();
                };
            },
            // Инициализируем события
            initSchedullerEvents() {
                // Событие закрыть модальное окно
                document.getElementById('scheduller_modal').addEventListener('hide', () => {
                    scheduler.endLightbox(false);

                    // Обнуляем значения
                    this.attributes.status = null;
                    this.attributes.clientId = null;
                    this.attributes.services = [];
                    this.attributes.startDate = null;
                    this.attributes.endDate = null;
                });

                this.scheduller.attachEvent('onSchedulerReady', () => {
                });

                // Обработчик если нажали на пустое место в журнале
                this.scheduller.attachEvent('onEmptyClick', (date, e) => {
                    // Для вызова окна, создаем и удалем "event"
                    this.scheduller.deleteEvent(this.scheduller.addEventNow(date), true);
                });

                this.scheduller.attachEvent("onDblClick", (id, e) => {
                   return false;
                });

                this.scheduller.attachEvent("onClick", (id, e) => {
                    let event = this.scheduller.getEvent(id);

                    this.scheduller.showLightbox(id);

                      return true;
                });
            },
            // Добавляет услугу в список услуг
            addService(service) {
                let index = _.findIndex(this.attributes.services, {serviceId: service.id});

                if (index === -1) {
                    this.attributes.services.push({
                        serviceId: service.id,
                        serviceName: service.name,
                        servicePrice: service.price,
                        serviceDuration: service.duration,
                        quantity: 1,
                        discount: null
                    });
                }
            },
            onAddServices() {
                let index = _.findIndex(this.serviceList, {id: this.service});

                this.addService(this.serviceList[index]);
            },
            // Удаляет услугу из списка услуг
            deleteService(index) {
                this.attributes.services.splice(index, 1);
            },
            // Обработчик успешной работы формы
            successForm() {
                console.log('Success Form');
            },
            // Обработчик запроса
            request() {
                console.log('Request');
            },
            onSave() {
                // добавляем event
                this.scheduller.addEvent({
                    salon_id: this.salonId,
                    user_id: this.userId,
                    client_id: this.attributes.clientId,
                    status: this.attributes.status,
                    start_date: this.attributes.startDate,
                    end_date: this.attributes.endDate
                })
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
        }
    }
</script>