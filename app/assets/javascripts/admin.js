$(function() {

  // Definition jQuery easing type;
  jQuery.easing.def = "easeOutExpo";

  // Main sidebar menu dropdown effact;
  $('.main-sidebar').on('click', '.arrow', function(event) {
    if($(this).closest('li').hasClass('active')) {
      $(this).siblings('.level-2').is(':visible') ? $(this).siblings('.level-2').slideUp(300, function(){$(this).closest('li').removeClass('open')}) : $('.arrow').closest('li').not('.active').children('.level-2').slideUp(300, function(){$(this).closest('li').removeClass('open')});
    } else {
      $('.arrow').closest('li').not('.active').children('.level-2').slideUp(300, function(){$(this).closest('li').removeClass('open')});
    }
    $(this).siblings('.level-2:hidden').slideDown(300, function(){$(this).closest('li').addClass('open')});
  });

  //remove ng-init attr
  $('*').removeAttr('data-ng-init')
});