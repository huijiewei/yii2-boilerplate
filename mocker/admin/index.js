const delay = require('mocker-api/utils/delay')
const { authAuthentication } = require('./auth/authentication')
const { authLogin } = require('./auth/login')
const { adminList } = require('./admin/list')
const { adminGroupList } = require('./admin-group/list')

const noProxy = process.env.NO_PROXY === 'true'

const proxy = {
  _proxy: {
    changeHost: true
  },
  'GET /admin/api/auth/authentication': authAuthentication,
  'POST /admin/api/auth/login': authLogin,
  'GET /admin/api/admin': adminList,
  'GET /admin/api/admin-group': adminGroupList
}

module.exports = (noProxy ? {} : delay(proxy, 100))
