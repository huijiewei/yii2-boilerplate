import Vue from 'vue'
import Vuex from 'vuex'

import routers from './routers'

import App from './components/App'

Vue.use(Vuex)

new Vue({
  el: '#root',
  router: routers,
  render: h => h(App),
  components: { App }
})
