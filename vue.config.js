const path = require('path')
const fs = require('fs')

module.exports = {
  assetsDir: 'assets',
  devServer: {
    host: 'www.agile.test',
    https: {
      key: fs.readFileSync('certs/www.agile.test-key.pem'),
      cert: fs.readFileSync('certs/www.agile.test.pem'),
    },
    http2: true,
    compress: true,
  },
  chainWebpack: (config) => {
    config.resolve.alias
      .set('@core', path.resolve('src/core'))
      .set('@admin', path.resolve('src/modules/admin'))
      .set('@mobile', path.resolve('src/modules/mobile'))
      .delete('@')

    config.optimization.splitChunks({
      chunks: 'all',
      cacheGroups: {
        vendor: {
          test: /[\\/]node_modules[\\/]/,
          chunks: 'initial',
          name: 'vendor',
          priority: 10,
          enforce: true,
        },
        element: {
          test: /[\\/]node_modules[\\/]_?element-ui(.*)/,
          name: 'element',
          priority: 20,
          enforce: true,
        },
        agile: {
          test: /[\\/]src\/core[\\/]/,
          name: 'agile',
          priority: 5,
          enforce: true,
        },
      },
    })
  },
}
