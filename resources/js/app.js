import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { VueMaskDirective } from 'v-mask';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import ToastService from 'primevue/toastservice';
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/saga-blue/theme.css'; 
import 'primevue/resources/primevue.min.css'; 
import 'primeicons/primeicons.css'; 

const vMaskV2 = VueMaskDirective;
const vMaskV3 = {
    beforeMount: vMaskV2.bind,
    updated: vMaskV2.componentUpdated,
    unmounted: vMaskV2.unbind
};

const app = createApp(App);
app.directive('mask', vMaskV3);
app.use(router); 
app.use(Toast);
app.use(ToastService);
app.use(PrimeVue);
app.mount('#app');
