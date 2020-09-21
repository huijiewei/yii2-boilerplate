export default [
  {
    path: '/shop-brand',
    name: 'ShopBrand',
    component: () =>
      import(
        /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Index'
      ),
    meta: {
      title: '商品品牌',
    },
  },
  {
    path: '/shop-brand/create',
    name: 'ShopBrandCreate',
    component: () =>
      import(
        /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Create'
      ),
    meta: {
      title: '新建商品品牌',
    },
  },
  {
    path: '/shop-brand/edit/:id',
    name: 'ShopBrandEdit',
    component: () =>
      import(
        /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Edit'
      ),
    meta: {
      title: '编辑商品品牌',
    },
  },
]
