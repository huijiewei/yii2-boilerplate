const configGenerator = require('./webpack/Generator')
const config = require('./admin.base.config')

const webpackConfig = configGenerator(config)

module.exports = webpackConfig
