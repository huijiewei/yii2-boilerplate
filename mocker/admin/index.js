const delay = require('mocker-api/utils/delay')
const { authAuthentication } = require('./auth/authentication')
const { authLogin } = require('./auth/login')
const { adminList, adminItem, adminEdit, adminCreate, adminDelete } = require('./admin/index')
const { adminGroupList, adminGroupItem, adminGroupEdit, adminGroupCreate, adminGroupDelete, adminGroupFilter, adminGroupAclFilter } = require('./admin-group/index')

const noProxy = process.env.NO_PROXY === 'true'

const proxy = {
  _proxy: {
    changeHost: true
  },
  'GET /admin/api/auth/authentication': authAuthentication,
  'POST /admin/api/auth/login': authLogin,
  'GET /admin/api/admins': adminList,
  'POST /admin/api/admins': adminCreate,
  'GET /admin/api/admins/:id(\\d+)': adminItem,
  'PUT /admin/api/admins/:id(\\d+)': adminEdit,
  'DELETE /admin/api/admins/:id(\\d+)': adminDelete,
  'GET /admin/api/admin-groups': adminGroupList,
  'POST /admin/api/admin-groups': adminGroupCreate,
  'GET /admin/api/admin-groups/:id(\\d+)': adminGroupItem,
  'PUT /admin/api/admin-groups/:id(\\d+)': adminGroupEdit,
  'DELETE /admin/api/admin-groups/:id(\\d+)': adminGroupDelete,
  'GET /admin/api/filter/admin-groups': adminGroupFilter,
  'GET /admin/api/filter/admin-group-acl': adminGroupAclFilter
}

module.exports = (noProxy ? {} : delay(proxy, 500))
