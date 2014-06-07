'use strict';


// Declare app level module which depends on filters, and services
var nyfnApp = angular.module('nyfnApp', [
  'ngAnimate',
  'nyfnApp.filters',
  'nyfnApp.services',
  'nyfnApp.directives',
  'nyfnApp.controller.main',
  'nyfnApp.controller.sidebar',
  'ui.bootstrap',
  'localytics.directives',
  'ngProgress'
])
.run(function($rootScope, $log, $location, ngProgress) {

  // 麵包屑
  $rootScope.locationPath = [];
  $rootScope.$log = $log;
  var path = $location.path().split("/").slice(1);
  angular.forEach(path, function(element, index) {
    !isNaN(element) || element == "admin" || index == 3 ? "" : $rootScope.locationPath.push(element);
  });

  // ngProgress config
  ngProgress.color('#7ebee7');
  ngProgress.height('5px');

  // Toastr options
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "positionClass": "toast-bottom-right",
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "300",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "easeOutBack",
    "hideEasing": "easeInBack",
    "showMethod": "slideDown",
    "hideMethod": "slideUp"
  };

  screen = {
    "xs": 480,
    "sm": 768,
    "mb": 992,
    "lg": 1200
  }
})
.config(function($locationProvider) {
  $locationProvider.html5Mode(true);
});