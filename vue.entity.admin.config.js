const path = require('path')
const apiMocker = require('mocker-api')
const assign = require('assign-deep')

const isProduction = process.env.NODE_ENV === 'production'

const vueConfig = require('./vue.config')

const customConfig = {
  publicPath: isProduction ? '' : '/admin',
  outputDir: 'dist/admin',
  pages: {
    admin: {
      entry: 'src/modules/admin/main.js',
      template: '../../public/index.html',
      filename: 'index.html',
      title: 'Agile 管理后台',
      chunks: ['vendor', 'element', 'agile', 'admin']
    }
  },
  configureWebpack: {
    context: path.resolve('src/modules/admin')
  },
  devServer: {
    port: 8080,
    before(app) {
      apiMocker(app, path.resolve('./mocker/admin/index.js'))
    }
  }
}

const config = assign(vueConfig, customConfig)

module.exports = config
