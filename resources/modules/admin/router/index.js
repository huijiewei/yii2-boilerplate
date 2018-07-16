import Vue from 'vue'
import VueRouter from 'vue-router'
import { routerHistory, writeHistory } from 'vue-router-back-button'

import siteRoutes from './site'
import userRoutes from './user'
import adminRoutes from './admin'

Vue.use(VueRouter)
Vue.use(routerHistory)

const routes = [
  ...userRoutes,
  ...adminRoutes,
  ...siteRoutes
]

const router = new VueRouter({
  routes: routes,
  base: '/admin/',
  mode: 'history'
})

router.afterEach(writeHistory)

export default router
