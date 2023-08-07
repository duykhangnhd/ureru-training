var path = require("path");
const VueLoaderPlugin = require("vue-loader/lib/plugin");
require("@babel/polyfill");

module.exports = {
    mode: "development",
    entry: "./resources/app.js",
    output: {
        path: path.resolve(__dirname, "./webroot/js"),
        filename: "app.js",
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
              },
              {
                test: /\.js$/,
                use: {
                  loader: 'babel-loader',
                  options: {
                      presets: [
                          ['@babel/preset-env', {
                              "targets": {
                                  "chrome": "58",
                                  "ie": "11"
                              }
                          }]
                      ]
                  },
                },
              },
              {
                test: /\.css$/,
                use: [{
                  loader:'vue-style-loader'
                }, {
                  loader:'style-loader'
                }, {
                  loader: 'css-loader',
                }]
              },
              {
                test: /\.(png|jpe|jpg?g|gif|svg)$/i,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            outputPath: '/images',
                            limit: 8192,
                        },
                    },
                ],
              },
              {
                test: /\.(woff2?|eot|ttf|otf)$/,
                loader: 'file-loader',
                options: {
                  name: '[name].[ext]',
                  outputPath: 'fonts/', // Output path for the fonts
                  publicPath: '../fonts/', // Public path to access the fonts from CSS
                },
              }
        ],
    },
    plugins: [new VueLoaderPlugin()],
    resolve: {
        extensions: [".js", ".vue", ".css", ".png", ".jpg"],
        alias: {
            vue: 'vue/dist/vue.min.js',
            axios: 'axios/dist/axios.js',
            vue$: 'vue/dist/vue.runtime.esm.min.js'
        }
    },
};
