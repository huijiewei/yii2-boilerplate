export default [
  {
    path: '/district',
    component: () =>
      import(
        /* webpackChunkName: "chunk-district" */ '@admin/views/district/Layout'
      ),
    children: [
      {
        path: '',
        name: 'District',
        component: () =>
          import(
            /* webpackChunkName: "chunk-district" */ '@admin/views/district/Index'
          ),
        meta: {
          title: '地区',
        },
      },
      {
        path: 'create/:id',
        name: 'DistrictCreate',
        component: () =>
          import(
            /* webpackChunkName: "chunk-district" */ '@admin/views/district/Create'
          ),
        meta: {
          title: '新建地区',
          parent: {
            name: 'District',
            path: '/district',
            title: '地区',
          },
        },
      },
      {
        path: 'edit/:id',
        name: 'DistrictEdit',
        component: () =>
          import(
            /* webpackChunkName: "chunk-district" */ '@admin/views/district/Edit'
          ),
        meta: {
          title: '编辑地区',
          parent: {
            name: 'District',
            path: '/district',
            title: '地区',
          },
        },
      },
    ],
  },
]
