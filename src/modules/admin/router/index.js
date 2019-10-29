import Vue from 'vue'
import VueRouter from 'vue-router'
import VueRouterBackButton from 'vue-router-back-button'

import siteIndex from '@admin/views/site/Index'
import notFound from '@admin/views/site/NotFound'

import defaultLayout from '@admin/components/DefaultLayout'

Vue.use(VueRouter)

const routes = [
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

Vue.use(VueRouterBackButton, { router })

export default router
