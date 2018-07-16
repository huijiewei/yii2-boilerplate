import main from '@admin/components/MainLayout'

const routes = [
  {
    path: '/admin',
    component: main,
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Index')
      }
    ]
  },
  {
    path: '/admin-group',
    component: main,
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Index')
      },
      {
        path: 'create',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Create')
      },
      {
        path: 'edit',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Edit')
      }
    ]
  }
]

export default routes
