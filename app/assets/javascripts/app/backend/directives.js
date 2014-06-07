'use strict';

/* Directives */


angular.module('nyfnApp.directives', [])
.directive('resizable', ['$rootScope', '$window', function($rootScope, $window) {
  return {
    link: function(scope, elm, attrs) {
      // var options = scope.$eval(attrs.resizable) || {};
      scope.initializeWindowSize = function() {
        scope.windowHeight = $window.innerHeight;
        scope.windowWidth  = $window.innerWidth;
      };
      angular.element($window).bind("resize", function() {
        scope.initializeWindowSize();
        scope.$apply();
      });
      scope.initializeWindowSize();
    }
  }
}])
.directive('appVersion', ['version', function(version) {
  return function(scope, elm, attrs) {
    console.log(scope, elm, attrs)
    elm.text(version);
  };
}]);