import "./bootstrap";
import Vue from "vue";
import vuetify from './plugins/vuetify'
import App from "./components/App";
import VueRouter from 'vue-router';
import router from "./router/routes";
import VuetifyToast from 'vuetify-toast-snackbar'
import moment from "moment";

Vue.use(VuetifyToast);
Vue.use(VueRouter);

Vue.prototype.$moment = moment;

new Vue({
    vuetify,
    router,
    render: h => h(App)
}).$mount('#app')
