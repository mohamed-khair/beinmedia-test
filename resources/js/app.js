import "./bootstrap";
import Vue from "vue";
import vuetify from './plugins/vuetify'
import App from "./components/App";
import VueRouter from 'vue-router';
import router from "./router/routes";

Vue.use(VueRouter);

new Vue({
    vuetify,
    router,
    render: h => h(App)
}).$mount('#app')
