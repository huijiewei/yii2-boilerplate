const Mock = require('mockjs')
const util = require('./util')

module.exports = function (app) {
  app.get('/auth/authentication', function (rep, res) {
    const json = util.getJsonFile('./auth/authentication.json')

    res.json(Mock.mock(json))
  })
}
