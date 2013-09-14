// Generated by CoffeeScript 1.6.1

/* 
  builder = new MimeBuilder({ 
    file: [file object], 
    onBuilt: (b) -> 
      b.boundary
      b.body
  })
*/


(function() {

  window.FiveKit.MimeBuilder = (function() {

    function MimeBuilder() {}

    MimeBuilder.prototype.build = function(options) {
      var file;
      this.options = options;
      options = this.options;
      file = this.options.file;
      this.reader = new FiveKit.FileReader({
        onLoaded: function(e) {
          var binary, body, boundary, reader;
          reader = e.srcElement;
          binary = reader.result;
          boundary = options.boundary || 'xxxxxxxxx';
          body = '--' + boundary + "\r\n";
          body += "Content-Disposition: form-data; name='upload'; ";
          if (file.name) {
            body += "filename='" + file.name + "'\r\n";
          }
          body += "Content-Type: application/octet-stream\r\n\r\n";
          body += binary + "\r\n";
          body += '--' + boundary + '--';
          if (options.onBuilt) {
            return options.onBuilt({
              file: file,
              body: body,
              boundary: boundary
            });
          }
        }
      });
      return this.reader.readAsBinaryString(file);
    };

    return MimeBuilder;

  })();

}).call(this);
