const assign = require('assign-deep')

const isProduction = process.env.NODE_ENV === 'production'

const vueConfig = require('./vue.config')

const devServerPort = 8090

const customConfig = {
  publicPath: isProduction
    ? '/statics/build/admin'
    : (vueConfig.devServer.https !== false ? 'https' : 'http') +
      '://' +
      vueConfig.devServer.host +
      ':' +
      devServerPort +
      '/admin',
  outputDir: 'public/statics/build/admin',
  configureWebpack: {
    entry: './modules/admin/main.js',
  },
  devServer: {
    port: devServerPort,
    publicPath: '/admin',
  },
}

const config = assign(vueConfig, customConfig)

module.exports = config
