import Vue from 'vue';

export const rightSidebarService = new Vue({
    methods: {
        show() {
            this.$emit('show');
        },
        showDocumentation(href) {
            this.$emit('show:documentation', href);
        }
    }
});