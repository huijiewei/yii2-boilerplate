const { authenticationCheck, notFoundCheck } = require('../util')
const admins = require('./_admins')
const adminGroups = require('../admin-group/_admin-groups')

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
    const { phone, groupId, password } = req.body

    const errors = []

    const admin = admins.find((item) => {
      return item.phone === phone
    })

    if (admin) {
      errors.push({ field: 'phone', message: '手机号码 ' + phone + ' 已被占用' })
    }

    if (password.length < 6) {
      errors.push({ field: 'password', message: '密码不能少于 6 位' })
    }

    const group = adminGroups.find((item) => {
      return item.id === Number(groupId)
    })

    if (!group) {
      errors.push({ field: 'groupId', message: '选择了不存在的用户组' })
    }

    if (errors.length) {
      return res.status(422).json(errors)
    }

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
