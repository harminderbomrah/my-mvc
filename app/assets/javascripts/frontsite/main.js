jQuery(document).ready(function($) {
  "use strict";
  $('.mune-group').on('mouseenter', '.mune-item:not(.search)', function(event) {
    $('#search').prop('checked', false);
    event.preventDefault();
  });
  $('.mune-sub').perfectScrollbar();
});