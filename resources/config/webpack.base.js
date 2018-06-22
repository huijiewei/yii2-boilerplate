const VueLoaderPlugin = require('vue-loader/lib/plugin')
const ManifestPlugin = require('webpack-manifest-plugin')
const path = require('path')

function resolve(dir) {
  return path.join(__dirname, '../', dir)
}

module.exports = {
  context: resolve('src'),
  entry: {
    'admin/app': './modules/admin/main.js'
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
      '@': resolve('src'),
      '@admin': resolve('src/modules/admin')
    },
    extensions: ['.js', '.vue', '.json']
  },
  module: {
    noParse: /node_modules\/(element-ui\.js)/,
    rules: [
      {
        test: /\.vue$/,
        include: resolve('src'),
        loader: 'vue-loader'
      },
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
  stats: {
    colors: true
  },
  plugins: [
    new VueLoaderPlugin(),
    new ManifestPlugin({
      fileName: 'admin.manifest.json',
      writeToFileEmit: true
    })
  ]
}
