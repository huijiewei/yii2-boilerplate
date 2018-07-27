const configGenerator = require('./webpack/Generator')

const config = require('./admin.base.config')
config.useSourceMaps = false

const webpackConfig = configGenerator(config)

module.exports = webpackConfig
