export default [
  {
    path: '/shop-category',
    component: () =>
      import(
        /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Layout'
      ),
    children: [
      {
        path: '',
        name: 'ShopCategory',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Index'
          ),
        meta: {
          title: '商品分类',
        },
      },
      {
        path: 'create/:id',
        name: 'ShopCategoryCreate',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-category/Create'
          ),
        meta: {
          title: '新建商品分类',
          parent: {
            name: 'ShopCategory',
            path: '/shop-category',
            title: '商品分类',
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
          title: '编辑商品分类',
          parent: {
            name: 'ShopCategory',
            path: '/shop-category',
            title: '商品分类',
          },
        },
      },
    ],
  },
]
