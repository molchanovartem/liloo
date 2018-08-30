<template>
    <div class="uk-width-1-5" :data-index="index">
        <div class="uk-card uk-card-default uk-padding-small uk-box-shadow-hover-large">
            <div class="uk-card-header uk-padding-remove">
                <div class="uk-float-left">
                    <i class="mdi mdi-cursor-move uk-drag portfolio-item_move"></i>
                </div>
                <div class="uk-float-right">
                    <router-link :to="{name: 'portfolioUpdate', params: {id: item.id}}">
                        <i class="mdi mdi-pencil"></i>
                    </router-link>
                    <a href="#" @click.prevent="deleteItemHandler(item.id)">
                        <i class="mdi mdi-delete"></i>
                    </a>
                </div>
            </div>
            <div>
                <div class="uk-inline">
                    <img v-if="isImage()" :src="getImageUrl()" alt="">
                    <div class="uk-text-center" v-else>Нет изображения</div>
                    <div class="uk-overlay uk-overlay-default uk-position-top uk-padding-small">
                        <h5>{{item.name}}</h5>
                    </div>
                </div>
                <p v-if="item.description !== ''" class="uk-text-truncate">{{item.description}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PortfolioItem",
        props: {
            item: {
                type: Object,
                required: true
            },
            index: {
                type: Number,
                required: true
            },
            deleteItemHandler: {
                type: Function,
                required: true
            }
        },
        data() {
          return {
              pathUrl: 'http://lilu/public/uploads/images'
          }
        },
        methods: {
            isImage() {
                return this.item.image !== null && this.item.image !== '';
            },
            getImageUrl() {
                let fileName = this.item.image,
                    dir = fileName.substr(0, 1);

                return this.pathUrl + '/' + dir + '/' + fileName;
            },
        }
    }
</script>