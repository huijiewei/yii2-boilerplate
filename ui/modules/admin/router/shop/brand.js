import AdminLayout from '@admin/components/AdminLayout'

export default [
  {
    path: '/shop-brand',
    component: AdminLayout,
    meta: {
      breadcrumb: {
        title: '商品品牌',
        path: '/shop-brand',
      },
    },
    children: [
      {
        path: '',
        name: 'ShopBrand',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Index'
          ),
      },
      {
        path: 'create',
        name: 'ShopBrandCreate',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Create'
          ),
        meta: {
          breadcrumb: {
            title: '新建商品品牌',
          },
        },
      },
      {
        path: 'edit/:id',
        name: 'ShopBrandEdit',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Edit'
          ),
        meta: {
          breadcrumb: {
            title: '编辑商品品牌',
          },
        },
      },
    ],
  },
]
