const { authenticationCheck } = require('../util')

exports.adminGroupList = function (req, res) {
  const success = { 'items': [{ 'id': 101, 'name': '开发组' }, { 'id': 102, 'name': '演示组' }, { 'id': 106, 'name': '测试组' }] }

  return authenticationCheck(req, res, success)
}
