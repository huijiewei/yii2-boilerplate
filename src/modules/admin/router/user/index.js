import BlankLayout from '@admin/components/BlankLayout'

const routes = [
  {
    path: '/user',
    component: BlankLayout,
    meta: {
      breadcrumb: {
        title: '会员',
        path: '/user'
      }
    },
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Index')
      }
    ]
  }
]

export default routes
