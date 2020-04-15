export default [
  {
    path: '/shop-product',
    component: () =>
      import(
        /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-product/Index'
      ),
    meta: {
      title: '商品列表',
    },
  },
]
