import BlankLayout from '@admin/components/BlankLayout'

const routes = [
  {
    path: '/user',
    component: BlankLayout,
    meta: {
      breadcrumb: {
        title: '用户',
        path: '/user',
      },
    },
    children: [
      {
        path: '',
        component: () =>
          import(
            /* webpackChunkName: "chunk-user" */ '@admin/views/user/Index'
          ),
      },
      {
        path: 'create',
        component: () =>
          import(
            /* webpackChunkName: "chunk-user" */ '@admin/views/user/Create'
          ),
        meta: {
          breadcrumb: {
            title: '新建',
          },
        },
      },
      {
        path: 'edit',
        component: () =>
          import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Edit'),
        meta: {
          breadcrumb: {
            title: '编辑',
          },
        },
      },
    ],
  },
]

export default routes
