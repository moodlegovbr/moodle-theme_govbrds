const path = require('path');

module.exports = {
  entry: './node_modules/@govbr-ds/core/dist/core-init.min.js',
  output: {
    path: __dirname + './amd/src',
    filename: 'govbr.js',
    libraryTarget: 'amd'
  },
  mode: 'production'
};