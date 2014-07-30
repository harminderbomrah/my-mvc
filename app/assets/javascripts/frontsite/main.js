jQuery(document).ready(function($) {
  "use strict";

  var muneSubGroupID
  $('.mune-item.have-sub').on('click', function(event) {
    muneSubGroupID = $(this).find('a').attr('href');
    $(this).addClass('active').siblings('.have-sub').removeClass('active');
    $(muneSubGroupID).addClass('active').siblings().removeClass('active');
    event.preventDefault();
  });
  $('.mune-item:not(.search)').on('mouseenter', function(event) {
    $('#search').prop('checked', false);
    event.preventDefault();
  });
  $('.mune-sub-close').on('click', function(event) {
    $('.mune-item.have-sub').removeClass('active');
    $(muneSubGroupID).removeClass('active');
  });
  $('.mune-sub-group-scroll-zone').perfectScrollbar();
  $('.tag-list').on('click', '.more', function(event) {
    if($(this).siblings('.tag-item').length > 10) {
      $(this).closest('.tag-list').toggleClass('active');
      if($(this).children('span').text() === '更多標籤') {
        $(this).children('span').text('較少標籤');
        $(this).children('i').removeClass('fa-angle-right').addClass('fa-angle-left');
      } else {
        $(this).children('span').text('更多標籤');
        $(this).children('i').removeClass('fa-angle-left').addClass('fa-angle-right');
      };
      $(this).closest('.mune-sub-group-scroll-zone').scrollTop(0).perfectScrollbar('update');
      event.preventDefault();
    }
  });
});