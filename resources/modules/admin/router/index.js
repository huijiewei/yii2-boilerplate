import Vue from 'vue'
import VueRouter from 'vue-router'
import { routerHistory, writeHistory } from 'vue-router-back-button'

import userRoutes from './user'
import adminRoutes from './admin'

import siteIndex from '@admin/views/site/Index'
import siteLogin from '@admin/views/site/Login'
import notFound from '@admin/views/site/NotFound'

import defaultLayout from '@admin/layouts/Default'

Vue.use(VueRouter)
Vue.use(routerHistory)

const routes = [
  {
    path: '/',
    component: defaultLayout,
    meta: {
      breadcrumb: {
        title: '管理后台',
        link: 'site-index',
        icon: 'home'
      }
    },
    children: [
      {
        name: 'site-index',
        path: '',
        component: siteIndex,
        meta: {
          breadcrumb: {
            title: '首页'
          }
        }
      },
      ...userRoutes,
      ...adminRoutes
    ]
  },
  {
    name: 'login',
    path: '/login',
    component: siteLogin
  },
  {
    path: '*',
    component: notFound
  }
]

const router = new VueRouter({
  routes: routes,
  base: '/admin',
  mode: 'history'
})

router.afterEach(writeHistory)

export default router
