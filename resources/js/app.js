//import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
import Layout from "./Shared/Layout.vue";
import '../css/app.css'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    // page.default.layout = page.default.layout || Layout
    if (page.default.layout === undefined) {
      page.default.layout = Layout;
    }
    return page
    //return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .component('Link', Link) //registered globally
      .component('Head', Head)
      .mount(el)
  },
  progress:{
    'color': 'red',
    showSpinner: true,
  },

  title: title => `My App - ${title}`
})