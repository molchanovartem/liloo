<template>
    <div>
        <v-form @success="successForm" :request="request">
            <v-hidden-input formName="PortfolioForm" attribute="sort" :value="attributes.sort"/>
            <v-hidden-input formName="PortfolioForm" attribute="salon_id" :value="attributes.salon_id"/>

            <v-select formName="PortfolioForm" attribute="service_id" label="Услуга" :value="attributes.service_id"
                      :items="serviceItems" textAttribute="name"/>

            <v-image-file-input formName="PortfolioForm" attribute="image" label="Основное изображение"
                                :value="attributes.image" pathUrl="http://lilu/public/uploads/images"/>

            <v-text-input formName="PortfolioForm" attribute="name" label="Название" :value="attributes.name"/>
            <v-text-area formName="PortfolioForm" attribute="description" label="Описание"
                         :value="attributes.description"/>

            <div v-show="portfolioImages.length > 0"
                 :id="params.sortableContainerId"
                 class="uk-grid uk-grid-small uk-child-width-1-6 uk-grid-match"
                 uk-sortable
                 uk-margin>
                <div v-for="(pi, index) in portfolioImages"
                     :data-index="index">
                    <div class="uk-card uk-card-default uk-padding-small uk-overflow-hidden">
                        <div class="uk-clearfix">
                            <div class="uk-float-left uk-drag">
                                <i class="mdi mdi-cursor-move"></i>
                            </div>
                            <label class="uk-float-right">
                                <small>Удалить</small>
                                <input type="checkbox"
                                       :name="getPortfolioImageInputName('isDelete', pi.id)"
                                       value="1"
                                       class="uk-checkbox"/>
                            </label>
                        </div>
                        <input type="hidden"
                               :class="params.inputSortCssClass"
                               :name="getPortfolioImageInputName('sort', pi.id)"
                               :value="pi.sort"/>
                        <div class="uk-drag">
                            <img :src="getImageUrl(pi.file)"/>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>
            <div class="uk-flex">
                <div v-for="data in uploadFiles"
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
    import VForm from '../Form.vue';
    import VTextInput from '../inputs/TextInput.vue';
    import VTextArea from '../inputs/TextArea.vue';
    import VImageFileInput from '../inputs/ImageFileInput.vue';
    import VHiddenInput from '../inputs/HiddenInput.vue';
    import VSelect from '../inputs/Select.vue';

    export default {
        mounted() {
            if (this.type === 'update') this.loadData();
            this.initEventsDragAndDrop();
            this.initEventSortable();


            let salonId = this.$route.query.salon_id;

            if (this.type == 'create' && salonId) this.attributes.salon_id = salonId;
        },
        components: {
            VForm, VTextInput, VTextArea, VImageFileInput, VHiddenInput, VSelect
        },
        props: {
            type: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                params: {
                    dropAreaId: 'pf_drag_area',
                    dropAreaShadowClass: 'uk-box-shadow-large',
                    pathUrl: 'http://lilu/public/uploads/images',
                    fileInputId: 'pf_file_input',
                    sortableContainerId: 'sortable_portfolio_image',
                    inputSortCssClass: 'input__sort'
                },
                attributes: {
                    user_id: null,
                    salon_id: null,
                    service_id: null,
                    sort: null,
                    name: null,
                    description: null,
                    image: null
                },
                userItems: [],
                salonItems: [],
                serviceItems: [],
                portfolioImages: [],
                uploadFiles: []
            }
        },
        methods: {
            loadData() {
                let id = this.$route.params.id;


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
                        this.portfolioImages[index].sort = i;
                    }
                });
            },
            isImage() {
                return this.attributes.image !== null && this.attributes.image !== '';
            },
            getInputName(attribute, multi) {
                multi = multi || false;

                let name = 'PortfolioForm[' + attribute + ']';

                return multi ? name + '[]' : name;
            },
            getPortfolioImageInputName(attribute, id) {
                return 'PortfolioImage[' + id + '][' + attribute + ']';
            },
            getImageUrl(file) {
                let dir = file.substr(0, 1);

                return this.params.pathUrl + '/' + dir + '/' + file;
            },
            uploadFile(files) {
                this.uploadFiles = [];

                for (let i = 0, file; file = files[i]; i++) {
                    if (file.type !== 'image/jpeg' && file.type !== 'image/png') continue;

                    let reader = new FileReader();

                    reader.onload = event => {
                        this.uploadFiles.push(event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            },
            successForm() {
                this.$router.push({name: 'portfolioManager', query: {salon_id: this.attributes.salon_id}});
            },
            request(formData, callback) {

            }
        }
    }
</script>