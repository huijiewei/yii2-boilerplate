const delay = require('mocker-api/utils/delay')

const noProxy = process.env.NO_PROXY === 'true'

const proxy = {
  _proxy: {
    changeHost: true
  },
  'GET /mobile/api/auth/authentication': (req, res) => {
    return res.json({
      id: 1,
      name: 'test'
    })
  }
}

module.exports = noProxy ? {} : delay(proxy, 1000)
