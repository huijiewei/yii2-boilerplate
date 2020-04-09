const path = require('path')
const fs = require('fs')

const ManifestPlugin = require('webpack-manifest-plugin')

const isProduction = process.env.NODE_ENV === 'production'

module.exports = {
  devServer: {
    host: 'www.bp.test',
    https: {
      key: fs.readFileSync('certs/www.bp.test-key.pem'),
      cert: fs.readFileSync('certs/www.bp.test.pem'),
    },
    http2: true,
    compress: true,
    headers: { 'Access-Control-Allow-Origin': '*' },
    contentBase: path.resolve(__dirname, 'ui'),
  },
  configureWebpack: {
    context: path.resolve(__dirname, 'ui'),
    resolve: {
      alias: {
        '@core': path.resolve('ui/core'),
        '@admin': path.resolve('ui/modules/admin'),
        '@mobile': path.resolve('ui/modules/mobile'),
      },
    },
  },
  chainWebpack: (config) => {
    config.plugins.delete('copy')
    config.plugins.delete('html-admin')
    config.plugins.delete('preload-admin')
    config.plugins.delete('prefetch-admin')

    config.plugin('manifest').use(ManifestPlugin, [
      {
        writeToFileEmit: !isProduction,
        filter: function ({ name, isChunk }) {
          return isChunk && !name.startsWith('chunk-') && !name.endsWith('.map')
        },
      },
    ])

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
        boilerplate: {
          test: /[\\/]ui\/core[\\/]/,
          name: 'boilerplate',
          priority: 5,
          enforce: true,
        },
      },
    })
  },
}
