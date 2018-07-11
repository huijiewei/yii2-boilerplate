import Vue from 'vue'

import router from './router'
import store from './store'

import App from './App'

import ElementUi from './plugins/ElementUi'
import HttpClient from './plugins/HttpClient'

import '@core/assets/icons/iconfont.less'

Vue.use(ElementUi)

Vue.use(HttpClient, { store, router })

new Vue({
  el: '#root',
  store: store,
  router: router,
  render: h => h(App)
})
