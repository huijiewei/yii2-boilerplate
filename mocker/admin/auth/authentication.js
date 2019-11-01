const groupAcl = require('./_groupAcl')
const groupMenus = require('./_groupMenus')
const { authenticationCheck } = require('../util')

exports.authAuthentication = (req, res) => {
  const success = {
    currentUser: {
      id: 1021,
      phone: '13012345678',
      display: '开发账号',
      avatar: 'https://yuncars-other.oss-cn-shanghai.aliyuncs.com//boilerplate/201903/v4md41vswd_7477uudbmg.jpg?x-oss-process=style/avatar',
      createdAt: '2018-07-24 11:48:31',
      groupId: 101
    },
    groupAcl: groupAcl,
    groupMenus: groupMenus
  }

  return authenticationCheck(req, res, () => {
    res.json(success)
  })
}
