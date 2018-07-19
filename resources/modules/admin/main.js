import Vue from 'vue'
import Meta from 'vue-meta'
import ElementUI from 'element-ui'

import router from './router'
import store from './store'

import App from './App'

import HttpClient from './plugins/HttpClient'

import '@admin/assets/styles/theme.scss'
import '@core/assets/icons/iconfont.less'
import StretchSpinner from '@admin/components/spinners/StretchSpinner'

Vue.use(ElementUI)
Vue.use(Meta)

Vue.use(HttpClient, { store, router, Message: ElementUI.Message, MessageBox: ElementUI.MessageBox })

Vue.component(StretchSpinner.name, StretchSpinner)

new Vue({
  el: '#root',
  store: store,
  router: router,
  render: h => h(App),
  beforeCreate() {
    this.$store.dispatch('initClientId')
  }
})
