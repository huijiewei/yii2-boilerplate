const path = require('path')
const configGenerator = require('./webpack/Generator')

const config = require('./admin.base.config')

config.devServerEnable = true
config.devServerHost = 'www.bp.test'
config.devServerCompress = true
config.devServerHttps = true
config.devServerHttp2 = false // 因为 webpack-serve 的 BUG，暂时无法开启 HTTP2
config.devServerHttpsCert = path.resolve(__dirname, '../../certs/www.bp.test.pem')
config.devServerHttpsKey = path.resolve(__dirname, '../../certs/www.bp.test-key.pem')
config.profile = true

const webpackConfig = configGenerator(config)

module.exports = webpackConfig
