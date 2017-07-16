/**
 * Created by .
 * User: 744
 * Date: 01.12.15
 * Time: 12:48
 * To change this template use File | Settings | File Templates.
 */
'use strict'; 
var NODE_ENV = process.env.NODE_ENV || 'development';
var webpack = require('webpack');
var path = require('path');
//var filename = path.basename(__filename, 'js');
//var jQuery = require('jquery');
var AssetsPlugin = require('assets-webpack-plugin');
var assetsPluginInstance = new AssetsPlugin({
    filename:'assets.json',
    fullPath:false, 
    includeManifest: true,
    path:path.join(__dirname, 'application', 'views'),
    update:true,
    metadata: {version:123}
});



module.exports = {
    context: __dirname + '/application/media/js/frontend',
    entry: {
        main: "./main"
    },
    output: {
        path: __dirname + "/application/media/js/public",
        filename: "[name]-bundle-[hash].js",
	publicPath: __dirname + '/public/'
 //       library: "[name]"
    },
    resolve: {
	modules: ['node_modules'],
//	unsafeCache: true
    },
    resolveLoader: {
	modules: ['node_modules'],
	mainFields: ['loader','main'],
	extensions: ['.','.js','.json'],
	moduleExtensions: ['-loader']
    },
    devtool: NODE_ENV == 'development' ? 'cheap-inline-module-source-map' : null,
    plugins: [
        new webpack.NoEmitOnErrorsPlugin(),
        new webpack.DefinePlugin({
            NODE_ENV: JSON.stringify(NODE_ENV),
	    LANG: JSON.stringify('ru'),
	    USER: JSON.stringify('testUser')
	}),
	new webpack.optimize.CommonsChunkPlugin({
	    names: ["common"],
	    filename : "[name].js",
//	    minChunks: 2
	    minChunks: Infinity
//	    chunks: ['about','home']
	}),
        new webpack.ProvidePlugin({
//            $: "jquery",
//            jQuery: "jquery"
//	    window.jQuery: "jquery"
        }),	
	assetsPluginInstance,
//	new webpack.EnvironmentPlugin('NODE_ENV','USER')
    ],

    module: {
        loaders:[
	{
            test: /\.js$/,
	    include: __dirname + '/frontend',	    
	    exclude: /(node_modules|bower_components)/,
	    loader: "babel-loader",
	    query: {
		plugins: ['transform-runtime'],
		presets: ['es2015','stage-0']
	    }
        },
	{
	    test: /\.pug$/,
	    loader: ["pug-loader"]
//	    options: {
//		data: {}
//	    }
	}, 
//        {
//                test: /\.hbs$/,
//                loader: "handlebars-loader"
//        },

	{
	    test: /\.css$/,
//	    loader: 'style-loader!css-loader!autoprefixer?browsers=last 2 versions'
	    loader: 'style-loader!css-loader'
	}
	 ,{
	    test: /\.(png|jpg|svg|ttf|eot|woff|woff2|gif)$/,
//	    include: /\/node_modules\//,
//	    loader: 'file-loader?name=[hash].[name].[ext]',
//	    query: {
//		useRelativePath: true//publicPath outputPath
//	    }
//	    loader: 'file-loader?name=[hash].[ext]&publicPath=/learn/webpack/menu/public/'
	    loader: 'file-loader?name=[hash].[ext]'
	}
//	 {
//	    test: /\.(png|jpg|svg|ttf|eot|woff|woff2|gif)$/,
//	    exclude: /\/node_modules\//,
//	    loader: 'file?name=[1].[ext]&regExp=node_modules/(.*)'
//	}
    ]},
//npm i babel-runtime
//    watch: NODE_ENV == 'development',
//    devtool: "#inline-source-map"
//    watchOptions: {
//        aggregateTimeout: 100
//    }
}

if(NODE_ENV == 'production'){
    module.exports.plugins.push(
	new webpack.optimize.UglifyJsPlugin({
	    compress: {
		warnings: false,
		drop_console: true,
		unsafe: true
	    }
	})    
    );
}

//NODE_ENV=production --display-reasons --display-modules -v
//webpack --json --profile > stats.json
//webpack --profile --display-modules

