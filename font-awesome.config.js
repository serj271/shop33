/**
 * Created by .
 * User: 744
 * Date: 12.12.15
 * Time: 0:46
 * To change this template use File | Settings | File Templates.
 */
module.exports = {
  styleLoader: require('extract-text-webpack-plugin').extract('style-loader', 'css-loader!less-loader'),
  styles: {
    "mixins": true,

    "core": true,
    "icons": true,

    "larger": true,
    "path": true,
  }
};