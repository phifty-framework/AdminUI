// Generated by CoffeeScript 1.9.3

/*
This is a basic wrapper library around bootstrap-modal javascript.

The use case is inside DMenu:

    sectionModal = ModalManager.create({
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
 */

(function() {
  var Modal;

  Modal = (function() {
    function Modal(el1) {
      this.el = el1;
    }

    return Modal;

  })();

  jQuery.fn.foldableModal = function(options) {
    if (options === "show") {
      return this.removeClass('sink');
    } else if (options === "hide") {
      return this.addClass('sink');
    } else if (options === "close") {
      return this.remove();
    } else {
      return this.show();
    }
  };

  window.ModalManager = {};


  /*
  
  init method creates the modal container
   */

  ModalManager.init = function() {
    this.container = document.createElement('div');
    this.container.classList.add("modal-container");
    document.body.appendChild(this.container);
    this.folds = $('<div/>').addClass("fold-container");
    return $(document.body).append(this.folds);
  };

  ModalManager.fold = function(ui) {
    var $controls, $fold, $removeBtn, $title, ref, title;
    ui.dialog.foldableModal('hide');
    ui.dialog.css('transform', '');
    ui.dialog.css('webkitTransform', '');
    ui.dialog.css('zIndex', '');
    if (!ui.fold) {
      $fold = $('<div/>').addClass("fold");
      $fold.data('modal-ui', ui);
      title = ((ref = ui.options) != null ? ref.title : void 0) || "Untitled";
      $title = $('<div/>').addClass("fold-title").html(title).attr('title', title);
      $controls = $('<div/>').addClass("fold-controls");
      $fold.append($title);
      $fold.append($controls);
      $fold.on("click", function(e) {
        return ModalManager.awake(ui);
      });
      $removeBtn = $('<button/>').append($('<i/>').addClass('fa fa-remove'));
      $removeBtn.appendTo($controls);
      $removeBtn.on("click", function(e) {
        e.stopPropagation();
        return ModalManager.close(ui);
      });
      ui.dialog.data('fold', $fold);
      ui.fold = $fold;
      this.folds.append($fold);
    } else {
      $fold = ui.fold;
    }
    this.updateLayout();
    return setTimeout((function() {
      return $fold.addClass("floated");
    }), 500);
  };

  ModalManager.awake = function(ui) {
    if (ui.fold) {
      ui.fold.removeClass("floated");
    }
    ui.dialog.css({
      zIndex: 99,
      transform: "",
      webkitTransform: ""
    });
    this.container.appendChild(ui.dialog[0]);
    return setTimeout(((function(_this) {
      return function() {
        ui.dialog.foldableModal('show');
        return _this.updateLayout();
      };
    })(this)), 100);
  };

  ModalManager.focus = function(dialog) {
    dialog.css({
      zIndex: 99,
      transform: "translateX(0)",
      webkitTransform: "translateX(0)"
    });
    return dialog.one('transitionend webkitTransitionEnd oTransitionEnd', (function(_this) {
      return function() {
        _this.container.appendChild(dialog[0]);
        return _this.updateLayout();
      };
    })(this));

    /*
    The time frame was set to 1 second
    setTimeout (=>
       * Move the modal element to the end of the list.
      @container.appendChild(dialog[0])
    
       * Update the layout based on the element order
      @updateLayout()
    ), 1500
     */
  };

  ModalManager.close = function(ui) {
    if (ui.fold) {
      ui.fold.remove();
    }
    if (ui.dialog) {
      ui.dialog.remove();
    }
    return this.updateLayout();
  };

  ModalManager.updateLayout = function() {
    var fn, index, j, len, modal, offset, ref, results, self, shiftingOffset, visibleModals, zIndex;
    self = this;
    visibleModals = $(this.container).find(".modal-dialog").filter((function(_this) {
      return function(i, el) {
        return !$(el).hasClass("sink");
      };
    })(this));
    if (!(visibleModals && visibleModals.length > 0)) {
      return;
    }
    visibleModals.unbind('mouseenter mouseleave click');
    zIndex = visibleModals.size();
    offset = 30;
    shiftingOffset = 90;
    index = 0;
    ref = visibleModals.toArray().reverse();
    fn = (function(_this) {
      return function(modal, offset, index, zIndex) {
        console.log("Setting modal ", {
          zindex: zIndex,
          index: index,
          modal: modal
        });
        $(modal).removeAttr('style');
        $(modal).css({
          zIndex: zIndex,
          transform: "translateX(" + (-offset * index) + "px)",
          webkitTransform: "translateX(" + (-offset * index) + "px)"
        });
        if (index > 0) {
          $(modal).click(function() {
            visibleModals.unbind('mouseenter mouseleave click');
            return self.focus($(modal));
          });
          return $(modal).hover((function() {
            return $(modal).css({
              transform: "translateX(" + (-offset * index - shiftingOffset) + "px)",
              webkitTransform: "translateX(" + (-offset * index - shiftingOffset) + "px)"
            });
          }), (function() {
            return $(modal).css({
              transform: "translateX(" + (-offset * index) + "px)",
              webkitTransform: "translateX(" + (-offset * index) + "px)"
            });
          }));
        } else {
          $(modal).unbind('hover');
          return $(modal).unbind('click');
        }
      };
    })(this);
    results = [];
    for (j = 0, len = ref.length; j < len; j++) {
      modal = ref[j];
      fn(modal, offset, index, zIndex);
      index++;
      results.push(zIndex--);
    }
    return results;
  };


  /*
  
  The 'create' method creates a foldable modal and it handles the modal close, fold events
   */

  ModalManager.create = function(opts) {
    var ui;
    ui = ModalFactory.create(opts);
    $(this.container).append(ui.dialog);
    ui.dialog.on("dialog.close", function(e, ui) {
      return ModalManager.close(ui);
    });
    if (opts.foldable) {
      ui.dialog.on("dialog.fold", function(e, ui) {
        return ModalManager.fold(ui);
      });
    }
    ui.container = $(this.container);
    if (!opts.side) {
      $(ui.dialog).css({
        position: 'fixed',
        left: ($(window).width() - $(ui.dialog).width()) / 2,
        top: '10%'
      });
    }
    return ui;
  };

  ModalManager.createBlock = function(opts) {
    var $isolatedContainer, ui;
    $isolatedContainer = $(document.createElement('div'));
    $isolatedContainer.addClass("modal");
    $(document.body).append($isolatedContainer);
    ui = ModalFactory.create(opts);
    $isolatedContainer.append(ui.dialog);
    ui.dialog.on("hidden.bs.modal", function(e, ui) {
      return $isolatedContainer.remove();
    });
    ui.dialog.on("dialog.close", function(e, ui) {
      return $isolatedContainer.modal('hide');
    });
    ui.container = $isolatedContainer;
    return ui;
  };

  $(function() {
    return ModalManager.init();
  });


  /*
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
   */

}).call(this);
