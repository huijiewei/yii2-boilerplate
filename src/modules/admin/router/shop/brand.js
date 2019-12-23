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
      },
      {
        path: 'create',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Create'
          ),
        meta: {
          breadcrumb: {
            title: '新建'
          }
        }
      },
      {
        path: 'edit',
        component: () =>
          import(
            /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Edit'
          ),
        meta: {
          breadcrumb: {
            title: '编辑'
          }
        }
      }
    ]
  }
]

export default routes
