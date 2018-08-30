import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        params: null,
        heading: null,
        breadcrumbItems: [],
    },
    mutations: {
        setParams(state, params) {
          state.params = params;
        },
        setHeading(state, text) {
            state.heading = text;
        },
        addBreadcrumbItems(state, items) {
            state.breadcrumbItems = items;
        },
    }
});