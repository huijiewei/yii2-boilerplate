const path = require('path')
const apiMocker = require('mocker-api')

const isProduction = process.env.NODE_ENV === 'production'

const vueConfig = require('./vue.config')

const customConfig = {
  publicPath: isProduction ? './' : '/admin',
  outputDir: 'dist/admin',
  pages: {
    admin: {
      entry: 'src/modules/admin/main.js',
      template: 'public/index.html',
      filename: 'index.html',
      title: 'Agile 管理后台',
      chunks: ['vendor', 'element', 'agile', 'admin']
    }
  },
  devServer: {
    port: process.env.DEV_SERVER_ADMIN_PORT,
    before (app) {
      apiMocker(app, path.resolve('./mocker/admin/index.js'))
    }
  },
  configureWebpack: {
    resolve: {
      alias: {
        '@core': path.resolve('src/core'),
        '@admin': path.resolve('src/modules/admin')
      }
    }
  }
}

module.exports = Object.assign(vueConfig, customConfig)
