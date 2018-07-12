import Vue from 'vue'
import VueRouter from 'vue-router'

import siteRoutes from './site'
import userRoutes from './user'
import adminRoutes from './admin'

Vue.use(VueRouter)

const routes = [
  ...siteRoutes,
  ...userRoutes,
  ...adminRoutes
]

const router = new VueRouter({
  routes: routes,
  base: '/admin/',
  mode: 'history'
})

export default router
