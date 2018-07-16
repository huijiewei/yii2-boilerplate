import Vue from 'vue'
import Meta from 'vue-meta'
import ElementUI from 'element-ui'

import router from './router'
import store from './store'

import App from './App'

import HttpClient from './plugins/HttpClient'

import '@admin/assets/styles/theme.scss'
import '@core/assets/icons/iconfont.less'

Vue.use(ElementUI)
Vue.use(Meta)

Vue.use(HttpClient, { store, router, Message: ElementUI.Message, MessageBox: ElementUI.MessageBox })

new Vue({
  el: '#root',
  store: store,
  router: router,
  render: h => h(App),
  beforeCreate() {
    this.$store.commit('INIT_CLIENT_ID')
  }
})
