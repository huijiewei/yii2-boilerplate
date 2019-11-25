const AdminGroupAcl = [
  {
    name: "管理首页",
    children: [
      { name: "测试短信发送", actionId: "site/sms-send" },
      { name: "更新系统缓存", actionId: "site/clean-cache" }
    ]
  },
  {
    name: "会员管理",
    children: [
      { name: "会员列表", actionId: "user/index" },
      { name: "会员导出", actionId: "user/export" },
      { name: "会员新建", actionId: "user/create" },
      { name: "会员编辑", actionId: "user/edit" },
      { name: "会员删除", actionId: "user/delete" },
      { name: "会员导入", actionId: "user/import" }
    ]
  },
  {
    name: "商品管理",
    children: [
      {
        children: [
          { name: "商品列表", actionId: "good/index" },
          { name: "商品导入", actionId: "good/export" },
          { name: "新建商品", actionId: "good/new" },
          { name: "编辑商品", actionId: "good/edit" },
          { name: "删除商品", actionId: "good/delete" }
        ]
      },
      {
        children: [
          { name: "商品分类", actionId: "shop-category/index" },
          { name: "商品分类新建", actionId: "shop-category/create" },
          { name: "商品分类编辑", actionId: "shop-category/edit" },
          { name: "商品分类删除", actionId: "shop-category/delete" }
        ]
      },
      { name: "商品属性", actionId: "shop/property" },
      { name: "商品特点", actionId: "shop/feature" },
      { name: "商品品牌", actionId: "shop/brand" }
    ]
  },
  {
    name: "系统管理",
    children: [
      {
        children: [
          { name: "管理员列表", actionId: "admin/index" },
          { name: "管理员新建", actionId: "admin/create" },
          { name: "管理员编辑", actionId: "admin/edit" },
          { name: "管理员删除", actionId: "admin/delete" }
        ]
      },
      {
        children: [
          { name: "管理组列表", actionId: "admin-group/index" },
          { name: "管理组新建", actionId: "admin-group/create" },
          { name: "管理组编辑", actionId: "admin-group/edit" },
          { name: "管理组删除", actionId: "admin-group/delete" }
        ]
      }
    ]
  }
];

module.exports = AdminGroupAcl;
