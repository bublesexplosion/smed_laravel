import '../css/app.css';
import './bootstrap'; // arquivo padrão do Laravel
//import 'bootstrap';    // O JS do Bootstrap propriamente dito


import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// --- IMPORTAÇÕES DO GOVBR-DS ---
import '@govbr-ds/core/dist/core.min.css';
import '@govbr-ds/core/dist/core.min.js';
// -------------------------------
// --- ADICIONE O ADMINLTE ---
import 'admin-lte/dist/css/adminlte.min.css';
import 'admin-lte/dist/js/adminlte.min.js';

import '@fortawesome/fontawesome-free/css/all.min.css';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
