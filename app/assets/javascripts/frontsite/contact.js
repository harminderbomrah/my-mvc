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
      _winHeight,
      _mapHeight;
  $('.map').height(_rowHeight);
  getMap();
  $('.ask-list-inner').removeAttr('data-ng-init');
  window.innerWidth <= 992 ? null : $('.content').height(_rowHeight).perfectScrollbar();
  $.windowResize({
    start: function() {
      _mapHeight = $('.map').outerHeight(true);
      _winHeight = window.innerHeight;
    },
    stop: function() {
      if($('.map').outerHeight(true) != _mapHeight) {
        getMap()
      }
      _rowHeight = Number($('.mini-height').css('min-height').match(/\d/g).join('')) - 1;
      if(window.innerWidth <= 992) {
        $('.content').removeAttr('style').perfectScrollbar('destroy');
      } else {
        $('.content').height(_rowHeight);
        if(!$('.content .ps-scrollbar-x-rail').length) {
          $('.content').perfectScrollbar();
        };
        if(_winHeight != window.innerHeight) {
          $('.content').height(_rowHeight).scrollTop(0).perfectScrollbar('update');
        };
      }
      $('.map').height(_rowHeight)
    }
  });
});
var contact = angular.module('contact', ['nyfnApp.services'])
.controller('contactForm', ['$scope', '$log', '$jsonData', '$myCookie', function($scope, $log, $jsonData, $myCookie) {
  $scope.success = false;
  $scope.askList = {};
  $scope.data = {
    product: []
  }
  $scope.extend = function(source) {
    angular.extend($scope.askList, source);
    angular.forEach($scope.askList, function(value, index) {
      $scope.data.product.push(value.id);
    });
  }
  $scope.cancelProduct = function(id, $event) {
    $scope.data.product.splice($scope.data.product.indexOf(id), 1);
    angular.element($event.currentTarget).closest('li').remove();
  }
  $scope.cancelList = function() {
    var d = confirm("你確定要清除清單嗎？");
    if(d) {
      $scope.data.product = $scope.askList = null;
      $myCookie.destroy('ask');
    }
  }
  $scope.submit = function(form) {
    if(form.$error.required.length) {
      angular.forEach(form.$error.required, function(element) {
        element.$pristine = false;
      });
    }
    if(form.$valid) {
      $jsonData.postData('POST', '/contact/send', $scope.data, function(data, status) {
        $scope.success = true;
        $myCookie.destroy('ask');
        $('.ask-list').scrollTop(0).perfectScrollbar('update');
      })
    } else {
      alert("紅框欄位為必填");
    }
  }
}]);