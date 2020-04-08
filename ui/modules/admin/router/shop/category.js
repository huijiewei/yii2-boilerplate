const routes = [
  {
    path: '/shop-category',
    component: () =>
      import(
        /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Layout'
      ),
    meta: {
      breadcrumb: {
        title: '商品分类',
        path: '/shop-category',
      },
    },
    children: [
      {
        path: '',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Index'
          ),
      },
      {
        path: 'create',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Create'
          ),
        meta: {
          breadcrumb: {
            title: '新建',
          },
        },
      },
      {
        path: 'edit',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Edit'
          ),
        meta: {
          breadcrumb: {
            title: '编辑',
          },
        },
      },
    ],
  },
]

export default routes
