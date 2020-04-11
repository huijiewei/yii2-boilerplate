export default [
  {
    path: 'user',
    component: () =>
      import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Index'),
    meta: {
      breadcrumb: {
        title: '用户',
        path: '/user',
      },
    },
  },
  {
    path: 'user/create',
    component: () =>
      import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Create'),
    meta: {
      breadcrumb: {
        title: '新建用户',
      },
    },
  },
  {
    path: 'user/edit',
    component: () =>
      import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Edit'),
    meta: {
      breadcrumb: {
        title: '编辑用户',
      },
    },
  },
]
