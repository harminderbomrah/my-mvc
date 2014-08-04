var map,
    getMap = function() {
      map = new GMaps({
        div: '#map',
        lat: 25.158810,
        lng: 121.418771,
        zoom: 15,
        zoomControl : false,
        zoomControlOpt: {
            style : 'SMALL',
            position: 'TOP_LEFT'
        },
        panControl : false,
        streetViewControl : false,
        mapTypeControl: false,
        overviewMapControl: false
      });
      map.addMarker({
        lat: 25.156810,
        lng: 121.418771
      });
    };
$(document).ready(function(){
  var _rowHeight = Number($('.mini-height').css('min-height').match(/\d/g).join('')) - 1,
      _mapHeight;
  $('.map').height(_rowHeight);
  getMap();
  $.windowResize({
    start: function() {
      _mapHeight = $('.map').outerHeight(true);
    },
    stop: function() {
      if($('.map').outerHeight(true) != _mapHeight) {
        getMap()
      }
      _rowHeight = Number($('.mini-height').css('min-height').match(/\d/g).join('')) - 1;
      $('.map').height(_rowHeight)
    }
  });
});