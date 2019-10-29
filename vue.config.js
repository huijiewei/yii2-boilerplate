const path = require('path')

function resolve(dir) {
  return path.join(__dirname, dir)
}

module.exports = {
  pages: {
    admin: {
      entry: 'src/modules/admin/main.js',
      template: 'public/index.html',
      filename: 'admin/index.html',
      title: 'Agile 管理后台',
      chunks: ['vendor', 'element', 'core', 'admin']
    },
    mobile: {
      entry: 'src/modules/mobile/main.js',
      template: 'public/index.html',
      filename: 'mobile/index.html',
      title: 'Agile 移动端',
      chunks: ['vendor', 'core', 'mobile']
    }
  },
  chainWebpack: config => {
    config.resolve.alias
      .set('@core', resolve('src/core'))
      .set('@admin', resolve('src/modules/admin'))
      .set('@mobile', resolve('src/modules/mobile'))

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
            priority: 20
          },
          agile: {
            test: /[\\/]src\/core[\\/]/,
            name: 'agile',
            priority: 5
          }
        }
      }
    )
  }
}
