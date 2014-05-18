'use strict';

/* Controllers */

angular.module('nyfnApp.controller.sidebar', [])

// Sidebar controller
.controller('sidebar', ['$rootScope', '$scope', '$log', '$location', '$jsonData', function($rootScope, $scope, $log, $location, $jsonData) {

  // get sidebar menu json data use $jsonData services
  $jsonData.getData('/public/side-bar-list.json').then(function(data) {
    $scope.sidebarList = data;
  });
  // Definition sidebar controller scope initial
  $scope.initial = {
    collapse: {         // for sidebar collapse swithc
      menu: "",         // collapse swithc default class name, Do not modify
      arrow: "left"     // collapse swithc icon default class name, Do not modify
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
      // collapse sidebar
      $scope.initial.collapse.menu ? $scope.initial.collapse.menu = "" : $scope.initial.collapse.menu = "menu-min";
      $scope.initial.collapse.arrow == "left" ? $scope.initial.collapse.arrow = "right" : $scope.initial.collapse.arrow = "left";
    },
    checkPath: function(path, index) {
      var outcome;
      var locationPath = $location.path().split("/");
      path == locationPath[index] ? outcome =  "active" : "";
      return outcome;
    }
  };
}]);