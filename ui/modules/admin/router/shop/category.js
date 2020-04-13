export default [
  {
    path: 'shop-category',
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
        path: 'create/:parentId',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Create'
          ),
        meta: {
          breadcrumb: {
            title: '新建商品分类',
          },
        },
      },
      {
        path: 'edit/:id',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Edit'
          ),
        meta: {
          breadcrumb: {
            title: '编辑商品分类',
          },
        },
      },
    ],
  },
]
