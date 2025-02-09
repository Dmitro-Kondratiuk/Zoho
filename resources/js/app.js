import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import Toast from 'vue3-toastify';
import 'vue3-toastify/dist/index.css'; // обов'язково імпортуйте стилі

createInertiaApp({
    resolve: name => import(`./Pages/${name}.vue`),
    setup({ el, App, props }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(Toast); // Підключаємо плагін
        app.mount(el);
    },
});
