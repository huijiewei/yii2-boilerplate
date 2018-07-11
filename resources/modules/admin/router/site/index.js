import siteIndex from '@admin/views/templates/site/Index'
import siteAbout from '@admin/views/templates/site/About'

import main from '@admin/views/layouts/Main'

const routes = [
  {
    path: '/',
    component: main,
    children: [
      {
        path: '',
        component: siteIndex
      },
      {
        path: '/about',
        component: siteAbout
      }
    ]
  },
  {
    path: '/login',
    component: () => import(/* webpackChunkName: "login" */ '@admin/views/templates/site/Login')
  },
  {
    path: '*',
    component: () => import(/* webpackChunkName: "404" */ '@admin/views/templates/site/NotFound')
  }
]

export default routes
