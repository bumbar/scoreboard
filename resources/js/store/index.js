import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        cities: [],
        query: ''
    },
    mutations: {
        addCity(state, payload) {
            state.cities = payload.id;
            state.query = payload.query;
        },
        addFromOrToCity(state, payload) {
            state.cities = payload.id;
            state.query = payload.query;
        },
    },
    getters: {
        citiesCount(state) {
            return state.cities.length;
        }
    },
    actions: {
        addCity({ state, commit }, payload) {
            axios.get('/departures?' + payload.query + '=' + payload.id, { name: payload })
                .then(() => {
                    commit('addCity', payload)
                })
        },
        addFromOrToCity({ state, commit }, payload) {
            axios.get('/departures?' + payload.query + '=' + payload.id, { name: payload })
                .then(() => {
                    commit('addFromOrToCity', payload)
                })
        },
    }
});

export default store
