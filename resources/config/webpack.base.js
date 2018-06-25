const ManifestPlugin = require('webpack-manifest-plugin')
const path = require('path')

function resolve(dir) {
  return path.join(__dirname, '../', dir)
}

const NODE_ENV = process.env.NODE_ENV

module.exports = {
  mode: NODE_ENV,
  target: 'web',
  context: resolve('src'),
  entry: {
    'admin/app': './modules/admin/app.js'
  },
  output: {
    filename: '[name].js',
    chunkFilename: '[name].js',
    path: resolve('../public/build'),
    publicPath: '/build/'
  },
  resolve: {
    modules: [resolve('src'), resolve('../node_modules')],
    alias: {
      '@core': resolve('src/core'),
      '@admin': resolve('src/modules/admin')
    },
    extensions: ['.js', '.json']
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        include: resolve('src'),
        loader: 'babel-loader?cacheDirectory'
      },
      {
        test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
        include: resolve('src'),
        loader: 'url-loader',
        query: {
          limit: 8192,
          name: 'images/[name].[hash:7].[ext]'
        }
      },
      {
        test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
        loader: 'url-loader',
        options: {
          limit: 10000,
          name: 'fonts/[name].[hash:7].[ext]'
        }
      }
    ]
  },
  plugins: [
    new ManifestPlugin({
      fileName: 'admin.manifest.json',
      writeToFileEmit: true
    })
  ]
}
