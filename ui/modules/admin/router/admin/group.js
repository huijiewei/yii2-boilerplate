import AdminLayout from '@admin/components/AdminLayout'

export default [
  {
    path: '/admin-group',
    component: AdminLayout,
    meta: {
      breadcrumb: {
        title: '管理组',
        path: '/admin-group',
      },
    },
    children: [
      {
        path: '',
        name: 'AdminGroup',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Index'
          ),
      },
      {
        path: 'create',
        name: 'AdminGroupCreate',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Create'
          ),
        meta: {
          breadcrumb: {
            title: '新建管理组',
          },
        },
      },
      {
        path: 'edit/:id',
        name: 'AdminGroupEdit',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Edit'
          ),
        meta: {
          breadcrumb: {
            title: '编辑管理组',
          },
        },
      },
    ],
  },
]
