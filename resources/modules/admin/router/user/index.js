import main from '@admin/views/layouts/Main'

const routes = [
  {
    path: '/user',
    component: main,
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/templates/user/Index')
      }
    ]
  }
]

export default routes
