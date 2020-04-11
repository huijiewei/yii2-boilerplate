export default [
  {
    path: 'admin',
    component: () =>
      import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Index'),
    meta: {
      breadcrumb: {
        title: '管理员',
        path: '/admin',
      },
    },
  },
  {
    path: 'admin/create',
    component: () =>
      import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Create'),
    meta: {
      breadcrumb: {
        title: '新建管理员',
      },
    },
  },
  {
    path: 'admin/edit',
    component: () =>
      import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Edit'),
    meta: {
      breadcrumb: {
        title: '编辑管理员',
      },
    },
  },
]
