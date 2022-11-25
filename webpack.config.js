const {DefinePlugin} = require('webpack');
const {NoEmitOnErrorsPlugin} = require('webpack');
const {ProvidePlugin} = require('webpack');
const path = require('path');

const miniCssExtractPlugin = require('mini-css-extract-plugin');
const cssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const terserPlugin = require('terser-webpack-plugin');
const htmlWebpackPlugin = require('html-webpack-plugin');

const NODE_ENV = process.env.NODE_ENV || 'development';

let publicPath = '/assets';
if (NODE_ENV === 'production') {
    publicPath = '/bundles/hs/themes/istra/assets';
}

module.exports = {
    mode: NODE_ENV,
    entry: [
        './frontend/app.js',
        './frontend/scss/main.scss',
    ],
    output: {
        path: path.resolve(__dirname, 'public/assets/'),
        publicPath: publicPath,
        filename: 'js/[name].js'
    },

    watch: (NODE_ENV === 'development'),
    watchOptions: {
        aggregateTimeout: 100
    },

    module: {
        rules: [
            {
                test: /\.(sass|scss)/,
                exclude: /node_modules|\.git/,
                use: [
                    miniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            esModule: false
                        },
                    }, {
                        loader: 'resolve-url-loader',
                    }, {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true,
                        }
                    }
                ]
            }, {
                test: /\.(ttf|eot|woff|woff2)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[folder]/[name].[ext]',
                            publicPath: publicPath,
                        }
                    }
                ]
            }, {
                test: /\.(png|jpg|jpeg|gif|ico|svg)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            publicPath: publicPath + '/images/',
                            outputPath: 'images/',
                            esModule: false,
                        }
                    }
                ]
            }
        ]
    },

    plugins: [
        new DefinePlugin({
            NODE_ENV: JSON.stringify(process.env.NODE_ENV),
            LANG: JSON.stringify('ru')
        }),
        new NoEmitOnErrorsPlugin(),
        require('autoprefixer'),
        new miniCssExtractPlugin({
            filename: "css/style.css",
        }),
        new htmlWebpackPlugin({
            filename: __dirname + '/public/index.php',
            title: 'Главная страница',
            template: __dirname + '/frontend/index.php',
            favicon: __dirname + '/frontend/favicon.ico'
        }),
        new htmlWebpackPlugin({
            filename: __dirname + '/public/faq.php',
            title: 'FAQ',
            template: __dirname + '/frontend/faq.php',
            inject: false
        }),
        new ProvidePlugin({
            $: 'jquery/dist/jquery.min.js',
            jQuery: 'jquery/dist/jquery.min.js',
            'window.jQuery': 'jquery/dist/jquery.min.js'
        })
    ],

    performance: {
        hints: false
    },

    optimization: {
        emitOnErrors: true,
        minimize: (NODE_ENV === 'production'),
        minimizer: [].concat(NODE_ENV === 'production' ? [
            new terserPlugin({
                extractComments: false,
            }),
            new cssMinimizerPlugin(),
        ] : [])
    }
}