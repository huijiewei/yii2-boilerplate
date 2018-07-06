import Vue from 'vue'

import router from './router'
import store from './store'

import App from './App'

import ElementUi from './plugins/ElementUi'
import HttpClient from './plugins/HttpClient'

Vue.use(ElementUi)
Vue.use(HttpClient)

new Vue({
  el: '#root',
  store: store,
  router: router,
  render: h => h(App)
})
