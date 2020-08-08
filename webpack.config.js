const webpack = require('webpack');
const path    = require('path');

const miniCssTextPlugin       = require("mini-css-extract-plugin");
const htmlWebpackPlugin       = require("html-webpack-plugin");
const optimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const terserPlugin            = require('terser-webpack-plugin');

const NODE_ENV = process.env.NODE_ENV || 'development';

let publicPath = '/assets';
if (NODE_ENV === 'production') {
    publicPath = '/bundles/hs/themes/istra/assets';
}

const config = {
    mode: NODE_ENV,
    context: __dirname + '/frontend',
    entry: [
        './app.js',
        './scss/main.scss'
    ],
    output: {
        path: path.resolve(__dirname, 'public/assets'),
        publicPath: publicPath,
        filename: 'js/[name].js'
    },

    //watch: (NODE_ENV === 'development'),
    watchOptions: {
        aggregateTimeout: 100
    },

    optimization: {
        noEmitOnErrors: true,
        minimize: true,
        minimizer: []
    },

    performance: {
        hints: false
    },
    
    module: {
        rules: [
            {
                test: /\.(sass|scss)/,
                exclude: /node_modules|\.git/,
                use: [
                    {
                        loader: miniCssTextPlugin.loader
                    }, {
                        loader: 'css-loader'
                    }, {
                        loader: 'resolve-url-loader'
                    }, {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true
                        }
                    }
                ]
            }, {
                test: /\.(png|jpg|gif|ico)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: 'img/[name].[ext]',
                            esModule: false,
                            publicPath: publicPath
                        }
                    }
                ]
            }, {
                test: /\.(ttf|eot|woff)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: 'fonts/[name].[ext]',
                            esModule: false,
                            publicPath: publicPath
                        }
                    }
                ]
            }
        ]
    },
    
    plugins: [
        new webpack.DefinePlugin({
            NODE_ENV: JSON.stringify(NODE_ENV),
            LANG: JSON.stringify('ru')
        }),
        new miniCssTextPlugin({
            filename: 'css/style.css'
        }),
        new htmlWebpackPlugin({
            filename: __dirname + '/public/index.php',
            title: 'Главная страница',
            template: __dirname + '/frontend/index.php',
            favicon: __dirname + '/frontend/favicon.ico',
            minify: false
        }),
        new htmlWebpackPlugin({
            filename: __dirname + '/public/faq.php',
            title: 'FAQ',
            template: __dirname + '/frontend/faq.php',
            inject: false,
            minify: false
        }),
        new webpack.ProvidePlugin({
            $: 'jquery/dist/jquery.min.js',
            jQuery: 'jquery/dist/jquery.min.js',
            "window.jQuery": 'jquery/dist/jquery.min.js'
        }),
    ]
};

if (NODE_ENV === 'production') {
    config.optimization.minimizer =
        [
            new terserPlugin({
                terserOptions: {
                    warnings: false,
                    compress: {
                        drop_console: true,
                        unsafe: true
                    }
                }
            })
        ];

    config.plugins.push(
        new optimizeCssAssetsPlugin({
            assetNameRegExp: /\.css$/,
            cssProcessor: require('cssnano'),
            cssProcessorOptions: {
                autoprefixer: true,
                discardComments: {removeAll: true }
            },
            canPrint: true
        })
    );
}

module.exports = config;