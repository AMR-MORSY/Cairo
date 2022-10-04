import './bootstrap';
import { createApp } from 'vue';

import app from "./components/app.vue";
import router from "./router";
import modal from "./components/helpers/modal.vue";////declared globally
import spinnerButton from "./components/helpers/spinnerButton.vue";
import helperTable from "./components/helpers/helperTable.vue";



createApp(app).component("modal",modal).component("spinnerButton",spinnerButton).component("helperTable",helperTable).use(router).mount("#app");

