const path = require('path')
const apiMocker = require('mocker-api')
const assign = require('assign-deep')

const isProduction = process.env.NODE_ENV === 'production'

const vueConfig = require('./vue.config')

const customConfig = {
  publicPath: isProduction ? '/admin' : '/admin',
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
  pwa: {
    name: 'Agile 管理后台',
    manifestOptions: {
      icons: [
        {
          src: 'admin/icons/android-chrome-192x192.png',
          sizes: '192x192',
          type: 'image/png'
        },
        {
          src: 'admin/icons/android-chrome-512x512.png',
          sizes: '512x512',
          type: 'image/png'
        }
      ]
    },
    iconPaths: {
      favicon16: 'admin/icons/favicon-16x16.png',
      favicon32: 'admin/icons/favicon-32x32.png',
      appleTouchIcon: 'admin/icons/apple-touch-icon.png',
      maskIcon: 'admin/icons/safari-pinned-tab.svg',
      msTileImage: 'admin/icons/mstile-144x144.png'
    }
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
