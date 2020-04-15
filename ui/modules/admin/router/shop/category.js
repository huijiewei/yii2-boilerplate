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
        name: 'ShopCategory',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Index'
          ),
      },
      {
        path: 'create/:id',
        name: 'ShopCategoryCreate',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Create'
          ),
        meta: {
          parent: {
            name: 'ShopCategory',
            path: '/shop-category',
            title: '商品分类',
          },
          breadcrumb: {
            title: '新建商品分类',
          },
        },
      },
      {
        path: 'edit/:id',
        name: 'ShopCategoryEdit',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Edit'
          ),
        meta: {
          parent: {
            name: 'ShopCategory',
            path: '/shop-category',
            title: '商品分类',
          },
          breadcrumb: {
            title: '编辑商品分类',
          },
        },
      },
    ],
  },
]
