const path = require('path')

const { WebpackManifestPlugin }  = require('webpack-manifest-plugin')

const isProduction = process.env.NODE_ENV === 'production'

const config = {
  configureWebpack: {
    context: path.resolve(__dirname, 'ui')
  },
  chainWebpack: (config) => {
    config.resolve.alias
      .set('@core', path.resolve('ui/core'))
      .set('@admin', path.resolve('ui/modules/admin'))
      .set('@mobile', path.resolve('ui/modules/mobile'))
      .delete('@')

    config.plugins.delete('copy')
    config.plugins.delete('html')
    config.plugins.delete('preload')
    config.plugins.delete('prefetch')

    config.plugin('manifest').use(WebpackManifestPlugin, [
      {
        writeToFileEmit: !isProduction,
        filter: function({ name, isChunk }) {
          return isChunk && !name.startsWith('chunk-') && !name.endsWith('.map')
        }
      }
    ])

    config.optimization.splitChunks({
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
        boilerplate: {
          test: /[\\/]ui\/core[\\/]/,
          name: 'boilerplate',
          priority: 5,
          enforce: true
        }
      }
    })
  }
}

if (!isProduction) {
  config.devServer = {
    host: 'www.bp.test',
    https: false,
    compress: true,
    headers: { 'Access-Control-Allow-Origin': '*' },
    contentBase: path.resolve(__dirname, 'ui')
  }
}

module.exports = config
