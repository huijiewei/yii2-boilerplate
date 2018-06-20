const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const CleanWebpackPlugin = require('clean-webpack-plugin')

const path = require('path')
const merge = require('webpack-merge')

const base = require('./webpack.base.js')

module.exports = merge(base, {
  mode: 'production',
  output: {
    filename: '[name].[chunkhash].js'
  },
  optimization: {
    splitChunks: {
      cacheGroups: {
        vendor: {
          test: /[\\/]node_modules[\\/]/,
          name: 'vendor',
          chunks: 'all'
        },
        styles: {
          name: 'styles',
          test: /\.css$/,
          chunks: 'all'
        }
      }
    }
  },
  plugins: [
    new CleanWebpackPlugin([path.join(base.output.path, '*.*')], { allowExternal: true }),
    new MiniCssExtractPlugin({
      filename: '[name].[chunkhash].css'
    })
  ],
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [MiniCssExtractPlugin.loader, 'css-loader']
      }
    ]
  }
})

