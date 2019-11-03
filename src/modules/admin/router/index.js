import Vue from 'vue'
import VueRouter from 'vue-router'
import VueRouterBackButton from 'vue-router-back-button'

import siteIndex from '@admin/views/site/Index'
import notFound from '@admin/views/site/NotFound'
import siteLogin from '@admin/views/site/Login'

import adminRoutes from './admin'
import userRoutes from './user'

import defaultLayout from '@admin/components/DefaultLayout'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: defaultLayout,
    children: [
      ...adminRoutes,
      ...userRoutes,
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
  duplicateNavigationPolicy: 'ignore',
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

Vue.use(VueRouterBackButton, { router })

export default router
