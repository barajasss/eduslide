import VueRouter from "vue-router";
import routes from "./routes.js";
import Vue from "vue";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes
});

export default router;
