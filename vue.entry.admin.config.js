const assign = require('assign-deep')

const isProduction = process.env.NODE_ENV === 'production'

const vueConfig = require('./vue.config')

const devServerPort = 8090

const appPublicPath = '/admin'

process.env.VUE_APP_PUBLIC_PATH = appPublicPath

const customConfig = {
  publicPath: isProduction
    ? '/statics/build/admin'
    : (vueConfig.devServer.https !== false ? 'https' : 'http') +
    '://' +
    vueConfig.devServer.host +
    ':' +
    devServerPort +
    appPublicPath,
  outputDir: 'public/statics/build/admin',
  configureWebpack: {
    entry: './modules/admin/main.js'
  },
  devServer: {
    port: devServerPort,
    publicPath: appPublicPath
  }
}

const config = assign(vueConfig, customConfig)

module.exports = config
