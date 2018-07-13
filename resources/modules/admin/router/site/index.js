import siteIndex from '@admin/views/templates/site/Index'
import siteAbout from '@admin/views/templates/site/About'
import notFound from '@admin/views/templates/site/NotFound'

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
    component: () => import(/* webpackChunkName: "chunk-login" */ '@admin/views/templates/site/Login')
  },
  {
    path: '*',
    component: notFound
  }
]

export default routes
