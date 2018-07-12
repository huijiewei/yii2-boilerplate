const SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin')
const configGenerator = require('./webpack/Generator')

const config = require('./admin.base.config')

config.addPlugin(new SWPrecacheWebpackPlugin({
  cacheId: config.app,
  dontCacheBustUrlsMatching: /\.\w{8}\./,
  filename: 'service-worker.js',
  minify: true,
  staticFileGlobsIgnorePatterns: [/\.map$/, /manifest\.json$/]
}))

const webpackConfig = configGenerator(config)

module.exports = webpackConfig
