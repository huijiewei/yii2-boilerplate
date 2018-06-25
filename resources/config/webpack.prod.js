const ExtractTextPlugin = require('extract-text-webpack-plugin')
const CleanWebpackPlugin = require('clean-webpack-plugin')

const path = require('path')
const merge = require('webpack-merge')

const base = require('./webpack.base.js')

module.exports = merge(base, {
  output: {
    filename: '[name].[chunkhash].js',
    chunkFilename: '[name].[chunkhash].js'
  },
  optimization: {
    splitChunks: {
      cacheGroups: {
        vendor: {
          test: /[\\/]node_modules[\\/]/,
          name: 'vendor',
          chunks: 'all',
          priority: -10
        },
        styles: {
          name: 'styles',
          test: /\.css$/,
          chunks: 'all'
        }
      }
    }
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: 'css-loader'
        })
      }
    ]
  },
  plugins: [
    new CleanWebpackPlugin([
      path.join(base.output.path, '*')
    ], { allowExternal: true }),
    new ExtractTextPlugin({
      filename: '[name].[chunkhash].css',
      allChunks: true
    })
  ]
})

