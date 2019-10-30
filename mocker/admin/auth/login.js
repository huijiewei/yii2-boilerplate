exports.authLogin = function (req, res) {
  const { account, password } = req.body

  if (!account || account.length === 0) {
    return res.status(422).json([{ 'field': 'account', 'message': '请输入手机号码' }])
  }

  if (!password || password.length === 0) {
    return res.status(422).json([{ 'field': 'password', 'message': '请输入密码' }])
  }

  if (!(/^1[3456789]\d{9}$/.test(account))) {
    return res.status(422).json([{ 'field': 'account', 'message': '无效的手机号码' }])
  }

  if (account !== '13012345678') {
    return res.status(422).json([{ 'field': 'account', 'message': '手机号码不存在' }])
  }

  if (password !== '123456') {
    return res.status(422).json([{ 'field': 'account', 'message': '密码错误' }])
  }

  return res.append('X-USER-TOKEN', '123').json({
    'message': '登陆成功',
    'currentUser': {
      'id': 1021,
      'phone': '13012345678',
      'display': '开发账号',
      'avatar': 'https://yuncars-other.oss-cn-shanghai.aliyuncs.com//boilerplate/201903/v4md41vswd_7477uudbmg.jpg?x-oss-process=style/avatar',
      'createdAt': '2018-07-24 11:48:31',
      'groupId': 101
    },
    'groupAcl': [
      'site/sms-send', 'site/clean-cache',
      'user/index', 'user/create', 'user/import',
      'good/index', 'good/new', 'good/edit', 'good/delete',
      'admin/index', 'admin/create', 'admin/edit', 'admin/delete',
      'admin-group/index', 'admin-group/create', 'admin-group/edit', 'admin-group/delete',
      'user/export', 'user/edit', 'user/delete', 'user/delete',
      'shop/property', 'shop/feature', 'shop/brand',
      'shop-category/index', 'shop-category/create', 'shop-category/edit', 'shop-category/delete',
      'shop-category/index', 'shop-category/create', 'shop-category/edit', 'shop-category/delete',
      'shop/property', 'shop/feature', 'shop/brand'
    ],
    'groupMenus': [
      { 'label': '首页', 'icon': 'home', 'url': 'site/index', 'public': true },
      { 'label': '会员管理',
        'icon': 'user',
        'children': [
          { 'label': '会员列表', 'url': 'user/index' },
          { 'label': '新建会员',
            'children': [
              { 'label': '新建会员', 'url': 'user/create' },
              { 'label': '批量导入', 'url': 'user/import' }
            ] }
        ] },
      { 'label': '商品管理',
        'icon': 'gift',
        'children': [
          { 'label': '新建商品', 'url': 'good/new' },
          { 'label': '商品列表', 'url': 'good/index' },
          { 'label': '商品分类', 'url': 'shop-category/index' },
          { 'label': '商品属性', 'url': 'shop/property' },
          { 'label': '商品特点', 'url': 'shop/feature' },
          { 'label': '商品品牌', 'url': 'shop/brand' }] },
      { 'label': '系统管理',
        'icon': 'setting',
        'children': [
          { 'label': '管理员', 'url': 'admin/index' },
          { 'label': '管理组', 'url': 'admin-group/index' }
        ] }
    ] })
}
