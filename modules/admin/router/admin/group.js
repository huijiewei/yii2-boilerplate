import AdminLayout from '@admin/components/AdminLayout'

export default [
  {
    path: '/admin-group',
    name: 'AdminGroup',
    component: () =>
      import(
        /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Index'
      ),
    meta: {
      title: '管理组',
    },
  },
  {
    path: '/admin-group/create',
    name: 'AdminGroupCreate',
    component: () =>
      import(
        /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Create'
      ),
    meta: {
      title: '新建管理组',
    },
  },
  {
    path: '/admin-group/edit/:id',
    name: 'AdminGroupEdit',
    component: () =>
      import(
        /* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Edit'
      ),
    meta: {
      title: '编辑管理组',
    },
  },
]
