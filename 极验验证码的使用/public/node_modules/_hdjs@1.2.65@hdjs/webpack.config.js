const path = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const HtmlWebpackPlugin = require('html-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin')
const webpack = require('webpack');

function resolve(dir) {
    return path.join(__dirname, '..', dir)
}

module.exports = {
    entry: {
        hdjs: './src/hdjs.js',
        app: './src/app.js'
        // common:['jquery']
    },
    output: {
        //输出目录
        path: path.resolve(__dirname, 'dist'),
        filename: '[name].js',
        sourceMapFilename: '[name].map',
        // chunkFilename: '[name].min.js',
        libraryTarget: "umd",
        library: "hdjs"
    },
    externals: {},
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {'vue': 'vue/dist/vue.js', '@': resolve('src')}
    },
    //热加载使用的项目目录
    devServer: {contentBase: path.join(__dirname, "dist"), port: 9000},
    plugins: [
        // new webpack.optimize.CommonsChunkPlugin({
        //     name: "commons",
        //     // ( 公共chunk(commnons chunk) 的名称)
        //     filename: "commons.js"
        // }),
        //压缩代码
        // new UglifyJSPlugin({output: {comments: false}}),
        //清理打包目录
        new CleanWebpackPlugin(['dist']),
        //生成css文件
        new ExtractTextPlugin("hdjs.css"),
        //模板文件并生成到dist目录中，用于热加载使用
        new HtmlWebpackPlugin({title: 'hdjs-vue', template: __dirname + '/src/module.html'}),
        new webpack.ProvidePlugin({$: "jquery", jQuery: "jquery", "window.jQuery": "jquery"}),
        new CopyWebpackPlugin([{from: 'static', to: 'static'}])
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {loader: 'babel-loader', options: {presets: ['env']}}
            },
            {
                test: /\.(woff|woff2|eot|ttf|svg|jpg|png|gif)$/,
                use: [{
                    loader: 'url-loader',
                    options: {limit: 10000, name: '[path][name].[ext]',}
                }]
            },
            {
                test: /\.css/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [{loader: 'css-loader', options: {minimize: true}}]
                })
            },
            {
                test: /\.less$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        {loader: 'css-loader', options: {minimize: true}},
                        {loader: 'less-loader'}
                    ]
                })
            },
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        {loader: 'css-loader', options: {minimize: true}},
                        {loader: 'sass-loader'}
                    ]
                })
            }
        ]
    }
};