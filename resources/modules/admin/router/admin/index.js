import main from '@admin/views/layouts/Main'

const routes = [
  {
    path: '/admin',
    component: main,
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "user" */ '@admin/views/templates/admin/Index')
      }
    ]
  },
  {
    path: '/admin-group',
    component: main,
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "user" */ '@admin/views/templates/admin-group/Index')
      }
    ]
  }
]

export default routes
