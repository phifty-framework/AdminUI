###
This is a basic wrapper library around bootstrap-modal javascript.

The use case is inside DMenu:

    sectionModal = Modal.create({
      title: if params.id then 'Edit Menu Section' else 'Create Menu Section'
      ajax: {
        url: '/dmenu/menu_section_form'
        args: params
        onReady: (e, ui) ->
          form = ui.body.find("form").get(0)
          Action.form form,
            status: true
            clear: true
            onSuccess: (data) ->
              ui.modal.modal('hide')
              setTimeout (->
                self.refresh()
                ui.modal.remove()
              ), 800
              options.onSave() if options and options.onSave
      }
      controls: [
        {
          label: 'Save'
          onClick: (e,ui) ->
            ui.body.find("form").submit()
        }
      ]
    })
    $(sectionModal).modal('show')

And the actual HTML structure:

<div class="modal in">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>

###
class Modal
  constructor: (@el) ->

jQuery.fn.foldableModal = (options) ->
  if options is "show"
    this.removeClass('sink')
  else if options is "hide"
    this.addClass('sink')
  else if options is "close"
    this.remove()
  else
    this.show()

window.ModalManager = {}

ModalManager.init = () ->
  @container = document.createElement('div')
  @container.classList.add("modal-container")
  document.body.appendChild(@container)

  @folds = $('<div/>').addClass("fold-container")
  $(document.body).append(@folds)

# Fetch modal content via ajax
ModalManager.ajax = (url, args, opts) ->

ModalManager.createContainer = () ->
  modal = document.createElement("div")
  modal.classList.add("modal")
  return modal

ModalManager.fold = (ui) ->
  ui.dialog.foldableModal('hide')
  ui.dialog.css('transform', '')
  ui.dialog.css('webkitTransform', '')
  ui.dialog.css('zIndex', '')

  # Build fold element
  if not ui.fold
    $fold = $('<div/>').addClass("fold")
    $fold.data('modal-ui', ui)

    title = ui.options?.title or "Untitled"

    $title = $('<div/>').addClass("fold-title").html(title).attr('title', title)
    $controls = $('<div/>').addClass("fold-controls")
    $fold.append($title)
    $fold.append($controls)

    # $awakeBtn = $('<button/>').append( $('<i/>').addClass('fa fa-plus-square'))
    # $awakeBtn.appendTo($controls)
    $fold.on "click", (e) -> ModalManager.awake(ui)

    $removeBtn = $('<button/>').append( $('<i/>').addClass('fa fa-remove'))
    $removeBtn.appendTo($controls)
    $removeBtn.on "click", (e) ->
      e.stopPropagation()
      ModalManager.close(ui)
    ui.dialog.data('fold', $fold)

    # register fold to "ui"
    ui.fold = $fold
    @folds.append($fold)
  else
    $fold = ui.fold

  @updateLayout()
  setTimeout (-> $fold.addClass("floated")), 500

ModalManager.awake = (ui) ->
  ui.fold.removeClass("floated") if ui.fold

  ui.dialog.css({
    zIndex: 99
    transform: ""
    webkitTransform: ""
  })

  # Move the modal to the last element
  @container.appendChild(ui.dialog[0])

  setTimeout (=>
    # Remove sink class name to show up the dialog
    ui.dialog.foldableModal('show')

    # Update the layout
    @updateLayout()
    # setTimeout (=> @updateLayout()), 1000
  ), 100

ModalManager.focus = (dialog) ->
  # Move the offset to the the left side
  dialog.css({
    zIndex: 99
    transform: "translateX(0)"
    webkitTransform: "translateX(0)"
  })

  # The transition end require IE10
  dialog.one 'transitionend webkitTransitionEnd oTransitionEnd',  =>
    @container.appendChild(dialog[0])
    @updateLayout()

  ###
  The time frame was set to 1 second
  setTimeout (=>
    # Move the modal element to the end of the list.
    @container.appendChild(dialog[0])

    # Update the layout based on the element order
    @updateLayout()
  ), 1500
  ###

ModalManager.close = (ui) ->
  ui.dialog.foldableModal('close')
  ui.fold.remove() if ui.fold
  @updateLayout()

ModalManager.updateLayout = () ->
  self = this

  visibleModals = $(@container).find(".modal-dialog").filter (i,el) =>
    return not $(el).hasClass("sink")

  # console.log("ModalManager:updateLayout", visibleModals)

  # Clear the hover event handler
  visibleModals.unbind('mouseenter mouseleave click')

  zIndex = visibleModals.size()
  offset = 30
  shiftingOffset = 90
  index = 0
  for modal in visibleModals.toArray().reverse()
    do (modal, offset, index, zIndex) =>
      console.log("Setting modal ", { zindex: zIndex, index: index, modal: modal })

      $(modal).removeAttr('style')

      $(modal).css({
        zIndex: zIndex
        transform: "translateX(#{ - offset * index }px)"
        webkitTransform: "translateX(#{ - offset * index }px)"
      })
      if index > 0
        $(modal).click ->
          # focus will change the DOM structure, thus we need to remove the event listeners
          visibleModals.unbind('mouseenter mouseleave click')
          self.focus($(modal))
        $(modal).hover (-> $(modal).css({
          transform: "translateX(#{ - offset * index - shiftingOffset }px)"
          webkitTransform: "translateX(#{ - offset * index - shiftingOffset }px)"
        })), (-> $(modal).css({
          transform: "translateX(#{ - offset * index }px)"
          webkitTransform: "translateX(#{ - offset * index }px)"
        }))
      else
        $(modal).unbind('hover')
        $(modal).unbind('click')
    index++
    zIndex--

