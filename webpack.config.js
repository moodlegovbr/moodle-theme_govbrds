// webpack.config.js
const path = require('path');

module.exports = {
  entry: './node_modules/@govbr-ds/core/dist/core-init.min.js',
  output: {
    path: path.resolve(__dirname, 'amd/build'),
    filename: 'govbr.js',
    libraryTarget: 'amd'
  },
  mode: 'production'
};