import Vue from 'vue'

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'

import router from './router'
import store from './store'

import App from './App.vue'

import HttpClient from '@core/plugins/HttpClient'
import AclChecker from './plugins/AclChecker'
import DeleteDialog from './plugins/DeleteDialog'

Vue.use(ElementUI)

Vue.use(HttpClient, {
  apiHost: process.env.VUE_APP_ADMIN_API_HOST,
  apiToken: process.env.VUE_APP_ADMIN_API_TOKEN,
  store,
  router,
  Message: ElementUI.Message,
  MessageBox: ElementUI.MessageBox,
  loginUrl: '/login',
  loginDispatch: 'auth/showLoginModal',
  tokenGetter: 'auth/getUserToken'
})

Vue.use(AclChecker, {
  store
})

Vue.use(DeleteDialog, {
  MessageBox: ElementUI.MessageBox
})

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#root')
