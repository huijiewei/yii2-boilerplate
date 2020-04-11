export default [
  {
    path: 'admin-log',
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
