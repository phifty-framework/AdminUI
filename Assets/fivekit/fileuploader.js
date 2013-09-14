// Generated by CoffeeScript 1.6.1
(function() {

  if (!window.FiveKit) {
    window.FiveKit = {};
  }

  window.FiveKit.UploadQueue = (function() {

    function UploadQueue() {}

    return UploadQueue;

  })();

  window.FiveKit.FileUploader = (function() {

    function FileUploader(files, options) {
      var file, rs, self, _fn, _i, _len, _ref,
        _this = this;
      this.files = files;
      this.options = options;
      self = this;
      this.queueEl = this.options.queueEl;
      this.action = this.options.action || "CoreBundle::Action::Html5Upload";
      rs = [];
      _ref = this.files;
      _fn = function(file) {
        var progressItem, xhr;
        if (window.console) {
          console.log("Got dropped file ", file);
        }
        progressItem = new FiveKit.UploadProgressItem(file);
        progressItem.el.appendTo(self.queueEl);
        xhr = new FiveKit.Xhr({
          endpoint: '/bs',
          params: {
            action: self.action,
            __ajax_request: 1
          },
          onReadyStateChange: function(e) {
            if (window.console) {
              console.log('onReadyStateChange', e);
            }
            if (self.options.onReadyStateChange) {
              return self.options.onReadyStateChange.call(this, e);
            }
          },
          onTransferStart: function(e) {
            if (window.console) {
              console.log('onTransferStart', e);
            }
            if (self.options.onTransferStart) {
              return self.options.onTransferStart.call(this, e);
            }
          },
          onTransferProgress: function(e) {
            var position, total;
            if (window.console) {
              console.log('onTransferProgress', e);
            }
            if (self.options.onTransferProgress) {
              self.options.onTransferProgress.call(this, e);
            }
            if (e.lengthComputable) {
              position = e.position || e.loaded;
              total = e.totalSize || e.total;
              if (window.console) {
                console.log('progressing', e, position, total);
              }
              return progressItem.update(position, total);
            }
          },
          onTransferComplete: self.options.onTransferComplete
        });
        return rs.push(xhr.send(file));
      };
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        file = _ref[_i];
        _fn(file);
      }
      if (self.options.onTransferFinished) {
        $.when.apply($, rs).done(self.options.onTransferFinished);
      }
    }

    return FileUploader;

  })();

}).call(this);
