// Generated by CoffeeScript 1.7.1
(function() {
  if (!window.Phifty) {
    window.Phifty = {};
  }

  Phifty.AdminUI = {

    /*
    
    $imageCover = Phifty.AdminUI.createImageCover { image:..., thumb: ..., title:...  },
      onClose: (e) ->
        runAction 'Product::Action::DeleteProductImage',
          { id: data.id },
          { confirm: '確認刪除? ', remove: this }
     */
    createImageCover: function(opts) {
      var $a, $close, $cut, $image, $imageCover, $title;
      $imageCover = $('<div/>').addClass('image-cover');
      $a = $('<a/>').attr({
        target: '_blank',
        href: '/' + opts.image
      });
      if (opts.thumb) {
        $image = $('<img/>').attr({
          src: '/' + opts.thumb
        }).appendTo($a);
      }
      $cut = $('<div/>').addClass('cut').append($a).appendTo($imageCover);
      $title = $('<div/>').addClass('title').html(opts.title || '未命名').appendTo($imageCover);
      if (opts.onClose) {
        $close = $('<div/>').addClass('close').click(function() {
          return opts.onClose.call($imageCover);
        });
        $close.appendTo($imageCover);
      }
      if ($a.facebox) {
        $a.facebox({
          closeImage: '/assets/facebox/src/closelabel.png',
          loadingImage: '/assets/facebox/src/loading.gif'
        });
      }
      return $imageCover;
    },
    createTextCover: function(data, options) {
      var $close, $name, $tag;
      $tag = $('<div/>').addClass('text-tag');
      $name = $('<div/>').addClass('name').html(data.name).appendTo($tag);
      if (options.onClose) {
        $close = $('<div/>').addClass('close').click(options.onClose);
        $close.appendTo($tag);
      }
      return $tag;
    },
    createResourceCover: function(data, opts) {
      var $a, $close, $preview, $tag, e;
      $tag = $('<div/>').addClass('resource');
      $preview = $('<div/>').appendTo($tag);
      if (data.url) {
        try {
          $preview.oembed(data.url, {
            maxHeight: 300,
            maxWidth: 300
          });
        } catch (_error) {
          e = _error;
          if (window.console) {
            console.error(e);
          }
          $a = $('<a/>').attr({
            target: '_blank',
            href: data.url
          });
          $a.html(data.url);
          $preview.html($a);
        }
      } else if (data.html) {
        $preview.html(data.html);
      }
      if (opts.onClose) {
        $close = $('<div/>').addClass('close');
        $close.click(function(e) {
          return opts.onClose.call($tag, e);
        });
        $close.appendTo($tag);
      }
      return $tag;
    },
    createFileCover: function(data) {
      var $icon, $name, $tag;
      $tag = $('<div/>').addClass('product-file');
      $name = $('<a/>').addClass('name').attr({
        target: '_blank',
        href: '/' + data.file
      }).html(data.title || data.file.split('/').pop());
      $icon = $('<div/>');
      if (data.mimetype === 'application/pdf' || data.mimetype === 'application/msword' || data.mimetype === 'text/plain' || data.mimetype === 'text/html') {
        $icon.addClass('ui-' + data.mimetype.replace('/', '-') + '-32');
      } else {
        $icon.addClass('ui-unknown-32');
      }
      $icon.appendTo($tag);
      $tag.append($name);
      return $tag;
    }
  };

  if (!Phifty.News) {
    Phifty.News = {};
  }

  Phifty.News.createImageCover = function(data) {
    var $id, $imageCover;
    $imageCover = Phifty.AdminUI.createImageCover({
      image: data.image,
      thumb: data.thumb,
      title: data.title,
      onClose: function(e) {
        return runAction('News::Action::DeleteNewsImage', {
          id: data.id
        }, {
          confirm: '確認刪除? ',
          remove: this
        });
      }
    });
    $id = $('<input/>').attr({
      type: 'hidden',
      name: 'images[' + data.id + '][id]',
      value: data.id
    }).appendTo($imageCover);
    return $imageCover;
  };

  Phifty.News.createResourceCover = function(data) {
    var $id, $tag;
    $tag = Phifty.AdminUI.createResourceCover(data, {
      onClose: function(e) {
        return runAction('News::Action::DeleteResource', {
          id: data.id
        }, {
          confirm: '確認刪除? ',
          remove: this
        });
      }
    });
    $id = $('<input/>').attr({
      type: 'hidden',
      name: 'resources[' + data.id + '][id]',
      value: data.id
    }).appendTo($tag);
    return $tag;
  };

  $(function() {
    var adjust_menu;
    adjust_menu = function() {
      var operation_height, win_height;
      win_height = $(document).height();
      operation_height = $('#operation').height();
      return $('.admin-menu').height(win_height - operation_height - 2);
    };
    $('.admin-menu a').click(function(e) {
      return $('.admin-menu').removeClass('show');
    });
    return $('.admin-menu-button').click(function(e) {
      $('.admin-menu').toggleClass('show');
      return false;
    });
  });

}).call(this);