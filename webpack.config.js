'use strict';
var NODE_ENV = process.env.NODE_ENV || 'development';
var webpack = require('webpack');
//var jQuery = require('jquery');
var ExtractTextPlugin = require("extract-text-webpack-plugin");
var AssetsPlugin = require('assets-webpack-plugin');
//var HtmlWebpackPlugin = require('html-webpack-plugin');
var rimraf = require('rimraf');
var path = require('path');

function addHash(template, hash){
    return NODE_ENV == 'production' ?
	template.replace(/\.[^.]+$/,'.['+hash+']$&') : template;
}

module.exports = {
    context: __dirname + '/js/frontend',
    entry: {
//		personal: "./personal",
		intersearch: "./intersearch"
//		styles: './personal/styles.styl'
//		main: ["./main"]
	},

    output: {
        path: __dirname +'/js/public',
		publicPath: '/personal/js/public/',
		filename: addHash("[name].js","chunkhash")

    },
	externals:{
//	    'react':'React'
//        lodash: "_"

    },
	resolve: {
		modulesDirectories: ['node_modules'],
		extensions: ['','.js','.styl','.css','.jsx'],
		root: 'usr/home/serj/node'
	},
	resolveLoader: {
		modulesDirectories: ['node_modules'],
		moduleTemplates: ['*-loader','*'],
		extensions: ['','.js']
	},

	devtool: NODE_ENV == 'development' ? 'cheap-inline-module-source-map' : null,
	module: {
		loaders: [
			{
				test: /\.js$/,
				include: '/usr/local/www/personal' + '/frontend',
//	    exclude: /(node_modules|bower_components)/,
				loaders:  ['react-hot', 'babel-loader?presets[]=es2015&presets[]=react&presets[]=stage-0']
//				loader: "babel-loader",
//				query: {
//					plugins: ['transform-runtime'],
//					presets: ['es2015','stage-0']
//				}
			},
			{
			test: /\.jsx$/,
//			loader: 'jsx-loader?insertPragma=React.DOM&harmony'
//			loader: 'babel?cacheDirectory,presets[]=react'
			loaders:  ['react-hot', 'babel-loader?presets[]=es2015&presets[]=react&presets[]=stage-0'],//react-hmre
			exclude: /(node_modules|bower_components)/
//			loader: 'babel-loader',
//			query: {
//					presets: ['react', 'es2015', "stage-0"],
//					plugins: ['transform-runtime']
//			}				
		},
			{
				test: /\.styl$/,
				loader: 'style-loader!css-loader!stylus-loader'
//	    		loader: ExtractTextPlugin.extract('css!stylus?resolve url&lineos')
			},
			{
				test: /\.css$/,
				loader: 'style-loader!css-loader!autoprefixer?browsers=last 2 versions'
			},

			{ test: /\.woff(\?v=\d+\.\d+\.\d+)?$/,   loader: "url?limit=10000&minetype=application/font-woff" },
			{ test: /\.ttf(\?v=\d+\.\d+\.\d+)?$/,    loader: "url?limit=10000&minetype=application/octet-stream" },
			{ test: /\.eot(\?v=\d+\.\d+\.\d+)?$/,    loader: "file" },
			{ test: /\.svg(\?v=\d+\.\d+\.\d+)?$/,    loader: "url?limit=10000&minetype=image/svg+xml" },
			{
				test: /\.(png|jpg|svg|ttf|eot|woff|woff2|gif)$/,
//	    include: /\/node_modules\//,
				loader: 'file?name=[path][name].[ext]'
//	    loader: 'file'
			}
		]
	},
	plugins: [
		new webpack.NoErrorsPlugin(),
		new webpack.DefinePlugin({
			NODE_ENV: JSON.stringify(NODE_ENV),
			LANG: JSON.stringify('ru'),
			USER: JSON.stringify('testUser')
		}),
/*		new webpack.optimize.CommonsChunkPlugin({
			name: "main",
	    	minChunks: 2,
	    	minChunk: Infinity,
			chunks: ['personal']
		}),
*/
		new AssetsPlugin({
//	    path: __dirname,
			update: true,
			filename:'assets.json',
			path: __dirname + '/js/public/assets'

		}),
		new ExtractTextPlugin('[name].css',{allChanks:true}),
		new webpack.ProvidePlugin({
        	    $: "jquery",
        	    jQuery: "jquery"
    		})	
	],
	noParse: [
		wrapRegexp(/\/node_modules\/(angular\/angular|jquery)/,'noParse')
//        /knockout\/build\/output\/knockout-latest\.debug\.js/
	]


//npm i babel-runtime
//    watch: NODE_ENV == 'development',
//    devtool: NODE_ENV == "development" ? "cheap-module-source-map" : null
//    watchOptions: {
//        aggregateTimeout: 100
//    }
}

function apply(options, compiler){
	rimraf.sync(compiler.options.output.path);	    
}


function wrapRegexp(regexp, label){
    regexp.test = function(path){
	console.log(label, path);
	return RegExp.prototype.test.call(this, path);
    };
    return regexp;
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