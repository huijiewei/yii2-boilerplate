const { authenticationCheck } = require('../util')
const users = require('./_users')

exports.userList = (req, res) => {
  const { page, withSearchFields } = req.query

  const success = {
    items: users,
    pages: {
      totalCount: 1200,
      pageCount: 120,
      currentPage: Number(page),
      perPage: 10
    },
    searchFields: withSearchFields
      ? [
          { type: 'keyword', field: 'phone', label: '手机号码' },
          { type: 'keyword', field: 'name', label: '姓名' },
          {
            type: 'select',
            field: 'createdFrom',
            label: '注册来源',
            multiple: true,
            options: {
              SYSTEM: '系统',
              APP: '应用',
              WEB: '网站',
              WECHAT: '微信'
            }
          },
          {
            type: 'dateTimeRange',
            rangeType: 'daterange',
            field: 'createdRange',
            labelStart: '注册开始日期',
            labelEnd: '注册结束日期',
            shortcuts: [
              {
                text: '最近一周',
                start: '2019-11-07',
                end: '2019-11-14'
              },
              {
                text: '最近一个月',
                start: '2019-10-14',
                end: '2019-11-14'
              }
            ]
          },
          { type: 'br' }
        ]
      : null
  }

  return authenticationCheck(req, res, () => {
    return res.json(success)
  })
}

exports.userItem = (req, res) => {
  return res.status(404).json({
    message: '用户不存在'
  })
}

exports.userCreate = (req, res) => {
  return res.status(404).json({
    message: '服务不存在'
  })
}

exports.userDelete = (req, res) => {
  return res.status(401).json({
    message: '请先登录'
  })
}
