const ManifestPlugin = require('webpack-manifest-plugin')

const isProduction = process.env.NODE_ENV === 'production'

module.exports = {
  configureWebpack: {
    plugins: [
      new ManifestPlugin({
        writeToFileEmit: !isProduction,
        filter: function ({ name, isChunk }) {
          return isChunk && !name.startsWith('chunk-') && !name.endsWith('.map')
        }
      })
    ]
  },
  chainWebpack: config => {
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
