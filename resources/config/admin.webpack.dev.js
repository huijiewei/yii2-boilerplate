const path = require('path')
const configGenerator = require('./webpack/Generator')

const config = require('./admin.base.config')

config.devServerEnable = true
config.devServerHost = 'www.bp.test'
config.devServerPort = 8080
config.devServerCompress = true
config.devServerHttps = true
config.devServerHttp2 = true
config.devServerHttpsCert = path.resolve(__dirname, '../../certs/www.bp.test.pem')
config.devServerHttpsKey = path.resolve(__dirname, '../../certs/www.bp.test-key.pem')
config.profile = true

const webpackConfig = configGenerator(config)

module.exports = webpackConfig
