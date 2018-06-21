const merge = require('webpack-merge')
const webpack = require('webpack')

const base = require('./webpack.base.js')

module.exports = merge(base, {
  mode: 'development',
  devtool: 'cheap-module-eval-source-map',
  resolve: {
    alias: {
      'vue$': 'vue/dist/vue.esm.js'
    }
  },
  devServer: {
    host: '127.0.0.1',
    port: 8080,
    contentBase: false,
    hot: true,
    headers: {
      'Access-Control-Allow-Origin': '*'
    }
  },
  output: {
    publicPath: 'http://127.0.0.1:8080/build/'
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: ['vue-style-loader', 'style-loader', 'css-loader']
      }
    ]
  },
  plugins: [
    new webpack.HotModuleReplacementPlugin()
  ]
})
