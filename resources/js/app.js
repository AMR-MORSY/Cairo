import './bootstrap';
import { createApp } from 'vue';

import app from "./components/app.vue";
import router from "./router";
import modal from "./components/helpers/modal.vue";////declared globally
import spinnerButton from "./components/helpers/spinnerButton.vue";
import helperTable from "./components/helpers/helperTable.vue";
import store from "./vuex/store";
import navbar from "./components/navbar.vue"



createApp(app).component("modal",modal).component("navbar",navbar).component("spinnerButton",spinnerButton).component("helperTable",helperTable).use(store).use(router).mount("#app");

