'use strict';

/* Controllers */

angular.module('nyfnApp.controller.sidebar', [])

// Sidebar controller
.controller('sidebar', ['$cookies', '$cookieStore', '$rootScope', '$scope', '$log', '$location', '$jsonData', function($cookies, $cookieStore, $rootScope, $scope, $log, $location, $jsonData) {
  // get sidebar menu json data use $jsonData services
  $jsonData.getData('/public/side-bar-list.json').then(function(data) {
    $scope.sidebarList = data;
  });
  // Definition sidebar controller scope initial
  $scope.initial = {
    collapse: {
      menu: (function() {
        var m = $cookies.menu || null;
        return m;
      })(),
      arrow: (function() {
        var m = $cookies.arrow || "left";
        return m;
      })()
    },
    active: []
  };

  $log.log($scope.initial.collapse.menu)

  angular.forEach($rootScope.locationPath, function(value) {
    $scope.initial.active.push(value);
  });
  $scope.initial.active.length == 1 ? $scope.initial.active.push("") : "";

  // Definition sidebar controller scope active
  $scope.action = {
    iconType: function(icon) {
      // contrast icon value
      /fa\-/.test(icon) ? (icon = icon + " fa") : /glyphicon\-/.test(icon) ? (icon = icon + " glyphicon") : "";
      return icon
    },
    collapseSidebar: function() {
      // collapse sidebar
      $scope.initial.collapse.menu ? $scope.initial.collapse.menu = $cookies.menu = "" : $scope.initial.collapse.menu = $cookies.menu = "menu-min";
      $scope.initial.collapse.arrow == "left" ? $scope.initial.collapse.arrow = $cookies.arrow = "right" : $scope.initial.collapse.arrow = $cookies.arrow = "left";
    },
    checkPath: function(path, index) {
      var outcome;
      var locationPath = $location.path().split("/");
      path == locationPath[index] ? outcome =  "active" : "";
      return outcome;
    }
  };
}]);