import Vue from 'vue'
import VueRouter from 'vue-router'
import VueRouterBackButton from 'vue-router-back-button'

import notFound from '@admin/views/site/NotFound'
import siteIndex from '@admin/views/site/Index'
import siteLogin from '@admin/views/site/Login'
import siteProfile from '@admin/views/site/Profile'

import adminRoute from './admin/admin'
import adminLogRoute from './admin/admin-log'
import adminGroupRoute from './admin/group'
import userRoute from './user/user'
import shopCategoryRoute from './shop/category'
import shopBrandRoute from './shop/brand'

import AdminLayout from '@admin/components/AdminLayout'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    component: siteLogin,
    meta: {
      breadcrumb: {
        title: '登录',
      },
    },
  },
  {
    path: '/',
    component: AdminLayout,
    children: [
      {
        path: 'home',
        component: siteIndex,
        alias: '',
        meta: {
          affix: true,
          breadcrumb: {
            title: '首页',
          },
        },
      },
      {
        path: 'profile',
        component: siteProfile,
        alias: '',
        meta: {
          breadcrumb: {
            title: '个人资料',
          },
        },
      },
      ...adminRoute,
      ...adminLogRoute,
      ...adminGroupRoute,
      ...userRoute,
      ...shopCategoryRoute,
      ...shopBrandRoute,
      {
        path: '*',
        component: notFound,
        meta: {
          breadcrumb: {
            title: '页面未找到',
          },
        },
      },
    ],
  },
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
  },
})

Vue.use(VueRouterBackButton, { router, ignoreRoutesWithSameName: true })

export default router
