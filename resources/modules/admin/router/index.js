import Vue from 'vue'
import VueRouter from 'vue-router'

import siteRoutes from './site'
import userRoutes from './user'

Vue.use(VueRouter)

const routes = [
  ...siteRoutes,
  ...userRoutes
]

const router = new VueRouter({
  routes: routes,
  base: '/admin/',
  mode: 'history'
})

export default router
