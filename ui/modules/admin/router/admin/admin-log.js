export default [
  {
    path: 'admin-log',
    name: 'AdminLog',
    component: () =>
      import(
        /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-log/Index'
      ),
    meta: {
      breadcrumb: {
        title: '操作日志',
        path: '/admin-log',
      },
    },
  },
]
