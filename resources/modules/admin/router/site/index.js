import siteIndex from '@admin/views/site/Index'
import siteAbout from '@admin/views/site/About'
import notFound from '@admin/views/site/NotFound'

import main from '@admin/layouts/Default'

const routes = [
  {
    path: '/',
    component: main,
    children: [
      {
        name: 'site-index',
        path: '',
        component: siteIndex
      },
      {
        name: 'site-about',
        path: '/about',
        component: siteAbout
      }
    ]
  },
  {
    name: 'login',
    path: '/login',
    component: () => import(/* webpackChunkName: "chunk-login" */ '@admin/views/site/Login')
  },
  {
    path: '*',
    component: notFound
  }
]

export default routes
