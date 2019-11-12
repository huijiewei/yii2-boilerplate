const { authenticationCheck, notFoundCheck } = require('../util')
const adminGroups = require('./_admin-groups')
const adminGroupAcl = require('./_admin-group-acl')

exports.adminGroupList = (req, res) => {
  const success = {
    'items': adminGroups
  }

  return authenticationCheck(req, res, () => {
    return res.json(success)
  })
}

exports.adminGroupItem = (req, res) => {
  const { id } = req.params

  return authenticationCheck(req, res, () => {
    const adminGroup = adminGroups.find((item) => {
      return item.id === Number(id)
    })

    return notFoundCheck(adminGroup, '管理组不存在', res, () => {
      const result = JSON.parse(JSON.stringify(adminGroup))

      result.acl = [
        'site/sms-send', 'site/clean-cache',
        'user/index', 'user/create', 'user/import',
        'good/index', 'good/new', 'good/edit', 'good/delete',
        'admin/index', 'admin/create', 'admin/edit', 'admin/delete',
        'admin-group/index', 'admin-group/create', 'admin-group/edit', 'admin-group/delete',
        'user/export', 'user/edit', 'user/delete',
        'shop/property', 'shop/feature', 'shop/brand',
        'shop-category/index', 'shop-category/create', 'shop-category/edit', 'shop-category/delete'
      ]

      return res.json(result)
    })
  })
}

exports.adminGroupCreate = (req, res) => {
  return authenticationCheck(req, res, () => {
    const { name } = req.body

    const errors = []

    const adminGroup = adminGroups.find((item) => {
      return item.name === name
    })

    if (adminGroup) {
      errors.push({ field: 'phone', message: '管理组 ' + name + ' 已存在' })
    }

    if (errors.length) {
      return res.status(422).json(errors)
    }

    return res.json({ message: '新建管理组成功', adminId: 1022 })
  })
}

exports.adminGroupEdit = (req, res) => {
  return authenticationCheck(req, res, () => {
    return res.json({ message: '编辑管理组成功' })
  })
}

exports.adminGroupDelete = (req, res) => {
  return authenticationCheck(req, res, () => {
    return res.json({ message: '删除管理组成功' })
  })
}

exports.adminGroupAcl = (req, res) => {
  return authenticationCheck(req, res, () => {
    return res.json(adminGroupAcl)
  })
}

exports.adminGroupMap = (req, res) => {
  return authenticationCheck(req, res, () => {
    const map = {}
    adminGroups.forEach((adminGroup) => {
      map[adminGroup.id] = adminGroup.name
    })
    return res.json(map)
  })
}
