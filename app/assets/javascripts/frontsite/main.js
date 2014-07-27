jQuery(document).ready(function($) {
  "use strict";
  $('.mune-group').on('mouseenter', '.mune-item:not(.search)', function(event) {
    $('#search').prop('checked', false);
    event.preventDefault();
  });
  // 548px
  var _muneSub = $('.mune-sub-group').height() - $('.mune-sub-title').outerHeight(true) - $('.tag-list').outerHeight(true) + 12;
  $('.mune-sub-group').addClass('rady').children('.mune-sub').css('height', _muneSub + 'px');
  $('.mune-sub').perfectScrollbar();
});