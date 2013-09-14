// Generated by CoffeeScript 1.6.1
(function() {

  if (!window.FiveKit) {
    window.FiveKit = {};
  }

  window.FiveKit.UploadProgressItem = (function() {

    function UploadProgressItem(file) {
      this.file = file;
      this._total = 0;
      this._loaded = 0;
      this.el = $('<div/>').addClass('progress');
      this.progress = $('<progress/>');
      if (!this.progress) {
        throw "progress element is not supported.";
      }
      this.progress.attr({
        value: this._loaded,
        max: this._total
      }).appendTo(this.el);
      this.percentage = $('<span/>').addClass('percentage').text(this.file.size).appendTo(this.el);
      this.filesize = $('<span/>').addClass('filesize').text(this.prettySize(this.file.size)).appendTo(this.el);
      this.filename = $('<span/>').addClass('filename').text(this.file.name).appendTo(this.el);
    }

    UploadProgressItem.prototype.calculatePercentage = function(loaded, total) {
      return parseInt((loaded / total) * 100);
    };

    UploadProgressItem.prototype.prettySize = function(bytes) {
      if (bytes < 1024) {
        return bytes + 'B';
      }
      if (bytes < 1024 * 1024) {
        return parseInt(bytes / 1024) + 'KB';
      }
      if (bytes < (1024 * 1024 * 1024)) {
        return parseInt(bytes / 1024 / 1024) + 'MB';
      }
    };

    UploadProgressItem.prototype.total = function(_total) {
      this._total = _total;
      return this.progress.attr('max', this._total);
    };

    UploadProgressItem.prototype.loaded = function(_loaded) {
      this._loaded = _loaded;
      return this.progress.attr('value', this._loaded);
    };

    UploadProgressItem.prototype.updatePercentage = function(loaded, total) {
      var p;
      p = this.calculatePercentage(loaded, total);
      return this.percentage.text(p + '%');
    };

    UploadProgressItem.prototype.update = function(loaded, total) {
      this.loaded(loaded);
      this.total(total);
      return this.updatePercentage(loaded, total);
    };

    return UploadProgressItem;

  })();

}).call(this);
