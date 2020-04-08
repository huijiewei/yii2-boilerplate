const assign = require('assign-deep')

const isProduction = process.env.NODE_ENV === 'production'

const vueConfig = require('./vue.config')

const customConfig = {
  publicPath: isProduction ? '/statics/build/admin' : '/admin',
  outputDir: 'public/statics/build/admin',
  pages: {
    admin: {
      entry: 'ui/modules/admin/main.js',
      chunks: ['vendor', 'element', 'agile', 'admin'],
    },
  },
  devServer: {
    port: 8080,
  },
}

const config = assign(vueConfig, customConfig)

module.exports = config
