import Blank from '@admin/layouts/Blank'

const routes = [
  {
    path: 'user',
    component: Blank,
    meta: {
      breadcrumb: {
        title: '会员',
        link: 'user'
      }
    },
    children: [
      {
        name: 'user',
        path: '',
        component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Index')
      },
      {
        name: 'user-create',
        path: 'create',
        component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Create'),
        meta: {
          breadcrumb: {
            title: '新建'
          }
        }
      },
      {
        name: 'user-import',
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
