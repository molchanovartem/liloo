<template>
    <div>
        off canvas
        <div>
            <button @click="close">close</button>
        </div>
        <p v-if="isContent">
            <keep-alive>
                <component v-bind:is="content"></component>
            </keep-alive>
        </p>
    </div>
</template>

<script>
    export default {
        computed: {
            isContent() {
                return this.$store.state.offCanvasContent !== null;
            },
            content() {
                return this.$store.state.offCanvasContent;
            }
        },
        methods: {
            close() {
                this.$store.dispatch('offCanvasClose');
            }
        }
    }
</script>