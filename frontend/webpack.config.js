const path = require("path");
const webpack = require("webpack");
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const NODE_ENV = process.env.NODE_ENV || "development";

module.exports = {
  entry: { technologist: "./src/js/technologist.js" },
  output: {
    path: path.resolve(__dirname, "../public/js/"),
    filename: "[name].js",
    publicPath: "/build/js/"
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
        use: ["vue-style-loader", "css-loader", "sass-loader"]
      },
      {
        test: /\.css$/,
        loader: ["vue-style-loader", "css-loader"]
      },
      {
        test: /\.(png|svg|jpg|gif)$/,
        use: ["file-loader"]
      }
    ]
  },
  resolve: {
    extensions: [".css", ".sass", ".js", ".vue"]
  },
  devServer: {
    overlay: true
  },
  plugins: [new VueLoaderPlugin()],
  devtool: "source-map",
  mode: "development"
};
