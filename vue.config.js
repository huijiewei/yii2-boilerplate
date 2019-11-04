const path = require('path')
const apiMocker = require('mocker-api')

const entries = {
  admin: {
    outputDir: 'dist/admin',
    page: {
      entry: 'src/modules/admin/main.js',
      template: 'public/index.html',
      filename: 'index.html',
      title: 'Agile 管理后台',
      chunks: ['vendor', 'element', 'agile', 'admin']
    }
  },
  mobile: {
    outputDir: 'dist/mobile',
    page: {
      entry: 'src/modules/mobile/main.js',
      template: 'public/index.html',
      filename: 'index.html',
      title: 'Agile 移动端',
      chunks: ['vendor', 'agile', 'mobile']
    }
  }
}

const entry = entries[process.env.ENTRY]

module.exports = {
  outputDir: entry.outputDir,
  lintOnSave: true,
  pages: {
    index: entry.page
  },
  devServer: {
    port: 8080,
    before (app) {
      apiMocker(app, [path.resolve('./mocker/admin/index.js'), path.resolve('./mocker/mobile/index.js')])
    }
  },
  chainWebpack: config => {
    config.resolve.alias
      .set('@core', path.resolve('src/core'))
      .set('@admin', path.resolve('src/modules/admin'))
      .set('@mobile', path.resolve('src/modules/mobile'))

    config.optimization.splitChunks(
      {
        chunks: 'all',
        cacheGroups: {
          vendor: {
            test: /[\\/]node_modules[\\/]/,
            chunks: 'initial',
            name: 'vendor',
            priority: 10,
            enforce: true
          },
          element: {
            test: /[\\/]node_modules[\\/]_?element-ui(.*)/,
            name: 'element',
            priority: 20,
            enforce: true
          },
          agile: {
            test: /[\\/]src\/core[\\/]/,
            name: 'agile',
            priority: 5,
            enforce: true
          }
        }
      }
    )
  }
}
