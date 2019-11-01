const { authenticationCheck } = require('../util')
const adminGroups = require('./_admin-groups')

exports.adminGroupList = (req, res) => {
  const success = {
    'items': adminGroups
  }

  return authenticationCheck(req, res, () => {
    return res.json(success)
  })
}

exports.adminGroupFilter = (req, res) => {
  const success = adminGroups

  return authenticationCheck(req, res, () => {
    return res.json(success)
  })
}
