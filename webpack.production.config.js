var webpack = require('webpack');
var UglifyJSPlugin = require('uglifyjs-webpack-plugin');
var webpackConfig = require('./webpack.config.js');
var CleanWebpackPlugin = require('clean-webpack-plugin');
const merge = require('webpack-merge');
var path = require('path');
var ROOT = __dirname;

var pathsToClean = [
    'dist',
];

var cleanOptions = {
    root: __dirname,
    verbose: true,
    dry: false
};

module.exports = merge(webpackConfig, {
    mode: 'production',
    output: {
        path: path.resolve(ROOT, 'dist/js-chunks'),
        filename: '[name].[hash:8].bundle.js',
        chunkFilename: '[id].[hash:8].chunk.js',
        publicPath: '/wp-content/themes/twinVectr-Theme/dist/js-chunks/',
    },
    optimization: {
        splitChunks: {
            cacheGroups: {
                commons: {
                    name: 'commons',
                    chunks: 'all',
                    minChunks: 2,
                }
            }
        }
    },
    plugins: [
        new webpack.DefinePlugin({
            'PRODUCTION': JSON.stringify(true)
        }),
        new CleanWebpackPlugin(pathsToClean, cleanOptions),
        new UglifyJSPlugin(),
    ],

});