import './bootstrap'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'

import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
import Cleave from 'vue-cleave-component'
import Pagination from './components/Pagination.vue'
import Vue3Storage from "vue3-storage"

const app = createApp(App)
app.config.globalProperties.$axios = axios
app.use(Vue3Storage, { namespace: "pro_" })
app.use(router)
app.use(Cleave)
app.use(VueSweetalert2)
app.component('pagination',Pagination)
app.mount("#app-vue")
