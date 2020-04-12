const assign = require('assign-deep')

const isProduction = process.env.NODE_ENV === 'production'

const vueConfig = require('./vue.config')

const devServerPort = 8081

const customConfig = {
  publicPath: isProduction
    ? '/statics/build/mobile'
    : (vueConfig.devServer.https !== false ? 'https' : 'http') +
      '://' +
      vueConfig.devServer.host +
      ':' +
      devServerPort +
      '/mobile',
  outputDir: 'public/statics/build/mobile',
  pages: {
    mobile: {
      entry: 'ui/modules/mobile/main.js',
      chunks: ['vendor', 'element', 'agile', 'mobile'],
    },
  },
  devServer: {
    port: devServerPort,
    publicPath: '/mobile',
  },
}

const config = assign(vueConfig, customConfig)

module.exports = config
