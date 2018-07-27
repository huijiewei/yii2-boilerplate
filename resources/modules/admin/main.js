import Vue from 'vue'
import ElementUI from 'element-ui'

import router from './router'
import store from './store'

import App from './App'

import HttpClient from './plugins/HttpClient'
import AclChecker from './plugins/AclChecker'

import '@admin/assets/styles/style.scss'
import '@core/assets/icons/iconfont.less'

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
