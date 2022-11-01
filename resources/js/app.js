import './bootstrap';
import { createApp } from 'vue';

import app from "./components/app.vue";
import router from "./router";
import modal from "./components/helpers/modal.vue";////declared globally
import spinnerButton from "./components/helpers/spinnerButton.vue";
import helperTable from "./components/helpers/helperTable.vue";
import store from "./vuex/store";
import navbar from "./components/navbar.vue";
import VueChartkick from 'vue-chartkick';
import 'chartkick/chart.js';
import PrimeVue from 'primevue/config';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import  "primevue/resources/themes/saga-blue/theme.css";      //theme
import  "primevue/resources/primevue.min.css";                 //core css
import  "primeicons/primeicons.css";
import Card from 'primevue/card';
import Password from 'primevue/password';
import InputText from 'primevue/inputtext';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Chart from 'primevue/chart';

import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';
import Checkbox from 'primevue/checkbox';
import Tooltip from 'primevue/tooltip';
import ProgressSpinner from 'primevue/progressspinner';
import DialogService from 'primevue/dialogservice';
import DynamicDialog from 'primevue/dynamicdialog';








createApp(app)
.use(store)
.use(router)
.use(VueChartkick)
.use(PrimeVue)
.use(ToastService)
.use(DialogService)
.directive('tooltip', Tooltip)

.component("Toast",Toast)
.component("DynamicDialog",DynamicDialog)
.component("modal",modal)
.component("Dialog",Dialog)
.component("Card",Card)
.component("ProgressSpinner",ProgressSpinner)
.component("Checkbox",Checkbox)
.component("Password",Password)
.component("InputText",InputText)
.component("DataTable",DataTable)
.component("Column",Column)
.component("Chart",Chart)
.component("Button",Button)
.component("navbar",navbar)
.component("spinnerButton",spinnerButton)
.component("helperTable",helperTable)
.mount("#app");

