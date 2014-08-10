var _path = window.location.pathname;
_path = _path.split('/')[1];
jQuery(document).ready(function($) {
  "use strict";
  var _miniHeight = Math.round(window.innerHeight - $('footer').outerHeight(true)),
      $miniHeight = $('.mini-height');

  if($('.top-nav').length === 1) {
    _miniHeight = Math.round(_miniHeight - $('.top-nav').outerHeight(true));
    $('.pagination').length === 1 ? _miniHeight = Math.round(_miniHeight - $('.pagination').outerHeight(true)) : null;
  }
  FastClick.attach(document.body);
  $miniHeight.css({minHeight: _miniHeight});
  $.windowResize({
    stop: function() {
      _miniHeight = Math.round(window.innerHeight - $('footer').outerHeight(true))
      if($('.top-nav').length === 1) {
        _miniHeight = Math.round(_miniHeight - $('.top-nav').outerHeight(true));
        $('.pagination').length === 1 ? _miniHeight = Math.round(_miniHeight - $('.pagination').outerHeight(true)) : null;
      }
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