import siteIndex from '@admin/views/site/Index'
import siteAbout from '@admin/views/site/About'
import notFound from '@admin/views/site/NotFound'

import main from '@admin/components/MainLayout'

const routes = [
  {
    path: '',
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
