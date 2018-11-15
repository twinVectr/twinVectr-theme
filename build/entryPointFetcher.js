var path = require('path');
var glob = require('glob');
var ROOT = path.resolve(__dirname);

var addEntryPoint = function (obj, filePath ) {
  var name = path.relative(this.basePath, filePath);
  var ext = path.extname(name);
  var chunk = name.substr(0, name.lastIndexOf(ext));
  obj[chunk] = filePath;
  return obj;
}

var truncatePath = function( basePath ) {
  return addEntryPoint.bind({basePath: basePath});
}

var entryPointfetcher = function(basePath, filePattern) {
  var filePath = path.resolve(ROOT, basePath, filePattern);
  var files = glob.sync(filePath);
  return files.reduce(truncatePath(basePath), {});
};

module.exports = entryPointfetcher;
