import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import ElementPlus from 'element-plus'
import print from 'vue3-print-nb'
import { InertiaProgress } from '@inertiajs/progress'
require('./bootstrap')

import 'element-plus/dist/index.css'
import '/assets/custom.scss'

InertiaProgress.init({
  color: '#5865F2',
  showSpinner: true,
})

createInertiaApp({
  // eslint-disable-next-line no-undef
  title: title => `${title} - Notalin`,
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(print)
      .use(ElementPlus)
      .mount(el)
  },
})
