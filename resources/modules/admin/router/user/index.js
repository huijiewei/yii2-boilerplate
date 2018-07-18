const routes = [
  {
    name: 'user',
    path: 'user',
    component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Index'),
    meta: {
      breadcrumb: {
        title: '会员',
        link: 'user'
      }
    }
  },
  {
    name: 'user-create',
    path: 'user/create',
    component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Create'),
    meta: {
      breadcrumb: {
        title: '新建',
        parent: 'user'
      }
    }
  },
  {
    name: 'user-import',
    path: 'user/import',
    component: () => import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Import'),
    meta: {
      breadcrumb: {
        title: '导入',
        parent: 'user'
      }
    }
  }
]

export default routes
