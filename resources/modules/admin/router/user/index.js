import main from '@admin/views/layouts/Main'

const routes = [
  {
    path: '/user',
    component: main,
    children: [
      {
        path: 'index',
        component: () => import(/* webpackChunkName: "user" */ '@admin/views/templates/user/Index'),
        alias: ''
      }
    ]
  }
]

export default routes
