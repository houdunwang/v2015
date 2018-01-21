const path = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

function resolve(dir) {
    return path.join(__dirname, '..', dir)
}

module.exports = {
    entry: './resource/assets/app.js',
    output: {
        filename: 'js/app.js',
        path: path.resolve(__dirname, 'resource/build'),
        publicPath: "/resource/build/"
    },
    plugins: [
        //清理打包目录
        new CleanWebpackPlugin([path.resolve(__dirname, 'resource/build')]),
        new ExtractTextPlugin("css/app.css")
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader', options: {presets: ['env']}
                }
            },
            {
                test: /\.vue$/, loader: 'vue-loader',
                options: {presets: ['env'],}
            },
            {
                test: /\.(woff|woff2|eot|ttf|svg)$/,
                use: [{
                    loader: 'url-loader',
                    options: {limit: 8192, name: 'font/[hash].[ext]'}
                }]
            },
            {
                test: /\.(jpeg|jpg|png|gif)$/,
                use: [{
                    loader: 'url-loader',
                    options: {limit: 8192, name: 'images/[hash].[ext]'}
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
    },
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.js',
            '@': resolve('assets')
        }
    }
};