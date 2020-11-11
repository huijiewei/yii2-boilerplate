export default [
  {
    path: '/cms-category',
    component: () =>
      import(
        /* webpackChunkName: "chunk-cms" */ '@admin/views/cms-category/Layout'
      ),
    children: [
      {
        path: '',
        name: 'CmsCategory',
        component: () =>
          import(
            /* webpackChunkName: "chunk-cms" */ '@admin/views/cms-category/Index'
          ),
        meta: {
          title: '内容分类',
        },
      },
      {
        path: 'create/:id',
        name: 'CmsCategoryCreate',
        component: () =>
          import(
            /* webpackChunkName: "chunk-cms" */ '@admin/views/cms-category/Create'
          ),
        meta: {
          title: '新建内容分类',
          parent: {
            name: 'CmsCategory',
            path: '/cms-category',
            title: '内容分类',
          },
        },
      },
      {
        path: 'edit/:id',
        name: 'CmsCategoryEdit',
        component: () =>
          import(
            /* webpackChunkName: "chunk-cms" */ '@admin/views/cms-category/Edit'
          ),
        meta: {
          title: '编辑内容分类',
          parent: {
            name: 'CmsCategory',
            path: '/cms-category',
            title: '内容分类',
          },
        },
      },
    ],
  },
]
