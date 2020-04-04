require('./bootstrap');

window.Vue = require('vue');


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import helpers from './helpers';
Vue.use({
    install() {
        Vue.helpers = helpers;
        Vue.prototype.$helpers = helpers;
    }
});

import DropDown from './components/DropDown'
import Board from './components/Board'

import store from './store/index'

const app = new Vue({
    el: '#app',
    store,
    components: {
        'drop-down': DropDown,
        'board': Board
    }
});
