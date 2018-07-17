import main from '@admin/components/MainLayout'

const routes = [
  {
    path: '/admin',
    component: main,
    children: [
      {
        name: 'admin',
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
        name: 'admin-group',
        path: '',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Index')
      },
      {
        name: 'admin-group-create',
        path: 'create',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Create')
      },
      {
        name: 'admin-group-edit',
        path: 'edit',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Edit')
      }
    ]
  }
]

export default routes
