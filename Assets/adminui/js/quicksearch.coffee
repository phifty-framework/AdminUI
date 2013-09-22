# vim:sw=2:ts=2:sts=2:
class QuickBox
  constructor: () ->
    @selected = 0
    @container = document.querySelector('.quick-box')

    lis = @container.querySelectorAll('ul > li')
    items = []
    items.push(li) for li in lis

    @firstMatched = items[0]
    @filteredItems = items
    filterItems = (keyword) =>
      keyword = keyword.toLowerCase()
      # reset
      @filteredItems = []
      @firstMatched = null
      @selected = 0
      for item in items
        do (item) =>
          $item = $(item)
          $item.removeClass("select")
          title = item.querySelector('.title').innerHTML.toLowerCase()
          desc = item.querySelector('.desc').innerHTML.toLowerCase()
          if title.indexOf(keyword) != -1 || desc.indexOf(keyword) != -1
            @firstMatched = item unless @firstMatched
            @filteredItems.push item
            $item.removeClass('out')
          else
            $item.addClass('out')
    tHandle = null
    @input = $('.quick-box .quicksearch-input')
    @input.keydown (e) =>
      if e.keyCode is 13
        selected = @container.querySelector('li.select')
        if selected
          $(selected).find('a').triggerHandler('click')
          return false
        else
          $(@firstMatched).find('a').triggerHandler('click')
          return false
      else if e.keyCode is 38
        $(@container.querySelector('li.select')).removeClass('select')
        if @selected > 0
          @selected--
          $(@filteredItems[ @selected-1 ]).addClass('select')
        return false
      else if e.keyCode is 40
        $(@container.querySelector('li.select')).removeClass('select')
        @selected++
        $(@filteredItems[ @selected-1 ]).addClass('select')
        return false

      # update list
      keyword = e.currentTarget.value;
      clearTimeout(tHandle) if tHandle
      tHandle = setTimeout (=>
        filterItems(@input.val())
      ), 50

    $('.quick-box-overlay').click (e) => @hide()
    $('.quick-box a').click (e) =>
      @hide()
      return false

    $(document.body).keydown (e) =>
      if e.keyCode == 191
        @show()
        e.stopPropagation()
        e.preventDefault()
        return false

  show: () ->
    $('.quick-box-wrapper').show()
    $('.quick-box').addClass('in')
    @input.focus()
    @input.select()

  hide: () ->
    $('.quick-box').removeClass('in')
    $('.quick-box-wrapper').hide()
window.QuickBox = QuickBox
