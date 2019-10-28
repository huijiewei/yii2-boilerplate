const path = require('path')

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
      .set('@core', path.resolve('src/core'))
      .set('@admin', path.resolve('src/modules/admin'))

    config.optimization.splitChunks(
      {
        chunks: 'all',
        cacheGroups: {
          vendor: {
            test: /[\\/]node_modules[\\/]/,
            name: 'vendor',
            priority: 10,
            chunks: 'initial',
            enforce: true
          },
          element: {
            test: /[\\/]node_modules[\\/]_?element-ui(.*)/,
            name: 'element',
            priority: 20,
            enforce: true
          },
          core: {
            name: 'core',
            test: path.resolve('src/core'),
            minChunks: 3,
            priority: 5,
            reuseExistingChunk: true
          }
        }
      }
    )
  }
}
