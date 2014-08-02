jQuery(document).ready(function($) {
  "use strict";
  var _muneSubGroupID;
  $('.have-sub').on('touchstart click', function(event) {
    var _index = $(this).index();
    _muneSubGroupID = $(this).find('a').attr('href');
    $('.nav-bar-menu').find('.have-sub').eq(_index).toggleClass('active').siblings('.have-sub').removeClass('active');
    $('.mune-list').find('.have-sub').eq(_index).toggleClass('active').siblings('.have-sub').removeClass('active');
    $(_muneSubGroupID).toggleClass('active').siblings().removeClass('active');
    event.preventDefault();
  });

  $('.mune-item, .nav-bar-item').hover(function() {
    $('.mune-item').eq($(this).index()).addClass('hover');
    $('.nav-bar-item').eq($(this).index()).addClass('hover');
    if(!$(this).hasClass('search')) {
      $('#search').prop('checked', false);
      $('.search').removeClass('active');
    }
  }, function() {
    $('.mune-item').eq($(this).index()).removeClass('hover');
    $('.nav-bar-item').eq($(this).index()).removeClass('hover');
  });

  $('.search').on('touchstart click', function(event) {
    $('#search').prop('checked') ? $('.search').addClass('active') : $('.search').removeClass('active');
    $('.mune-item:not(.search), .nav-bar-item:not(.search), .nav-sub-item').removeClass('active');
  });

  $('.mune-sub-close').on('touchstart click', function(event) {
    $('.have-sub').removeClass('active');
    $(_muneSubGroupID).removeClass('active');
  });

  $('label.overlay').on('touchstart click', function() {
    $('.search').removeClass('active')
  })

  $('.nav-sub-scroll-zone').perfectScrollbar();
  $('.tag-list').on('touchstart click', '.more', function(event) {
    if($(this).siblings('.tag-item').length > 10) {
      $(this).closest('.tag-list').toggleClass('active');
      if($(this).children('span').text() === '更多標籤') {
        $(this).children('span').text('較少標籤');
        $(this).children('i').removeClass('fa-angle-right').addClass('fa-angle-left');
      } else {
        $(this).children('span').text('更多標籤');
        $(this).children('i').removeClass('fa-angle-left').addClass('fa-angle-right');
      };
      $(this).closest('.nav-sub-scroll-zone').scrollTop(0).perfectScrollbar('update');
      event.preventDefault();
    }
  });
  $('.nav-collapse').on('touchstart click', function(event) {
    $('body').toggleClass('collapse');
    event.preventDefault();
  });
});