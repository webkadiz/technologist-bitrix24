const path = require("path");
const webpack = require("webpack");
const HtmlWebpackPlugin = require('html-webpack-plugin');
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')

module.exports = env => ({
  entry: { technologist: "./src/entry/technologist.js", print: "./src/entry/print.js" },
  output: {
    path: path.resolve(__dirname, "../web/assets/"),
    filename: "js/[name].js",
    publicPath: env === "dev" ? "/" : "/assets/"
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
      },
      {
        test: /\.(ttf|woff|woff2|eot)/,
        use: 'url-loader'
      }
    ]
  },
  resolve: {
    extensions: [".css", ".scss", ".sass", ".js", ".vue"],
    alias: {
      '@': __dirname + '/src',
      vue: 'vue/dist/vue.esm'
    }
  },
  devServer: {
    overlay: true,
    port: 4000,
    historyApiFallback: true
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
