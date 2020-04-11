export default [
  {
    path: 'admin-group',
    component: () =>
      import(
        /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Index'
      ),
    meta: {
      breadcrumb: {
        title: '管理组',
        path: '/admin-group',
      },
    },
  },
  {
    path: 'admin-group/create',
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
    path: 'admin-group/edit',
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
]
