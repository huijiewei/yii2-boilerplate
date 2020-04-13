import Vue from 'vue'

import ElementUI from 'element-ui'

import router from './router'
import store from './store'

import App from './App.vue'

import HttpClient from '@core/plugins/HttpClient'
import DeleteDialog from './plugins/DeleteDialog'
import PermissionCheck from './plugins/PermissionCheck'

Vue.use(ElementUI)

Vue.use(HttpClient, {
  apiHost: document
    .querySelector('meta[name="api-host"]')
    .getAttribute('content'),
  store,
  getAccessTokenGetter: 'auth/getAccessToken',
  setLoginActionDispatch: 'auth/setLoginAction',
  setErrorDispatch: 'setError',
})

Vue.use(PermissionCheck, {
  store,
})

Vue.use(DeleteDialog, {
  MessageBox: ElementUI.MessageBox,
})

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount('#root')
