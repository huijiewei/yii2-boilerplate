import main from '@admin/components/MainLayout'

const routes = [
  {
    path: '/user',
    component: main,
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Index')
      }
    ]
  }
]

export default routes
