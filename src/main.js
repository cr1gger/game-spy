import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import { md3 } from 'vuetify/blueprints'
import * as directives from 'vuetify/directives'
import { loadFonts } from './plugins/webfontloader'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

import { initDirectives } from "@/use/Directives"
import { initPrototypes } from "@/use/Prototypes"


initPrototypes()

const vuetify = createVuetify({
    components,
    directives,
    blueprint: md3,
    theme: {
        defaultTheme: 'dark'
    }
})

loadFonts()

const AppInstance = createApp(App)
  .use(router)
  .use(store)
  .use(vuetify)

initDirectives(AppInstance)

AppInstance.mount('#app')

document.title = 'Шпион'
