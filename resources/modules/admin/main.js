import Vue from 'vue'
import Meta from 'vue-meta'
import ElementUI from 'element-ui'

import router from './router'
import store from './store'

import App from './App'

import HttpClient from './plugins/HttpClient'

import 'element-ui/lib/theme-chalk/index.css'
import '@core/assets/icons/iconfont.less'

Vue.use(ElementUI)
Vue.use(Meta, { keyName: 'meta' })


Vue.use(HttpClient, { store, router })

new Vue({
  el: '#root',
  store: store,
  router: router,
  render: h => h(App),
  beforeCreate() {
    this.$store.commit('INIT_CLIENT_ID')
  }
})
