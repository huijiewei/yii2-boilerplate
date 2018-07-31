import DefaultLayout from '@admin/components/DefaultLayout'

const routes = [
  {
    path: '/user',
    component: DefaultLayout,
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
      },
      {
        path: 'create',
        component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Create'),
        meta: {
          breadcrumb: {
            title: '新建'
          }
        }
      },
      {
        path: 'edit',
        component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Edit'),
        meta: {
          breadcrumb: {
            title: '编辑'
          }
        }
      },
      {
        path: 'import',
        component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Import'),
        meta: {
          breadcrumb: {
            title: '导入'
          }
        }
      }
    ]
  }
]

export default routes
