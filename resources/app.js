import Vue from "vue";
import App from "./App.vue";
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import BootstrapVue from 'bootstrap-vue';
import router from "./routers/router.js";
import '@fortawesome/fontawesome-free/js/all.js'

Vue.use(BootstrapVue);


new Vue({
    el: "#app",
    render: (h) => h(App),
    router,
});
