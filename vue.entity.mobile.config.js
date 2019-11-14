const path = require('path')
const apiMocker = require('mocker-api')

const isProduction = process.env.NODE_ENV === 'production'

const vueConfig = require('./vue.config')

const customConfig = {
  publicPath: isProduction ? './' : '/mobile',
  outputDir: 'dist/mobile',
  pages: {
    admin: {
      entry: 'src/modules/mobile/main.js',
      template: 'public/index.html',
      filename: 'index.html',
      title: 'Agile 移动端',
      chunks: ['vendor', 'element', 'agile', 'mobile']
    }
  },
  devServer: {
    port: 8081,
    before (app) {
      apiMocker(app, path.resolve('./mocker/mobile/index.js'))
    }
  }
}

module.exports = Object.assign(vueConfig, customConfig)
