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


class FoldManager
  constructor: () ->
    @folds = []

  setContainer: (@container) ->

  fold: ($modalContainer) ->
    $modalContainer.modal('hide')
    $dialog = $modal.find('.modal-dialog')
    $dialog.hide()
    # find the modal dialog element and move into the container
    f = {
      dialog: $dialog
    }
    @folds.push(f)

fm = new FoldManager

window.Modal = {}

# Fetch modal content via ajax
window.Modal.ajax = (url, args, opts) ->

window.Modal.createContainer = () ->
  modal = document.createElement("div")
  modal.classList.add("modal")
  return modal

window.Modal.createDialog = ($container, opts) ->
  dialog = document.createElement("div")
  dialog.classList.add("modal-dialog")

  content = document.createElement("div")
  content.classList.add("modal-content")

  header = document.createElement("div")
  header.classList.add("modal-header")

  headerControls = document.createElement("div")
  headerControls.classList.add("modal-header-controls")
  header.appendChild(headerControls)

  if 1 or opts.foldable
    foldBtn = $("<button/>").attr("type", "button").addClass("fold-btn")
    foldBtn.append( $("<span/>").addClass("fa fa-minus-square") )
    foldBtn.append( $("<span/>").addClass("sr-only").text('Fold') )
    foldBtn.appendTo(headerControls)
    foldBtn.click (e) ->
      fm.fold($container)

  closeBtn = $("<button/>").attr("type", "button").addClass("close")
  closeBtn.append( $("<span/>").addClass("fa fa-remove") )
  closeBtn.append( $("<span/>").addClass("sr-only").text('Close') )
  closeBtn.appendTo(headerControls)
  closeBtn.click (e) ->
    $container.modal("hide")

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

  body = document.createElement('div')
  body.classList.add('modal-body')

  footer = document.createElement('div')
  footer.classList.add('modal-footer')

  eventPayload = { modal: $container, body: $(body), header: $(header) }

  # $('#myModal').modal('hide')
  if opts.controls
    for controlOpts in opts.controls
      do (controlOpts) =>
        $btn = $('<button/>').text(controlOpts.label).addClass('btn')
        $btn.addClass('btn-primary') if controlOpts.primary
        $btn.click((e) -> controlOpts.onClick(e, eventPayload) ) if controlOpts.onClick
        if controlOpts.close
          $btn.click (e) ->
            $container.modal('hide')
            controlOpts.onClose(e, eventPayload) if controlOpts.onClose

        $btn.appendTo(footer)

  content.appendChild(header)
  content.appendChild(body)
  content.appendChild(footer)
  dialog.appendChild(content)

  if opts.ajax
    alert("opts.ajax.url is not defined.") if not opts.ajax.url
    $(body).asRegion().load opts.ajax.url, opts.ajax.args, () ->
      opts.ajax.onReady(null, eventPayload) if opts.ajax.onReady
  return dialog

window.Modal.create = (opts) ->
  modal = @createContainer()
  dialog = @createDialog($(modal), opts)
  modal.appendChild(dialog)
  document.body.appendChild(modal)

  ###
  $(modal).on 'hidden.bs.modal', (e) ->
    $(modal).remove()
  ###
  return modal


$ ->
  container = Modal.createContainer()
  $(document.body).append(container)
  fm.setContainer(container)

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
  $(testModal).modal('show')
###
