const path = require('path')
const configGenerator = require('./webpack/Generator')

const config = require('./admin.base.config')

config.serveEnable = true
config.serveHost = 'www.bp.test'
config.serveCompress = true
config.serveHttps = true
config.serveHttp2 = false // 因为 webpack-serve 的 BUG，暂时无法开启 HTTP2
config.serveHttpsCert = path.resolve(__dirname, '../../certs/www.bp.test.pem')
config.serveHttpsKey = path.resolve(__dirname, '../../certs/www.bp.test-key.pem')
config.profile = true

const webpackConfig = configGenerator(config)

module.exports = webpackConfig
