import Experts from "../components/Experts";
import Schedule from "../components/Schedule";
import VueRouter from "vue-router";

const routes = [
    { path: '/', component: Experts },
    { path: '/schedule', component: Schedule }
]

const router = new VueRouter({
    routes
});

export default router;

