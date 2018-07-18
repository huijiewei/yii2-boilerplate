const routes = [
  {
    name: 'admin',
    path: 'admin',
    component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Index'),
    meta: {
      breadcrumb: {
        title: '管理员',
        link: 'admin-group'
      }
    }
  },
  {
    name: 'admin-group',
    path: 'admin-group',
    component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Index'),
    meta: {
      breadcrumb: {
        title: '管理组',
        link: 'admin-group'
      }
    }
  },
  {
    name: 'admin-group-create',
    path: 'admin-group/create',
    component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Create'),
    meta: {
      breadcrumb: {
        title: '新建',
        parent: 'admin-group'
      }
    }
  },
  {
    name: 'admin-group-edit',
    path: 'admin-group/edit',
    component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin-group/Edit'),
    meta: {
      breadcrumb: {
        title: '编辑',
        parent: 'admin-group'
      }
    }
  }
]

export default routes
