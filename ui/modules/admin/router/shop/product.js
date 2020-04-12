export default [
  {
    path: 'shop-product',
    component: () =>
      import(
        /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-product/Index'
      ),
    meta: {
      breadcrumb: {
        title: '商品列表',
        path: '/shop-product',
      },
    },
  },
]
