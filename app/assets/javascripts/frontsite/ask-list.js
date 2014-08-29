var $askBtn = $('.askbtn'),
    _id = window.location.pathname.split('/'),
    _toggle = true;


_id = _id[_id.length - 1];

$.each(localStorage, function(key, value) {
  key == _id ? $askBtn.text('已加入詢問清單').addClass('disabled') : null;
});
$askBtn.on('click', function(event) {
  if(_toggle) {
    var haveID = false;
    $.each(localStorage, function(key, value) {
      key == _id ? haveID = true : haveID = false;
    });
    if(!haveID) {
      localStorage[_id] = $(this).data('title');
      $askBtn.text('已加入詢問清單').addClass('disabled')
    }
    _toggle = false;
  } else {
    localStorage.removeItem(_id);
    $askBtn.text('加入詢問清單').removeClass('disabled')
    _toggle = true;
  }
});