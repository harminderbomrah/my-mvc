$(function() {
  $('*[data-tab]').on('click', function(event) {
    var $target = $($(this).data('tab')),
        timeout;

    $(this).addClass('active').siblings('.tab-header-item').removeClass('active');
    $target.addClass('active').siblings('.tab-body-item').removeClass('active in');
    timeout = setTimeout(function() {
      $target.addClass('in');
      clearTimeout(timeout)
    }, 0);
    event.preventDefault();
  });
});