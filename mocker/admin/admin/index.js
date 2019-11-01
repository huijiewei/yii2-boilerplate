const { authenticationCheck, notFoundCheck } = require('../util')
const admins = require('./_admins')

exports.adminList = (req, res) => {
  const success = {
    'items': admins
  }

  return authenticationCheck(req, res, () => {
    return res.json(success)
  })
}

exports.adminItem = (req, res) => {
  const { id } = req.params

  return authenticationCheck(req, res, () => {
    const admin = admins.find((item) => {
      return item.id === Number(id)
    })

    return notFoundCheck(admin, '管理员不存在', res, () => {
      const result = JSON.parse(JSON.stringify(admin))
      delete result.group
      return res.json(result)
    })
  })
}

exports.adminCreate = (req, res) => {
  return authenticationCheck(req, res, () => {
    return res.json({ message: '新建管理员成功', adminId: 1022 })
  })
}

exports.adminEdit = (req, res) => {
  return authenticationCheck(req, res, () => {
    return res.json({ message: '编辑管理员成功' })
  })
}

exports.adminDelete = (req, res) => {
  return authenticationCheck(req, res, () => {
    return res.json({ message: '删除管理员成功' })
  })
}
