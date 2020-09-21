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
import shopProductRoute from './shop/product'

import AdminLayout from '@admin/components/AdminLayout'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: siteLogin,
    meta: {
      title: '登录',
    },
  },
  {
    path: '/',
    component: AdminLayout,
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
      {
        path: '/profile',
        name: 'Profile',
        component: siteProfile,
        meta: {
          title: '个人资料',
        },
      },
      ...adminRoute,
      ...adminLogRoute,
      ...adminGroupRoute,
      ...userRoute,
      ...shopBrandRoute,
      ...shopProductRoute,
      ...shopCategoryRoute,
      {
        path: '*',
        component: notFound,
        meta: {
          title: '页面未找到',
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

Vue.use(VueRouterBackButton, { router, ignoreRoutesWithSameName: false })

export default router
