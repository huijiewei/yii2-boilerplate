import Vue from 'vue'
import VueRouter from 'vue-router'
import { routerHistory, writeHistory } from 'vue-router-back-button'

import userRoutes from './user'
import adminRoutes from './admin'

import siteIndex from '@admin/views/site/Index'
import siteLogin from '@admin/views/site/Login'
import notFound from '@admin/views/site/NotFound'

import defaultLayout from '@admin/components/DefaultLayout'

Vue.use(VueRouter)
Vue.use(routerHistory)

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
  routes: routes,
  scrollBehavior: (to, from, savedPosition) => {
    if (savedPosition) {
      return savedPosition
    }

    if (to.hash) {
      return { selector: to.hash }
    }

    return { x: 0, y: 0 }
  }
})

router.afterEach(writeHistory)

export default router
