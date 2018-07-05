import main from '@admin/views/layouts/Main'
import siteIndex from '@admin/views/templates/site/Index'
import siteAbout from '@admin/views/templates/site/About'
import siteNotFound from '@admin/views/templates/site/NotFound'

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
        path: 'about',
        component: siteAbout
      },
      {
        path: '*',
        component: siteNotFound
      }
    ]
  }
]

export default routes
