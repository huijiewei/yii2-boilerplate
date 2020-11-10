import Vue from 'vue'
import VueRouter from 'vue-router'
import VueRouterBackButton from 'vue-router-back-button'

import siteIndex from '@mobile/views/site/Index'
import notFound from '@mobile/views/site/NotFound'

import defaultLayout from '@mobile/components/DefaultLayout'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: defaultLayout,
    children: [
      {
        path: '',
        redirect: '/home',
      },
      {
        path: '/home',
        name: 'Home',
        component: siteIndex,
        meta: {
          affix: true,
          title: '首页',
        },
      },
    ],
  },
  {
    path: '*',
    component: notFound,
  },
]

const router = new VueRouter({
  base: process.env.VUE_APP_PUBLIC_PATH,
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
  },
})

Vue.use(VueRouterBackButton, { router })

export default router
