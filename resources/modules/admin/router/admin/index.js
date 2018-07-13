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
        path: 'view',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/View')
      }
    ]
  }
]

export default routes
