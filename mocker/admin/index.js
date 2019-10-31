const delay = require('mocker-api/utils/delay')
const { authAuthentication } = require('./auth/authentication')
const { authLogin } = require('./auth/login')

const noProxy = process.env.NO_PROXY === 'true'

const proxy = {
  _proxy: {
    changeHost: true
  },
  'GET /admin/api/auth/authentication': authAuthentication,
  'POST /admin/api/auth/login': authLogin
}

module.exports = (noProxy ? {} : delay(proxy, 100))
