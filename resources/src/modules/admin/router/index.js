import Vue from 'vue'
import VueRouter from 'vue-router'

import siteRoutes from './site'
import authRoutes from './auth'
import userRoutes from './user'

Vue.use(VueRouter)

const routes = [
  ...siteRoutes,
  ...userRoutes,
  ...authRoutes
]

const router = new VueRouter({
  routes,
  base: '/admin',
  mode: 'history'
})

export default router
