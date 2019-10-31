const { authenticationCheck } = require('../util')

exports.adminList = function (req, res) {
  const success = {
    'items': [
      {
        'id': 1021,
        'phone': '13012345678',
        'display': '开发账号',
        'avatar': 'https://yuncars-other.oss-cn-shanghai.aliyuncs.com//boilerplate/201903/v4md41vswd_7477uudbmg.jpg?x-oss-process=style/avatar',
        'createdAt': '2018-07-24 11:48:31',
        'groupId': 101,
        'group': { 'id': 101, 'name': '开发组' }
      },
      {
        'id': 1022,
        'phone': '13098761234',
        'display': '演示账号',
        'avatar': 'https://yuncars-other.oss-cn-shanghai.aliyuncs.com//boilerplate/201807/150zg7q4u7c.jpg@!avatar',
        'createdAt': '2018-07-25 10:41:57',
        'groupId': 102,
        'group': { 'id': 102, 'name': '演示组' }
      },
      {
        'id': 1023,
        'phone': '13512345678',
        'display': '测试账号',
        'avatar': 'https://yuncars-other.oss-cn-shanghai.aliyuncs.com//boilerplate/201808/blnp6u1xtmq.jpg@!avatar',
        'createdAt': '2018-08-01 09:09:41',
        'groupId': 102,
        'group': { 'id': 102, 'name': '演示组' }
      }
    ]
  }

  return authenticationCheck(req, res, success)
}
