import AdminLayout from '@admin/components/AdminLayout'

export default [
  {
    path: '/admin',
    component: AdminLayout,
    meta: {
      breadcrumb: {
        title: '管理员',
        path: '/admin',
      },
    },
    children: [
      {
        path: '',
        name: 'Admin',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Index'
          ),
      },
      {
        path: 'create',
        name: 'AdminCreate',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Create'
          ),
        meta: {
          breadcrumb: {
            title: '新建管理员',
          },
        },
      },
      {
        path: 'edit/:id',
        name: 'AdminEdit',
        component: () =>
          import(
            /* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Edit'
          ),
        meta: {
          breadcrumb: {
            title: '编辑管理员',
          },
        },
      },
    ],
  },
]
