jQuery(document).ready(function($) {
  "use strict";
  var now = 0,
      $target = $('.promos-pagination-number'),
      _heigth = (function() {
        return window.innerHeight < 400 ? Math.round(window.innerHeight * 0.5) : Math.round(window.innerHeight * 0.3);
      })();
  $('.promos-item').height(_heigth - 1);
  $('.promos-pagination').map(function(index, elem) {
    $(elem).find('.promos-pagination-number').map(function(index, elem) {
      index === now ? $(elem).addClass('active') : null;
    })
  });
  $target.on('click', function(event) {
    var _parentClass = $(this).closest('.promos-item').attr('class').split(' '),
        // _regex = new RegExp('promos-item col-4 col-md-12', 'g'),
        _parent = _parentClass.filter(function(value) {
          // return !_regex.test(value)
          console.log(value)
          return value === "blog" || value === "collections" || value === "case-study"
        })[0];

    switch($(this).index()) {
      case 1:
        $('.' + _parent + ' .promos-post').removeClass('second third').addClass('first');
        break;
      case 2:
        $('.' + _parent + ' .promos-post').removeClass('first third').addClass('second');
        break;
      case 3:
        $('.' + _parent + ' .promos-post').removeClass('first second').addClass('third');
        break;
    };
    $(this).addClass('active').siblings('.promos-pagination-number').removeClass('active');
  });
  $.windowResize({
    stop: function() {
      homeSlide.setHeight((function() {
        if($('footer').height() > Math.round(window.innerHeight * 0.7)) {
          return window.innerHeight;
        } else {
          return Math.round((window.innerHeight * 0.7) - $('footer').height());
        };
      })());
      $('.promos-item').height((function() {
        return window.innerHeight < 400 ? Math.round(window.innerHeight * 0.5) : Math.round(window.innerHeight * 0.3);
      })() - 1);
    }
  });
});