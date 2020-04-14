import AdminLayout from '@admin/components/AdminLayout'

export default [
  {
    path: '/shop-product',
    component: AdminLayout,
    meta: {
      breadcrumb: {
        title: '商品列表',
        path: '/shop-product',
      },
    },
    children: [
      {
        path: '',
        name: 'ShopProduct',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-product/Index'
          ),
      },
    ],
  },
]
