const configGenerator = require('./webpack/Generator')
const config = require('./admin.base.config')

const MomentLocalesPlugin = require('moment-locales-webpack-plugin')

config.addPlugin(new MomentLocalesPlugin({
  localesToKeep: ['zh-cn']
}))

const webpackConfig = configGenerator(config)

module.exports = webpackConfig
