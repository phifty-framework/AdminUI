# vim:sw=2:ts=2:sts=2:
class QuickBox
  constructor: () ->

    lis = document.querySelectorAll('.quick-box ul > li')
    items = []
    for li in lis
        items.push(li)

    firstMateched = null
    filterItems = (keyword) ->
      firstMateched = null
      for item in items
        title = item.querySelector('.title').innerHTML
        desc = item.querySelector('.desc').innerHTML
        if title.indexOf(keyword) != -1 || desc.indexOf(keyword) != -1
          firstMateched = item unless firstMateched
          item.style.display = "block"
        else
          item.style.display = "none"
    tHandle = null
    @input = $('.quick-box .quicksearch-input')
    @input.keydown (e) =>
      if e.keyCode is 13
        $(firstMateched).find('a').triggerHandler('click')
        return false

      keyword = e.currentTarget.value;
      clearTimeout(tHandle) if tHandle
      tHandle = setTimeout((=>
          filterItems(@input.val())
      ), 50)

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
