import Vue from 'vue'
import VueRouter from 'vue-router'

import userRoutes from './user'
import adminRoutes from './admin'

import siteIndex from '@admin/views/site/Index'
import siteLogin from '@admin/views/site/Login'
import notFound from '@admin/views/site/NotFound'

import defaultLayout from '@admin/components/DefaultLayout'

Vue.use(VueRouter)

const routes = [
  ...userRoutes,
  ...adminRoutes,
  {
    path: '/',
    component: defaultLayout,
    children: [
      {
        path: 'home',
        component: siteIndex,
        alias: '',
        meta: {
          breadcrumb: {
            title: '首页'
          }
        }
      }
    ]
  },
  {
    path: '/login',
    component: siteLogin
  },
  {
    path: '*',
    component: notFound
  }
]

const router = new VueRouter({
  base: '/admin',
  mode: 'history',
  routes: routes
})

export default router
