const routes = [
  {
    name: 'admin',
    path: 'admin',
    component: () => import(/* webpackChunkName: "chunk-admin" */ '@admin/views/admin/Index'),
    meta: {
      breadcrumb: {
        title: '管理员',
        link: 'admin'
      }
    }
  }
]

export default routes
