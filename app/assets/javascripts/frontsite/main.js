jQuery(document).ready(function($) {
  "use strict";
  $('.go-top').on('click', function(event) {
    $('body,html').animate({
      scrollTop: 0
    }, 800);
    event.preventDefault();
  });
});