import BlankLayout from '@admin/components/BlankLayout'

const routes = [
  {
    path: '/admin',
    component: BlankLayout,
    meta: {
      breadcrumb: {
        title: '管理员',
        path: '/admin'
      }
    },
    children: [
      {
        path: '',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Index'
          )
      },
      {
        path: 'create',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Create'
          ),
        meta: {
          breadcrumb: {
            title: '新建'
          }
        }
      },
      {
        path: 'edit',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Edit'
          ),
        meta: {
          breadcrumb: {
            title: '编辑'
          }
        }
      }
    ]
  },
  {
    path: '/admin-group',
    component: BlankLayout,
    meta: {
      breadcrumb: {
        title: '管理组',
        path: '/admin-group'
      }
    },
    children: [
      {
        path: '',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Index'
          )
      },
      {
        path: 'create',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Create'
          ),
        meta: {
          breadcrumb: {
            title: '新建'
          }
        }
      },
      {
        path: 'edit',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Edit'
          ),
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
