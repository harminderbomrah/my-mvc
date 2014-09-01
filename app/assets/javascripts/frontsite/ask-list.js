var $askBtn = $('.askbtn'),
    $contact = $('.show .contact'),
    _id = window.location.pathname.split('/'),
    _toggle = true;


_id = _id[_id.length - 1];

$.each(localStorage, function(key, value) {
  if(key == _id) {
    _toggle = false;
    $askBtn.text('已加入詢問清單').addClass('disabled');
    $contact.show('fast');
  }
});
$askBtn.on('click', function(event) {
  if(_toggle) {
    var haveID = false;
    $.each(localStorage, function(key, value) {
      key == _id ? haveID = true : haveID = false;
    });
    if(!haveID) {
      localStorage[_id] = $(this).data('title');
      $askBtn.text('已加入詢問清單').addClass('disabled');
      $contact.show('fast');
    }
    _toggle = false;
  } else {
    localStorage.removeItem(_id);
    $askBtn.text('加入詢問清單').removeClass('disabled');
    $contact.hide('fast');
    _toggle = true;
  }
});