const VueLoaderPlugin = require('vue-loader/lib/plugin')
const ManifestPlugin = require('webpack-manifest-plugin')
const path = require('path')

module.exports = {
  context: path.resolve(__dirname, '../src'),
  entry: {
    admin: './modules/admin/main.js'
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, '../../public/build'),
    publicPath: '/build/'
  },
  resolve: {
    extensions: ['.js', '.vue', '.json']
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        include: path.resolve(__dirname, '../src'),
        loader: 'vue-loader'
      },
      {
        test: /\.js$/,
        include: path.resolve(__dirname, '../src'),
        loader: 'babel-loader?cacheDirectory'
      },
      {
        test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
        loader: 'url-loader',
        options: {
          limit: 10000
        }
      }
    ]
  },
  plugins: [
    new VueLoaderPlugin(),
    new ManifestPlugin({
      fileName: 'admin.manifest.json',
      writeToFileEmit: true
    })
  ]
}
