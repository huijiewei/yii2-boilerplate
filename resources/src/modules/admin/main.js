import Vue from 'vue'
import Vuex from 'vuex'

import App from './App'
import router from './router'

import 'element-ui/lib/theme-chalk/base.css'

Vue.use(Vuex)

new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
}).$mount('#root')
