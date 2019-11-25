const path = require("path");
const fs = require("fs");

module.exports = {
  devServer: {
    host: "www.agile.test",
    https: {
      key: fs.readFileSync("cert/www.agile.test-key.pem"),
      cert: fs.readFileSync("cert/www.agile.test.pem")
    },
    http2: true,
    compress: true
  },
  configureWebpack: {
    resolve: {
      alias: {
        "@core": path.resolve("src/core"),
        "@admin": path.resolve("src/modules/admin"),
        "@mobile": path.resolve("src/modules/mobile")
      }
    }
  },
  chainWebpack: config => {
    config.optimization.splitChunks({
      chunks: "all",
      cacheGroups: {
        vendor: {
          test: /[\\/]node_modules[\\/]/,
          chunks: "initial",
          name: "vendor",
          priority: 10,
          enforce: true
        },
        element: {
          test: /[\\/]node_modules[\\/]_?element-ui(.*)/,
          name: "element",
          priority: 20,
          enforce: true
        },
        agile: {
          test: /[\\/]src\/core[\\/]/,
          name: "agile",
          priority: 5,
          enforce: true
        }
      }
    });
  }
};
