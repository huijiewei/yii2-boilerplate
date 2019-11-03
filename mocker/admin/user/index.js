const { authenticationCheck } = require('../util')
const users = require('./_users')

exports.userList = (req, res) => {
  const { page, searchFields } = req.query

  const success = {
    'items': users,
    'pages': { 'totalCount': 1200, 'pageCount': 120, 'currentPage': Number(page), 'perPage': 10 },
    'searchFields': searchFields ? [{ 'type': 'keyword', 'field': 'phone', 'label': '电话号码' }, { 'type': 'keyword', 'field': 'display', 'label': '显示名' }, { 'type': 'select', 'field': 'createdFrom', 'label': '注册来源', 'multiple': true, 'options': { 'SYSTEM': '系统', 'WEB': '网站', 'APP': 'APP', 'WECHAT': '微信' } }, { 'type': 'dateRange', 'field': 'createdRange', 'labelStart': '注册开始日期', 'labelEnd': '注册结束日期' }, { 'type': 'br' }] : null
  }

  return authenticationCheck(req, res, () => {
    return res.json(success)
  })
}
