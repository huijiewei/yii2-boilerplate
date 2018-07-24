const configGenerator = require('./webpack/Generator')

const config = require('./admin.base.config')

config.serveEnable = true
config.serveHost = 'www.bp.test'
config.serveCompress = true
config.profile = true

const webpackConfig = configGenerator(config)

module.exports = webpackConfig
