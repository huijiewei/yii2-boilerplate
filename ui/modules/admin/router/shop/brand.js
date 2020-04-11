export default [
  {
    path: 'shop-brand',
    component: () =>
      import(
        /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Index'
      ),
    meta: {
      breadcrumb: {
        title: '商品品牌',
        path: '/shop-brand',
      },
    },
  },
]
