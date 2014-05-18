'use strict';

/* Directives */


angular.module('nyfnApp.directives', [])
.directive('appVersion', ['version', function(version) {
  return function(scope, elm, attrs) {
    console.log(scope, elm, attrs)
    elm.text(version);
  };
}]);