ModalManager.createDialog = (opts) ->
  dialog = document.createElement("div")
  dialog.classList.add("modal-dialog")

  content = document.createElement("div")
  content.classList.add("modal-content")

  header = document.createElement("div")
  header.classList.add("modal-header")

  headerControls = document.createElement("div")
  headerControls.classList.add("modal-header-controls")
  header.appendChild(headerControls)

  modalbody = document.createElement('div')
  modalbody.classList.add('modal-body')

  footer = document.createElement('div')
  footer.classList.add('modal-footer')

  content.appendChild(header)
  content.appendChild(modalbody)
  content.appendChild(footer)
  dialog.appendChild(content)

  ui = { dialog: $(dialog), body: $(modalbody), header: $(header), options: opts }
  if opts.foldable
    foldBtn = $("<button/>").attr("type", "button").addClass("fold-btn")
    foldBtn.append( $("<span/>").addClass("fa fa-minus") )
    foldBtn.append( $("<span/>").addClass("sr-only").text('Fold') )
    foldBtn.appendTo(headerControls)
    foldBtn.click (e) ->
      $(dialog).trigger('dialog.fold', [ui])

  closeBtn = $("<button/>").attr("type", "button").addClass("close")
  closeBtn.append( $("<span/>").addClass("fa fa-remove") )
  closeBtn.append( $("<span/>").addClass("sr-only").text('Close') )
  closeBtn.appendTo(headerControls)
  closeBtn.click (e) ->
    $(dialog).trigger('dialog.close',[ui])

  if opts?.side
    dialog.classList.add("side-modal")

  if opts?.size
    if opts.size is "large"
      dialog.classList.add("modal-lg")
    else if opts.size is "small"
      dialog.classList.add("modal-sm")
    else if opts.size is "medium"
      dialog.classList.add("modal-md")

  # <h4 class="modal-title">Modal title</h4>
  if opts.title
    $('<h4/>').text(opts.title).addClass('modal-title').appendTo(header)


  if opts.controls
    for controlOpts in opts.controls
      do (controlOpts) =>
        $btn = $('<button/>').text(controlOpts.label).addClass('btn')
        $btn.addClass('btn-primary') if controlOpts.primary
        $btn.click((e) -> controlOpts.onClick(e, ui) ) if controlOpts.onClick
        if controlOpts.close
          $btn.click (e) ->
            $(dialog).trigger('dialog.close',[ui])
        $btn.appendTo(footer)

  if opts.ajax
    alert("opts.ajax.url is not defined.") if not opts.ajax.url
    $(modalbody).asRegion().load opts.ajax.url, opts.ajax.args, () ->
      $(dialog).trigger('dialog.ajax.done', [ui])
      # opts.ajax.onReady(null, ui) if opts.ajax.onReady
  return ui

# Create a foldable modal
ModalManager.create = (opts) ->
  opts.foldable = 1
  ui = @createDialog(opts)
  # Append the dialog element to .modal-container
  $(@container).append(ui.dialog)

  ui.dialog.on "dialog.close", (e, ui) -> ModalManager.close(ui)
  ui.dialog.on "dialog.fold", (e, ui) -> ModalManager.fold(ui)

  ui.container = $(@container)

  if not opts.side
    $(dialog).css({
      position: 'fixed'
      left: ($(window).width() - $(dialog).width()) / 2
      top: '10%'
    })
  return ui


# Create a blocking and isolated modal.
ModalManager.createBlock = (opts) ->
  $isolatedContainer = $(document.createElement('div'))
  $isolatedContainer.addClass("modal")
  $(document.body).append($isolatedContainer)
  ui = @createDialog(opts)

  $isolatedContainer.append(ui.dialog)

  # Connecting ui.dialog to bootstrap modal event
  ui.dialog.on "hidden.bs.modal", (e, ui) ->
    $isolatedContainer.remove()

  ui.dialog.on "dialog.close", (e, ui) ->
    $isolatedContainer.modal('hide')
  ui.container = $isolatedContainer
  return ui

$ ->
  ModalManager.init()

###
Modal test code

$ ->
  testModal = Modal.create {
    title: 'Test Modal'
    controls: [
      { label: 'Test', primary: true, onClick: (e, ui) -> console.log(e, ui) }
      { label: 'Close', primary: true, close: true, onClose: (e, ui) -> console.log(e, ui) }
    ]
  }
  $(testModal).foldableModal('show')
###
