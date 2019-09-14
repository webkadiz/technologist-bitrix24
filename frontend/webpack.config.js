const path = require("path");
const webpack = require("webpack");
const HtmlWebpackPlugin = require('html-webpack-plugin');
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')

module.exports = env => ({
  entry: { technologist: "./src/js/technologist.js", print: "./src/js/print.js" },
  output: {
    path: path.resolve(__dirname, "../web/assets/"),
    filename: "js/[name].js",
    publicPath: "/"
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        use: "babel-loader"
      },
      {
        test: /\.vue$/,
        use: "vue-loader"
      },
      {
        test: /\.(sass|scss)$/,
        use: ["vue-style-loader", "css-loader", {
          loader: "sass-loader",
          options: {
            implementation: require('sass'),
            fiber: require('fibers'),
            includePaths: ['./node_modules']
          }
        }]
      },
      {
        test: /\.css$/,
        loader: ["vue-style-loader", "css-loader"]
      }
    ]
  },
  resolve: {
    extensions: [".css", ".scss", ".sass", ".js", ".vue"],
    alias: {
      '@sass': __dirname + '/src/sass',
      '@components': __dirname + '/src/js/components'
    }
  },
  devServer: {
    overlay: true,
    port: 4000
  },
  plugins: [
    new VueLoaderPlugin(),
    new HtmlWebpackPlugin({
      template: 'src/index.html',
      chunks: ['technologist'],
    }),
    new webpack.DefinePlugin({
      DEVELOPMENT: JSON.stringify(env === 'dev'),
      PRODUCTION: JSON.stringify(env === 'prod')
    }),
    new VuetifyLoaderPlugin()
  ],
  devtool: env === "dev" ? "source-map" : void 0,
});
