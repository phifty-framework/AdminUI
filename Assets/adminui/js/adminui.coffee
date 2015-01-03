
window.Phifty = {} unless window.Phifty

window.AdminUI =
  ###

  $imageCover = AdminUI.createImageCover { image:..., thumb: ..., title:...  },
    onClose: (e) ->
      runAction 'Product::Action::DeleteProductImage',
        { id: data.id },
        { confirm: '確認刪除? ', remove: this }

  ###
  createImageCover: (opts) ->
    # insert image id into product field
    $imageCover = $('<div/>').addClass('image-cover')
    $a = $('<a/>').attr( target: '_blank', href: '/' + opts.image )

    $image = $('<img/>').attr( src: '/' + opts.thumb ).appendTo($a) if opts.thumb

    $cut = $('<div/>').addClass('cut').append($a).appendTo($imageCover)
    $title = $('<div/>').addClass('title').html( opts.title || '未命名' ).appendTo($imageCover)
    if opts.onClose
      $close = $('<div/>').addClass('close').click -> opts.onClose.call($imageCover)
      $close.appendTo($imageCover)
    if $a.facebox
      $a.facebox({
          closeImage: '/assets/facebox/src/closelabel.png',
          loadingImage: '/assets/facebox/src/loading.gif'
      })
    return $imageCover

  createTag: (settings) ->
    $tag = $('<div/>').addClass('tag')
    $name = $('<div/>').addClass('label').html(settings.label).appendTo($tag)
    if settings.onRemove
      $('<i/>').addClass('control fa fa-remove').click(settings.onRemove).appendTo($tag)
    return $tag

  createTextTag: (data,options) ->
    $tag = $('<div/>').addClass( 'text-tag' )
    $name = $('<div/>').addClass( 'name' ).html( data.title or data.name ).appendTo($tag)
    if options.onClose
      $close = $('<i/>').addClass('fa fa-remove').click(options.onClose)
      $close.appendTo($tag)
    return $tag

  createResourceCover: (data,opts) ->
    $tag = $('<div/>').addClass( 'resource' )
    $preview = $('<div/>').appendTo($tag)
    if data.url
      try
        $preview.oembed(data.url , { maxHeight: 300, maxWidth: 300 })
      catch e
        console.error(e) if window.console
        $a = $('<a/>').attr target: '_blank', href: data.url
        $a.html(data.url)
        $preview.html($a)
    else if data.html
      $preview.html(data.html)
    if opts.onClose
      $close = $('<div/>').addClass('close')
      $close.click (e) -> opts.onClose.call($tag,e)
      $close.appendTo($tag)
    return $tag

  createFileCover: (data) ->
    $tag = $('<div/>').addClass( 'product-file' )
    $name = $('<a/>').addClass('name')
      .attr({ target: '_blank', href: '/' + data.file })
      .html( data.title or data.file.split('/').pop() )
    $icon = $('<div/>')

    if data.mimetype is 'application/pdf' or
    data.mimetype is 'application/msword' or
    data.mimetype is 'text/plain' or
    data.mimetype is 'text/html'
        $icon.addClass('ui-' + data.mimetype.replace('/','-') + '-32')
    else
        $icon.addClass('ui-unknown-32')
    $icon.appendTo($tag)
    $tag.append($name)
    return $tag

Phifty.News = {} unless Phifty.News

# XXX: refactor this to news asset later.
Phifty.News.createImageCover = (data) ->
  $imageCover = AdminUI.createImageCover
    image: data.image,
    thumb: data.thumb,
    title: data.title,
    onClose: (e) ->
      runAction 'News::Action::DeleteNewsImage',
        { id: data.id },
        { confirm: '確認刪除? ', remove: this }

  # hidden id field for subaction
  $id = $('<input/>').attr({
      type: 'hidden',
      name: 'images[' + data.id + '][id]',
      value: data.id
  }).appendTo($imageCover)
  return $imageCover

Phifty.News.createResourceCover = (data) ->
  $tag = AdminUI.createResourceCover data,
    onClose: (e) ->
      runAction('News::Action::DeleteResource',
          { id: data.id },
          { confirm: '確認刪除? ', remove: this })

  $id = $('<input/>').attr({
      type: 'hidden',
      name: 'resources[' + data.id + '][id]',
      value: data.id
  }).appendTo($tag)
  return $tag

# script for updating admin-menu height
$ ->
  adjust_menu = () ->
    win_height = $(document).height()
    operation_height = $('#operation').height()
    $('.admin-menu').height( win_height - operation_height - 2 )

  $('.admin-menu a').click (e) ->
    $('.admin-menu').removeClass('show')

  $('.admin-menu-button').click (e) ->
    $('.admin-menu').toggleClass('show')
    return false

  # if /mobile|iOS|iPad/i.test(navigator.userAgent)
  #  setTimeout( -> window.scrollTo(0, 1), 1000)

    # adjust_menu()
  # $(window).resize -> adjust_menu()
