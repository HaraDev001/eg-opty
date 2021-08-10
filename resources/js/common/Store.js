import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        // loader
        showLoader: false,
        // manage-account
        accountId: 0,
    },
    mutations: {
        // loader
        showLoader(state) { state.showLoader = true },
        hideLoader(state) { state.showLoader = false},
        setAccountId: (state, data) => { state.accountId = data }
    },
    getters: {
        // loader
        showLoader: state => {return state.showLoader},

        getAccountId: state => {return state.accountId},
    },
    actions: {}
});