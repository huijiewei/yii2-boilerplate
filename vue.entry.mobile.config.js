const path = require('path')
const apiMocker = require('mocker-api')
const assign = require('assign-deep')

const vueConfig = require('./vue.config')

const customConfig = {
  publicPath: '/mobile',
  outputDir: 'dist/mobile',
  pages: {
    admin: {
      entry: 'src/modules/mobile/main.js',
      template: 'public/index.html',
      filename: 'index.html',
      title: 'Agile 移动端',
      chunks: ['vendor', 'element', 'agile', 'mobile'],
    },
  },
  devServer: {
    port: 8081,
    before(app) {
      apiMocker(app, path.resolve('./mocker/mobile/index.js'))
    },
  },
}

const config = assign(vueConfig, customConfig)

module.exports = config
