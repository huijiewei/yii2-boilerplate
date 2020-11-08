export default [
  {
    path: '/user-address',
    name: 'UserAddress',
    component: () =>
      import(
        /* webpackChunkName: "chunk-user" */ '@admin/views/user-address/Index'
      ),
    meta: {
      title: '用户地址',
    },
  },
  {
    path: '/user-address/create',
    name: 'UserAddressCreate',
    component: () =>
      import(
        /* webpackChunkName: "chunk-user" */ '@admin/views/user-address/Create'
      ),
    meta: {
      title: '新建用户地址',
    },
  },
  {
    path: '/user-address/edit/:id',
    name: 'UserAddressEdit',
    component: () =>
      import(
        /* webpackChunkName: "chunk-user" */ '@admin/views/user-address/Edit'
      ),
    meta: {
      title: '编辑用户地址',
    },
  },
]
