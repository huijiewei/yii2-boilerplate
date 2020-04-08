const assign = require('assign-deep')

const isProduction = process.env.NODE_ENV === 'production'

const vueConfig = require('./vue.config')

const devServerPort = 8080

const customConfig = {
  publicPath: isProduction ? '/statics/build/admin' : (vueConfig.devServer.https !== false ? 'https' : 'http') + '://' +
    vueConfig.devServer.host + ':' + devServerPort + '/admin',
  outputDir: 'public/statics/build/admin',
  pages: {
    admin: {
      entry: 'ui/modules/admin/main.js',
      chunks: ['vendor', 'element', 'agile', 'admin']
    }
  },
  devServer: {
    port: devServerPort,
    publicPath: '/admin'
  }
}

const config = assign(vueConfig, customConfig)

module.exports = config
