window.$h = {
  getProvider: function (file) {
    return require('./providers/' + file).default;
  },
  getConstant: function (file) {
    return require('./constants/' + file).default;
  }
}