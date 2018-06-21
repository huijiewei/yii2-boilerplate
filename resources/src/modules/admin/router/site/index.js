import main from '@admin/views/layouts/Main'
import siteIndex from '@admin/views/templates/site/Index'
import siteAbout from '@admin/views/templates/site/About'

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
        path: 'about',
        component: siteAbout
      }
    ]
  }
]

export default routes
