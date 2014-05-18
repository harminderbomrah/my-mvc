'use strict';

/* Filters */

angular.module('nyfnApp.filters', [])
.filter('startFrom', function() {
  return function(input, start, end) {
    if (!angular.isArray(input) && !angular.isString(input)) return input;
    start = +start;
    return input.slice(start, end);
  }
})
.filter('capitalize', function() {
  return function(input) {
    input = input.toUpperCase().charAt(0) + input.substring(1);
    return input
  }
})
.filter('interpolate', ['version', function(version) {
  return function(text) {
    return String(text).replace(/\%VERSION\%/mg, version);
  }
}]);
