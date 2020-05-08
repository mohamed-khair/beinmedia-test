import "./bootstrap";
import Vue from "vue";
import vuetify from './plugins/vuetify'


const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


new Vue({
    vuetify,
}).$mount('#app')
