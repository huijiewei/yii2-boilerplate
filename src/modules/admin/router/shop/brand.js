import BlankLayout from '@admin/components/BlankLayout'

const routes = [
  {
    path: '/shop-brand',
    component: BlankLayout,
    meta: {
      breadcrumb: {
        title: '商品品牌',
        path: '/shop-brand'
      }
    },
    children: [
      {
        path: '',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Index'
          )
      }
    ]
  }
]

export default routes
