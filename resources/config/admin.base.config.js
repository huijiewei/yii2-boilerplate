const antdThemes = {
  'layout-header-height': '50px',
  'layout-header-background': '#FFF',
  'menu-item-height': '39px',
  'menu-inline-toplevel-item-height': '39px',
  'menu-collapsed-width': '60px',
  '@icon-url': '"/statics/assets/iconfont/iconfont"'
}

const path = require('path')

const Config = require('./webpack/Config')
const config = new Config()

config.app = 'admin'
config.context = path.resolve(__dirname, '../modules/admin')
config.addEntry('app', './app.js')
config.outputPath = path.resolve(__dirname, '../../public/statics/build/admin')
config.publicPath = '/statics/build/admin/'
config.usePostCssLoader = true
config.useSassLoader = true
config.useLessLoader = true
config.useSourceMaps = true

config.aliases = {
  '@admin': path.resolve(__dirname, '../modules/admin'),
  '@core': path.resolve(__dirname, '../core')
}

config.lessLoaderOptionsCallback = function(options) {
  options.javascriptEnabled = true
  options.modifyVars = antdThemes
}

module.exports = config
