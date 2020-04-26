const webpack = require('webpack');
const path    = require('path');

const extractTextPlugin       = require("extract-text-webpack-plugin");
const htmlWebpackPlugin       = require("html-webpack-plugin");
const optimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const uglifyJsPlugin          = require('uglifyjs-webpack-plugin');

const NODE_ENV = process.env.NODE_ENV || 'dev';

let publicPath = '/assets';
if (NODE_ENV === 'prod') {
    publicPath = '/bundles/hs/themes/istra/assets';
}

//process.noDeprecation = true;
//process.traceDeprecation = true;

module.exports = {
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

    //watch: (NODE_ENV === 'dev'),
    watchOptions: {
        aggregateTimeout: 100
    },
    
    module: {
        rules: [
            {
                test: /\.(sass|scss)/,
                exclude: /node_modules|\.git/,
                use: extractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        {
                            loader: 'css-loader'
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
                            name: 'img/[name].[ext]',
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
        new extractTextPlugin('css/style.css'),
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
        new webpack.ProvidePlugin({
            $: 'jquery/dist/jquery.min.js',
            jQuery: 'jquery/dist/jquery.min.js',
            "window.jQuery": 'jquery/dist/jquery.min.js'
        })
    ]
};

if (NODE_ENV === 'prod') {
    module.exports.plugins.push(
        new uglifyJsPlugin({
            uglifyOptions: {
                warnings: false,
                compress: {
                    drop_console: true,
                    unsafe: true
                }
            }
        })
    );

    module.exports.plugins.push(
        new optimizeCssAssetsPlugin({
            assetNameRegExp: /\.css$/,
            cssProcessor: require('cssnano'),
            cssProcessorOptions: {
                autoprefixer: false,
                discardComments: {removeAll: true }
            },
            canPrint: true
        })
    );
}