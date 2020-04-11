import AdminLayout from '@admin/components/AdminLayout'

export default {
  path: '/admin-log',
  component: AdminLayout,
  meta: {
    breadcrumb: {
      title: '操作日志',
      path: '/admin-log',
    },
  },
  children: [
    {
      path: '',
      component: () =>
        import(
          /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-log/Index'
        ),
    },
  ],
}
