jQuery(document).ready(function($) {
  "use strict";
  var _miniHeight = Math.round(window.innerHeight - $('footer').outerHeight(true)),
      $miniHeight = $('.mini-height');
  
  $miniHeight.css({minHeight: _miniHeight});
  $.windowResize({
    stop: function() {
      _miniHeight = Math.round(window.innerHeight - $('footer').outerHeight(true));
      $miniHeight.css({minHeight: _miniHeight});
    }
  });

  $('.go-top').on('click', function(event) {
    $('body,html').animate({
      scrollTop: 0
    }, 800);
    event.preventDefault();
  });
});