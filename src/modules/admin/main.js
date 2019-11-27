import Vue from 'vue'

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'

import router from './router'
import store from './store'

import App from './App.vue'

import './registerServiceWorker'

import HttpClient from '@core/plugins/HttpClient'
import DeleteDialog from './plugins/DeleteDialog'
import PermissionCheck from './plugins/PermissionCheck'

Vue.use(ElementUI)

Vue.use(HttpClient, {
  apiHost: process.env.VUE_APP_ADMIN_API_HOST,
  store,
  getAccessTokenGetter: 'auth/getAccessToken',
  setLoginActionDispatch: 'auth/setLoginAction',
  setErrorDispatch: 'setError'
})

Vue.use(PermissionCheck, {
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
