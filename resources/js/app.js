require("./bootstrap");

window.Vue = require("vue").default;

import App from "./components/App";
import router from "./router/index";
import VueToast from "vue-toast-notification";
import Vuex from "vuex";
import "vue-toast-notification/dist/theme-sugar.css";
import axios from "axios";
import store from "./store/index";

axios.defaults.baseURL = "http://localhost:8000/api";
axios.defaults.homeURL = "http://localhost:8000/";
axios.interceptors.request.use(
    function(config) {
        const token = localStorage.getItem("access_token");
        if (!config.headers.Authorization) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    err => {
        return Promise.reject(err);
    }
);

Vue.use(VueToast, {
    position: "top"
});

const app = new Vue({
    el: "#app",
    router,
    store,
    render: h => h(App)
});
