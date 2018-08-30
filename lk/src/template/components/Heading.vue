<template>
    <div v-if="text">
        <slot :text="text"><h1>{{text}}</h1></slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        computed: {
            text() {
                return this.$route.meta.title;
            }
        }
    }
</script>