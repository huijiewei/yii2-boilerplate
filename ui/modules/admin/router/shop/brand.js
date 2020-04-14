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
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Index'
          ),
      },
      {
        path: 'create',
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
        name: 'shop-brand-edit',
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
