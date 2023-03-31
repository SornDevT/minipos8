
import { createWebHistory, createRouter } from "vue-router";

import Pos from "../pages/Pos.vue";
import Report from "../pages/Report.vue";
import Store from "../pages/Store.vue";
import Transection from "../pages/Transection.vue";

export const routes = [
    {
        name: "store",
        path: "/store",
        component: Store,
    },
    {
        name: "pos",
        path: "/pos",
        component: Pos,
    },
    {
        name: "transection",
        path: "/transection",
        component: Transection,
    },
    {
        name: "report",
        path: "/report",
        component: Report,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(){
        window.scrollTo(0,0)
    }
});

export default router;