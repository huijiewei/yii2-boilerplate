const path = require('path')
const apiMocker = require('mocker-api')
const ManifestPlugin = require('webpack-manifest-plugin');

const isProduction = process.env.NODE_ENV === 'production'

const entries = {
  admin: {
    publicPath: isProduction ? './' : '/admin',
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
    devServerPort: process.env.DEV_SERVER_ADMIN_PORT,
    mockerWatchFile: './mocker/admin/index.js',
    alias: {
      '@admin': 'src/modules/admin'
    }
  },
  mobile: {
    publicPath: isProduction ? './' : '/mobile',
    outputDir: 'dist/mobile',
    pages: {
      mobile: {
        entry: 'src/modules/mobile/main.js',
        template: 'public/index.html',
        filename: 'index.html',
        title: 'Agile 移动端',
        chunks: ['vendor', 'agile', 'mobile']
      }
    },
    devServerPort: process.env.DEV_SERVER_MOBILE_PORT,
    mockerWatchFile: './mocker/mobile/index.js',
    alias: {
      '@mobile': 'src/modules/mobile'
    }
  }
}

const entry = entries[process.env.ENTRY]

module.exports = {
  publicPath: entry.publicPath,
  outputDir: entry.outputDir,
  pages: entry.pages,
  devServer: {
    port: entry.devServerPort,
    before (app) {
      apiMocker(app, path.resolve(entry.mockerWatchFile))
    }
  },
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
    config.resolve.alias
      .set('@core', path.resolve('src/core'))

    Object.keys(entry.alias).forEach(key => {
      config.resolve.alias.set(key, path.resolve(entry.alias[key]))
    })

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
