'use strict'

const ManifestPlugin = require('webpack-manifest-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const CleanWebpackPlugin = require('clean-webpack-plugin')

const path = require('path')

const NODE_ENV = process.env.NODE_ENV

class Generator {
  /**
   * @param {Config} config
   */
  constructor(config) {
    this.config = config
  }

  static applyOptionsCallback(optionsCallback, options) {
    const result = optionsCallback.call(options, options)

    if (typeof result === 'object') {
      return result
    }

    return options
  }

  static isProduction() {
    return NODE_ENV === 'production'
  }

  buildOutputConfig() {
    return {
      path: this.config.outputPath,
      publicPath: this.config.publicPath,
      pathinfo: !Generator.isProduction(),
      filename: Generator.isProduction() ? '[name].[chunkhash].js' : '[name].js',
      chunkFilename: Generator.isProduction() ? '[name].[chunkhash].js' : '[name].js'
    }
  }

  buildRulesConfig() {
    let rules = []

    rules.push({
      test: /\.js$/,
      exclude: /(node_modules|bower_components)/,
      loader: 'babel-loader?cacheDirectory'
    })

    rules.push({
      test: /\.css$/,
      use: [
        Generator.isProduction() ? MiniCssExtractPlugin.loader : 'style-loader',
        {
          loader: 'css-loader',
          options: {
            sourceMap: this.config.useSourceMaps
          }
        }
      ]
    })

    rules.push({
      test: /\.(png|jpg|jpeg|gif|ico|svg|webp)$/,
      loader:
        'url-loader',
      options:
        {
          limit: 8192,
          name:
            'images/[name].[hash:7].[ext]'
        }
    })

    rules.push({
      test: /\.(woff|woff2|ttf|eot|otf)$/,
      loader:
        'url-loader',
      options:
        {
          limit: 16384,
          name:
            'fonts/[name].[hash:7].[ext]'
        }
    })

    if (this.config.useSassLoader) {
      rules.push(
        {
          test: /\.s[ca]ss$/,
          use: [
            Generator.isProduction() ? MiniCssExtractPlugin.loader : 'style-loader',
            'css-loader',
            'sass-loader'
          ]
        })
    }

    if (this.config.useLessLoader) {
      rules.push({
        test: /\.less$/,
        use: [
          Generator.isProduction() ? MiniCssExtractPlugin.loader : 'style-loader',
          'css-loader',
          {
            loader: 'less-loader',
            options: Generator.applyOptionsCallback(this.config.lessLoaderOptionsCallback, {
              sourceMap: this.config.useSourceMaps
            })
          }
        ]
      })
    }

    this.config.loaders.forEach((loader) => {
      rules.push(loader)
    })

    return rules
  }

  buildPluginsConfig() {
    const plugins = []

    plugins.push({
      plugin: new MiniCssExtractPlugin({
        filename: Generator.isProduction() ? '[name].[chunkhash].css' : '[name].css',
        chunkFilename: Generator.isProduction() ? '[name].[chunkhash].css' : '[name].css'
      }),
      priority: 0
    })

    plugins.push({
      plugin: new ManifestPlugin({
        fileName: 'manifest.json',
        writeToFileEmit: true,
        filter: function({ isChunk, isInitial }) {
          return isChunk && isInitial
        }
      }),
      priority: 0
    })

    if (Generator.isProduction()) {
      plugins.push({
        plugin: new CleanWebpackPlugin([path.join(this.config.outputPath, '*')], { allowExternal: true }),
        priority: 0
      })
    }

    this.config.plugins.forEach(function(plugin) {
      plugins.push(plugin)
    })

    return plugins
      .map((plugin, position) => Object.assign({}, plugin, { position: position }))
      .sort((a, b) => {
        if (a.priority === b.priority) {
          return a.position - b.position
        }
        return b.priority - a.priority
      })
      .map((plugin) => plugin.plugin)
  }

  buildOptimizationConfig() {
    const optimization = {}

    if (Generator.isProduction()) {
      let splitChunks = {
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

      optimization.splitChunks = Generator.applyOptionsCallback(
        this.config.splitChunksConfigurationCallback,
        splitChunks
      )

      optimization.minimizer = [
        new UglifyJsPlugin({
          parallel: true,
          cache: true,
          sourceMap: this.config.useSourceMaps
        }),
        new OptimizeCssAssetsPlugin()
      ]
    } else {
      optimization.namedModules = true
    }

    return optimization
  }

  buildDevServerConfig() {
    return {
      host: this.config.devServerHost || 'localhost',
      port: this.config.devServerPort || 8080,
      contentBase: this.config.publicPath,
      headers: { 'Access-Control-Allow-Origin': '*' },
      inline: true,
      watchOptions: {
        ignored: /node_modules/
      }
    }
  }

  buildEntryConfig() {
    const entry = {}

    for (const [entryName, entryChunks] of this.config.entries) {
      entry[entryName] = entryChunks
    }

    return entry
  }

  getWebpackConfig() {
    let webpackConfig = {
      mode: NODE_ENV,
      target: this.config.target || 'web',
      context: this.config.context,
      entry: this.buildEntryConfig(),
      output: this.buildOutputConfig(),
      module: {
        rules: this.buildRulesConfig()
      },
      plugins: this.buildPluginsConfig(),
      optimization: this.buildOptimizationConfig()
    }

    if (this.config.useSourceMaps) {
      if (Generator.isProduction()) {
        webpackConfig.devtool = 'cheap-module-source-map'
      } else {
        webpackConfig.devtool = 'cheap-module-eval-source-map'
      }
    }

    if (this.config.useDevServer) {
      let devServerConfig = this.buildDevServerConfig()

      webpackConfig.output.publicPath = 'http://' + devServerConfig.host + ':' + devServerConfig.port + '/'
      webpackConfig.devServer = devServerConfig
    }

    webpackConfig.resolve = {
      extensions: ['.js', '.jsx', '.vue', '.ts', '.tsx'],
      alias: this.config.aliases
    }

    webpackConfig.performance = {
      hints: false
    }

    webpackConfig.externals = this.config.externals

    return webpackConfig
  }
}

module.exports = function(config) {
  return new Generator(config).getWebpackConfig()
}
