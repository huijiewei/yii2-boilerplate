import Blank from '@admin/layouts/Blank'

const routes = [
  {
    path: 'admin',
    component: Blank,
    meta: {
      breadcrumb: {
        title: '管理员',
        link: 'admin'
      }
    },
    children: [
      {
        name: 'admin',
        path: '',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Index')

      },
      {
        name: 'admin-create',
        path: 'create',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Create'),
        meta: {
          breadcrumb: {
            title: '新建'
          }
        }
      },
      {
        name: 'admin-edit',
        path: 'edit',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Edit'),
        meta: {
          breadcrumb: {
            title: '编辑'
          }
        }
      }
    ]
  },
  {
    path: 'admin-group',
    component: Blank,
    meta: {
      breadcrumb: {
        title: '管理组',
        link: 'admin-group'
      }
    },
    children: [
      {
        name: 'admin-group',
        path: '',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Index')
      },
      {
        name: 'admin-group-create',
        path: 'create',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Create'),
        meta: {
          breadcrumb: {
            title: '新建'
          }
        }
      },
      {
        name: 'admin-group-edit',
        path: 'edit',
        component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Edit'),
        meta: {
          breadcrumb: {
            title: '编辑'
          }
        }
      }
    ]
  }
]

export default routes
