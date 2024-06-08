import './assets/style.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import AlertPlugin from './plugin/AlertPlugin';

const app = createApp(App)

app.use(router)
app.use(store)
app.use(AlertPlugin);

app.mount('#app')
