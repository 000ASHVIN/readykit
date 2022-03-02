import './bootstrap';
import './plugins';
import Vue from 'vue';
import Vuex from 'vuex';
import vuexI18n from 'vuex-i18n';
import './core/coreApp';
import './app/AppComponents';
import './app/DemoComponent'

window.Vue = Vue;


import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

import VueSimpleAlert from "vue-simple-alert";
Vue.use(VueSimpleAlert);

import 'vue-search-select/dist/VueSearchSelect.css'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
/**
 * vuex
 */
library.add(faUserSecret)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.use(BootstrapVue);
Vue.use(IconsPlugin)
Vue.use(Vuex);
import storeData from "./store/Index";
// import storeData from "./store/Index";
const store = new Vuex.Store(storeData);


/**
 * localization
 * $t('key') or this.$('key')
 * link: https://github.com/dkfbasel/vuex-i18n
 * */

Vue.use(vuexI18n.plugin, store);

// add translations directly to the application
let language = JSON.parse(window.localStorage.getItem('app-languages'));
let key = window.localStorage.getItem('app-language');
Vue.i18n.add(key, language);
// set the start locale to use
Vue.i18n.set(key);

/*------ localization end ------*/


const app = new Vue({
    store,
    el: '#app',
});
