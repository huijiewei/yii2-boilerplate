import Vue from 'vue'
import Vuex from 'vuex'

import App from './App'
import router from './router'

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'

import Vuebar from 'vuebar'

Vue.use(Vuex)
Vue.use(ElementUI)
Vue.use(Vuebar)

new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
}).$mount('#app')
