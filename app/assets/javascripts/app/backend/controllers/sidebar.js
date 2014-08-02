'use strict';

/* Controllers */

angular.module('nyfnApp.controller.sidebar', [])

// Sidebar controller
.controller('sidebar', ['$rootScope', '$scope', '$log', '$location', '$jsonData', '$myCookie', function($rootScope, $scope, $log, $location, $jsonData, $myCookie) {
  // get sidebar menu json data use $jsonData services
  $jsonData.getData('/public/side-bar-list.json').then(function(data) {
    $scope.sidebarList = data;
  });
  // Definition sidebar controller scope initial
  $scope.initial = {
    collapse: {
      menu: (function() {
        var m = $myCookie.get('menu') || null;
        return m;
      })(),
      arrow: (function() {
        var m = $myCookie.get('arrow') || "left";
        return m;
      })()
    },
    active: []
  };

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
      $scope.initial.collapse.menu ? $scope.initial.collapse.menu = $myCookie.destroy("menu") : $scope.initial.collapse.menu = $myCookie.set("menu", "menu-min", 5);
      if($scope.initial.collapse.arrow === "left") {
        $scope.initial.collapse.arrow = $myCookie.set("arrow", "right", 5);
      } else {
        $scope.initial.collapse.arrow = "left";
        $myCookie.destroy("arrow");
      }
    },
    checkPath: function(path, index) {
      var outcome;
      var locationPath = $location.path().split("/");
      path == locationPath[index] ? outcome =  "active" : "";
      return outcome;
    }
  };
}]);