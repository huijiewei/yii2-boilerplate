export default [
  {
    path: '/admin',
    name: 'Admin',
    component: () =>
      import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Index'),
    meta: {
      title: '管理员',
    },
  },
  {
    path: '/admin/create',
    name: 'AdminCreate',
    component: () =>
      import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Create'),
    meta: {
      title: '新建管理员',
    },
  },
  {
    path: '/admin/edit/:id',
    name: 'AdminEdit',
    component: () =>
      import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Edit'),
    meta: {
      title: '编辑管理员',
    },
  },
]
