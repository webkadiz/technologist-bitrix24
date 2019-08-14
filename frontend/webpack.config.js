const path = require("path");
const webpack = require("webpack");
const HtmlWebpackPlugin = require('html-webpack-plugin');
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const NODE_ENV = process.env.NODE_ENV || "development";

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
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env"],
            plugins: [
              "@babel/plugin-proposal-object-rest-spread",
              "@babel/plugin-syntax-dynamic-import",
              "@babel/plugin-proposal-class-properties",
              "@babel/plugin-transform-async-to-generator"
            ]
          }
        }
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
    overlay: true
  },
  plugins: [
    new VueLoaderPlugin(),
    new HtmlWebpackPlugin({
      template: 'src/index.html',
      chunks: ['technologist'],
    })
  ],
  devtool: env === "dev" ? "source-map" : void 0,
});
