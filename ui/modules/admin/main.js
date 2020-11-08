import Vue from 'vue'
import queryString from 'query-string'

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
  getApiHost: () => {
    return document
      .querySelector('meta[name="api-host"]')
      .getAttribute('content')
  },
  getAccessToken: () => {
    return store.getters['auth/getAccessToken']
  },
  setLoginAction: async (action) => {
    await store.dispatch('auth/setLoginAction', action)
  },
  setErrorMessage: async (message, historyBack) => {
    await store.dispatch('setError', {
      message: message,
      historyBack: historyBack,
    })
  },
  paramsSerializer: function (params) {
    return queryString.stringify(params, {
      arrayFormat: process.env.VUE_APP_QS_ARRAY_FORMAT || 'brackets',
    })
  },
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
