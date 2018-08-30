<template>
    <div>
        <h4>Услуга</h4>
        <v-detail-view :attributes='serviceAttributes'/>

        <v-form @success="successForm" :request="request">
            <div class="uk-margin-small">
                <label>Название</label>
                <input type="text" :name="getInputName('portfolio_name')"
                       v-model="attributes.portfolio_name"
                       class="uk-input uk-form-small"/>
            </div>
            <div class="uk-margin-small">
                <label>Описание</label>
                <textarea :name="getInputName('portfolio_description')"
                          v-model="attributes.portfolio_description"
                          class="uk-textarea uk-form-small"></textarea>
            </div>

            <div :id="params.sortableContainerId" class="uk-grid uk-grid-small uk-child-width-1-6 uk-grid-match" uk-sortable uk-margin>
                <div v-for="(spi, index) in servicePortfolioImages"
                     :data-index="index">
                    <div class="uk-card uk-card-default uk-padding-small uk-overflow-hidden">
                        <div class="uk-clearfix">
                            <div class="uk-float-left uk-drag">
                                <i class="mdi mdi-cursor-move"></i>
                            </div>
                            <label class="uk-float-right">
                                <small>Удалить</small>
                                <input type="checkbox"
                                       :name="getPortfolioImageInputName('isDelete', spi.id)"
                                       value="1"/>
                            </label>
                        </div>
                        <input type="hidden"
                               :class="params.inputSortCssClass"
                               :name="getPortfolioImageInputName('sort', spi.id)"
                               :value="spi.sort"/>
                        <input type="hidden" :name="getPortfolioImageInputName('main', spi.id)" value="0"/>
                        <label>Основная
                            <input type="checkbox"
                                   :name="getPortfolioImageInputName('main', spi.id)"
                                   :checked="+spi.main === 1"
                                   @change="changeMain(index)"
                                   value="1"/>
                        </label>
                        <div class="uk-drag">
                            <img :src="getImageUrl(spi.file)"/>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>
            <div class="uk-flex">
                <div v-for="data in uploadFileDataList"
                     class="uk-card uk-card-default uk-margin-small-left uk-padding-small uk-overflow-hidden"
                     style="width: 200px; height: 200px">
                    <img :src="data"/>
                </div>
            </div>

            <div :id="params.dropAreaId" class="uk-placeholder uk-text-center">
                <i class="mdi mdi-cloud-upload"></i>
                <span class="uk-text-middle">Перетащите файлы сюда или </span>
                <div uk-form-custom>
                    <input :id="params.fileInputId"
                           type="file"
                           :name="getInputName('uploadImages', true)" multiple
                           @change="uploadFile($event.target.files)"/>
                    <span class="uk-link">выберите</span>
                </div>
            </div>
        </v-form>
    </div>
</template>

<script>
    import {API} from "../../js/api";
    import _ from 'lodash'
    import VForm from '../Form.vue';
    import VDetailView from '../DetailView.vue';

    export default {
        mounted() {
            this.loadData();
            this.initEventsDragAndDrop();
            this.initEventSortable();
        },
        components: {
            VForm, VDetailView
        },
        data() {
            return {
                params: {
                    dropAreaId: 'spfu_drag_area',
                    dropAreaShadowClass: 'uk-box-shadow-large',
                    fileInputId: 'spfu_file_input',
                    pathUrl: 'http://lilu/public/uploads/images',
                    sortableContainerId: 'sortable_service_portfolio_image',
                    inputSortCssClass: 'input__sort'
                },
                attributes: {
                    portfolio_name: null,
                    portfolio_description: null
                },
                serviceAttributes: {
                    id: null,
                    name: null,
                    price: null,
                    duration: null
                },
                servicePortfolioImages: [],
                uploadFileDataList: []
            }
        },
        methods: {
            loadData() {
                let id = this.$route.params.id;

                API.servicePortfolioGetItem(id, response => {
                    _.forIn(response, (value, param) => {
                        if (this.attributes[param] !== undefined) this.attributes[param] = value;
                        if (this.serviceAttributes[param] !== undefined) this.serviceAttributes[param] = value;
                    });

                    if (response.servicePortfolioImages) {
                        this.servicePortfolioImages = response.servicePortfolioImages;
                    }
                });
            },
            initEventsDragAndDrop() {
                let dropArea = document.getElementById(this.params.dropAreaId);

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(function (eventName) {
                    dropArea.addEventListener(eventName, function (event) {
                        event.preventDefault()
                    })
                });

                dropArea.addEventListener('dragenter', () => {
                    dropArea.classList.add(this.params.dropAreaShadowClass);
                });

                ['dragleave', 'drop'].forEach(() => {
                    dropArea.classList.remove(this.params.dropAreaShadowClass);
                });

                dropArea.addEventListener('drop', (event) => {
                    let fileInput = document.getElementById(this.params.fileInputId);

                    fileInput.files = event.dataTransfer.files;
                });
            },
            initEventSortable() {
                var sortable = document.getElementById(this.params.sortableContainerId);

                sortable.addEventListener('stop', (event) => {
                    var items = document.getElementById(this.params.sortableContainerId).children;

                    for (let i = 0; i < items.length; i++) {
                        let index = items[i].dataset.index;
                        this.servicePortfolioImages[index].sort = i;
                    }
                });
            },
            getInputName(attribute, multi) {
                multi = multi || false;

                let name = 'ServiceForm[' + attribute + ']';

                return multi ? name + '[]' : name;
            },
            getPortfolioImageInputName(attribute, id) {
                return 'ServicePortfolioImage[' + id + '][' + attribute + ']';
            },
            getImageUrl(file) {
                let dir = file.substr(0, 1);

                return this.params.pathUrl + '/' + dir + '/' + file;
            },
            uploadFile(files) {
                this.uploadFileDataList = [];

                for (let i = 0, file; file = files[i]; i++) {
                    if (file.type !== 'image/jpeg' && file.type !== 'image/png') continue;

                    let reader = new FileReader();

                    reader.onload = event => {
                        this.uploadFileDataList.push(event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            },
            changeMain(index) {
                this.servicePortfolioImages.forEach(item => {
                    item.main = 0;
                });
                this.servicePortfolioImages[index].main = 1;
            },
            successForm() {
                this.$router.push({name: 'serviceManager'});
            },
            request(formData, callback) {
                let id = this.$route.params.id;

                API.servicePortfolioUpdate(id, formData, callback);
            }
        }
    }
</script>