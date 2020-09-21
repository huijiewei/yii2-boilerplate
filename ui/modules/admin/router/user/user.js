export default [
  {
    path: '/user',
    name: 'User',
    component: () =>
      import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Index'),
    meta: {
      title: '用户',
    },
  },
  {
    path: '/user/create',
    name: 'UserCreate',
    component: () =>
      import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Create'),
    meta: {
      title: '新建用户',
    },
  },
  {
    path: '/user/edit/:id',
    name: 'UserEdit',
    component: () =>
      import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Edit'),
    meta: {
      title: '编辑用户',
    },
  },
]
