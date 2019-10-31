const groupMenus = [
  {
    label: '首页',
    icon: 'home',
    url: 'site/index',
    'public': true
  },
  {
    label: '会员管理',
    icon: 'user',
    children: [
      {
        label: '会员列表',
        url: 'user/index'
      },
      {
        label: '新建会员',
        children: [
          {
            label: '新建会员',
            url: 'user/create'
          },
          {
            label: '批量导入',
            url: 'user/import'
          }
        ]
      }
    ]
  },
  {
    label: '商品管理',
    icon: 'gift',
    children: [
      {
        label: '新建商品',
        url: 'good/new'
      },
      {
        label: '商品列表',
        url: 'good/index'
      },
      {
        label: '商品分类',
        url: 'shop-category/index'
      },
      {
        label: '商品属性',
        url: 'shop/property'
      },
      {
        label: '商品特点',
        url: 'shop/feature'
      },
      {
        label: '商品品牌',
        url: 'shop/brand'
      }
    ]
  },
  {
    label: '系统管理',
    icon: 'setting',
    children: [
      {
        label: '管理员',
        url: 'admin/index'
      },
      {
        label: '管理组',
        url: 'admin-group/index'
      }
    ]
  }
]

module.exports = groupMenus
