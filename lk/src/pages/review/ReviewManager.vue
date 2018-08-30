<template>
    <div>
        <h5>Отзывы</h5>

        @todo
        <ul>
            <li>Менеджер записей</li>
            <li>Действия: создание, редактирование, удаление, активация</li>
            <li>Поля: Изображения, текст, автор, статус</li>
        </ul>

        <table class="uk-table uk-table-small uk-table-striped">
            <thead>
            <tr>
                <td>Id</td>
                <td>Текст</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items">
                <td>{{item.id}}</td>
                <td>{{item.text}}</td>
            </tr>
            </tbody>
        </table>

        <div>
            <h5>Форма</h5>
            <hr>
            <v-review-form/>
        </div>
    </div>
</template>

<script>
    import VReviewForm from './ReviewFrom.vue';

    export default {
        name: "ReviewManager",
        components: {
            VReviewForm
        },
        mounted() {
        },
        data() {
            return {
                items: []
            }
        }
    }
</script>