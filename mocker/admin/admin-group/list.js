const { authenticationCheck } = require('../util')

exports.adminGroupList = function (req, res) {
  const success = {
    'items': [
      { 'id': 101, 'name': '开发组' },
      { 'id': 102, 'name': '演示组' },
      { 'id': 106, 'name': '测试组' },
      { 'id': 107, 'name': '产品组' },
      { 'id': 108, 'name': '市场组' },
      { 'id': 109, 'name': '运营组' }
    ]
  }

  return authenticationCheck(req, res, success)
}
