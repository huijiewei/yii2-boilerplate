import main from '@admin/layouts/Default'

const routes = [
  {
    path: '/user',
    component: main,
    children: [
      {
        name: 'user-index',
        path: '',
        component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Index')
      },
      {
        name: 'user-create',
        path: 'create',
        component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Create')
      },
      {
        name: 'user-import',
        path: 'import',
        component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Import')
      }
    ]
  }
]

export default routes
