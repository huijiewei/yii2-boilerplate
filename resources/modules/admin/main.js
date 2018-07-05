import Vue from 'vue'

import router from './router'
import store from './store'

import App from './components/App'

new Vue({
  el: '#root',
  store: store,
  router: router,
  render: h => h(App)
})
