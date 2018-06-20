import Vue from 'vue'

import Element from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'

import App from './App'
import { router } from './router/index'

Vue.use(Element)

new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
