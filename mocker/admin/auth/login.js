const groupAcl = require('./_groupAcl')
const groupMenus = require('./_groupMenus')

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

  return res.json({
    'message': '登陆成功',
    'accessToken': 'bmq7tDtL5GqT9b64',
    'currentUser': {
      'id': 1021,
      'phone': '13012345678',
      'display': '开发账号',
      'avatar': 'https://yuncars-other.oss-cn-shanghai.aliyuncs.com//boilerplate/201903/v4md41vswd_7477uudbmg.jpg?x-oss-process=style/avatar',
      'createdAt': '2018-07-24 11:48:31',
      'groupId': 101
    },
    'groupAcl': groupAcl,
    'groupMenus': groupMenus
  })
}
