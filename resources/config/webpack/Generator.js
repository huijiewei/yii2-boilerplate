'use strict'

const ManifestPlugin = require('webpack-manifest-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const CleanWebpackPlugin = require('clean-webpack-plugin')
const autoprefixer = require('autoprefixer')
const VueLoaderPlugin = require('vue-loader/lib/plugin')
const StylelintPlugin = require('stylelint-webpack-plugin')

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

  getStyleLoaders(appendLoader = null) {
    let loaders = []

    loaders.push(Generator.isProduction() ? MiniCssExtractPlugin.loader : 'vue-style-loader')

    loaders.push({
      loader: 'css-loader',
      options: {
        importLoaders: this.config.usePostCssLoader ? 1 : 0,
        sourceMap: false
      }
    })

    if (this.config.usePostCssLoader) {
      loaders.push({
        loader: 'postcss-loader',
        options: Generator.applyOptionsCallback(this.config.postCssLoaderOptionsCallback, {
          ident: 'postcss',
          sourceMap: false,
          plugins: () => [
            autoprefixer()
          ]
        })
      })
    }

    if (appendLoader != null) {
      loaders.push(appendLoader)
    }

    return loaders
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
      enforce: 'pre',
      test: /\.(js|vue)$/,
      loader: 'eslint-loader',
      exclude: /node_modules/
    })

    rules.push({
      test: /\.vue/,
      loader: 'vue-loader'
    })

    rules.push({
      test: /\.js$/,
      loader: 'babel-loader?cacheDirectory',
      exclude: file => (
        /node_modules/.test(file) &&
        !/\.vue\.js/.test(file)
      )
    })

    rules.push({
      test: /\.css$/,
      use: this.getStyleLoaders()
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
      rules.push({
        test: /\.s[ca]ss$/,
        use: this.getStyleLoaders({
          loader: 'sass-loader',
          options: Generator.applyOptionsCallback(this.config.sassLoaderOptionsCallback, {
            sourceMap: false
          })
        })
      })
    }

    if (this.config.useLessLoader) {
      rules.push({
        test: /\.less$/,
        use: this.getStyleLoaders({
          loader: 'less-loader',
          options: Generator.applyOptionsCallback(this.config.lessLoaderOptionsCallback, {
            sourceMap: false
          })
        })
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
      plugin: new StylelintPlugin({
        files: ['**/*.vue', '**/*.css', '**/*.less', '**/*.scss']
      }),
      priority: 0
    })

    plugins.push({
      plugin: new VueLoaderPlugin(),
      priority: 0
    })

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
        writeToFileEmit: !Generator.isProduction(),
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

    return plugins.map((plugin, position) => Object.assign({}, plugin, { position: position })).sort((a, b) => {
      if (a.priority === b.priority) {
        return a.position - b.position
      }
      return b.priority - a.priority
    }).map((plugin) => plugin.plugin)
  }

  buildOptimizationConfig() {
    const optimization = {}

    if (Generator.isProduction()) {
      optimization.minimizer = [
        new UglifyJsPlugin({
          parallel: true,
          cache: true,
          sourceMap: this.config.useSourceMaps
        }),
        new OptimizeCssAssetsPlugin()
      ]

      let splitChunks = {
        cacheGroups: {
          vendor: {
            test: /[\\/]node_modules[\\/]/,
            name: 'vendor',
            chunks: 'all',
            enforce: true
          },
          styles: {
            name: 'styles',
            test: /\.(css|less|scss)$/,
            chunks: 'all'
          }
        }
      }

      optimization.splitChunks = Generator.applyOptionsCallback(
        this.config.splitChunksConfigurationCallback,
        splitChunks
      )
    } else {
      optimization.namedModules = true
    }

    return optimization
  }

  buildDevServerConfig() {
    return {
      host: this.config.devServerHost || 'localhost',
      port: this.config.devServerPort || 8080,
      compress: true,
      contentBase: false,
      publicPath: this.config.publicPath,
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
      mode: Generator.isProduction() ? 'production' : 'development',
      target: this.config.target || 'web',
      context: this.config.context,
      entry: this.buildEntryConfig(),
      output: this.buildOutputConfig(),
      module: {
        strictExportPresence: true,
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

      webpackConfig.output.publicPath = 'http://' + devServerConfig.host + ':' + devServerConfig.port +
        devServerConfig.publicPath
      webpackConfig.devServer = devServerConfig
    }

    webpackConfig.resolve = {
      modules: [
        path.resolve(__dirname, '../../../node_modules')
      ],
      extensions: ['.js', '.vue', '.json'],
      alias: this.config.aliases
    }

    webpackConfig.resolveLoader = {
      modules: [
        path.resolve(__dirname, '../../../node_modules')
      ]
    }

    webpackConfig.performance = {
      hints: Generator.isProduction() ? 'warning' : false
    }

    webpackConfig.externals = this.config.externals

    return webpackConfig
  }
}

module.exports = function(config) {
  return new Generator(config).getWebpackConfig()
}
