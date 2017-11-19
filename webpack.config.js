const webpack = require('webpack');
const path    = require('path');

const ExtractTextPlugin       = require("extract-text-webpack-plugin");
const HtmlWebpackPlugin       = require("html-webpack-plugin");
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');

const publicPath = '/HotSpot_template/assets';
//const publicPath = '/themes/new/assets';

const NODE_ENV = process.env.NODE_ENV || 'dev';

process.noDeprecation = true;
//process.traceDeprecation = true;

module.exports = {
    context: __dirname + '/frontend',
    entry: [
        './app.js',
        './scss/main.scss'
    ],
    output: {
        path: path.resolve(__dirname, 'public/assets'),
        publicPath: publicPath + '/',
        filename: 'js/[name].js'
    },

    //watch: (NODE_ENV === 'dev'),
    watchOptions: {
        aggregateTimeout: 100
    },
    
    module: {
        rules: [
            {
                test: /\.(sass|scss)/,
                exclude: /node_modules|\.git/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        {
                            loader: 'css-loader'
                        }, {
                            loader: 'autoprefixer-loader',
                            options: {
                                browsers: ['ie > 8', 'ff >= 15', 'Safari > 3', 'Android >=4', 'Chrome > 10', 'Last 4 versions']
                            }
                        }, {
                            loader: 'resolve-url-loader'
                        }, {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true
                                /*includePaths: [
                                    path.resolve(__dirname, "frontend/scss/page/")
                                ]*/
                            }
                        }
                    ]
                })            
            }, {
                test: /\.(png|jpg|gif|ico)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '/img/[name].[ext]',
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
                            name: '/fonts/[name].[ext]',
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
        new webpack.NoEmitOnErrorsPlugin(),
        new ExtractTextPlugin('css/style.css'),
        new HtmlWebpackPlugin({
            filename: __dirname + '/public/index.php',
            title: 'Главная страница',
            template: __dirname + '/frontend/index.php',
            favicon: __dirname + '/frontend/favicon.ico'
        }),
        new HtmlWebpackPlugin({
            filename: __dirname + '/public/faq.php',
            title: 'FAQ',
            template: __dirname + '/frontend/faq.php',
            inject: false
        }),
        new HtmlWebpackPlugin({
            filename: __dirname + '/public/phone.html',
            title: 'phone',
            template: __dirname + '/frontend/phone.html',
            inject: false
        }),
        new webpack.ProvidePlugin({
            $: 'jquery/dist/jquery.min.js',
            jQuery: 'jquery/dist/jquery.min.js',
            "window.jQuery": 'jquery/dist/jquery.min.js'
        })
    ]
};

if(NODE_ENV=='prod') {
    module.exports.plugins.push(
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false,
                drop_console: true,
                unsafe: true
            }
        })
    );

    module.exports.plugins.push(
        new OptimizeCssAssetsPlugin({
            assetNameRegExp: /\.css$/,
            cssProcessor: require('cssnano'),
            cssProcessorOptions: {
                autoprefixer:false,
                discardComments: {removeAll: true }
            },
            canPrint: true
        })
    );
}