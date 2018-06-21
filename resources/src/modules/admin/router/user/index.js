import main from '@admin/views/layouts/Main'
import userIndex from '@admin/views/templates/user/Index'

const routes = [
  {
    path: '/user',
    component: main,
    children: [
      {
        path: 'index',
        component: userIndex,
        alias: ''
      }
    ]
  }
]

export default routes
