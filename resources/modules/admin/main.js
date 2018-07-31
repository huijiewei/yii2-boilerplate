import Vue from 'vue'
import ElementUI from 'element-ui'

import 'element-ui/lib/theme-chalk/index.css'

import router from './router'
import store from './store'

import App from './App'

import HttpClient from './plugins/HttpClient'
import AclChecker from './plugins/AclChecker'

Vue.use(ElementUI)

Vue.use(HttpClient, {
  store,
  router,
  Message: ElementUI.Message,
  MessageBox: ElementUI.MessageBox
})

Vue.use(AclChecker, {
  store
})

new Vue({
  el: '#root',
  store: store,
  router: router,
  render: h => h(App)
})
