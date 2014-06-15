'use strict';

/* Controllers */

angular.module('nyfnApp.controller.fileManage', [])
// .directive('bullsEye', ['$log', function($log) {
//   return function(scope, element, attrs) {
//     attrs.$observe('bullsEye', function(value) {
//       element.css({
//         'background-image': 'url(' + value + ')'
//       })
//       // var image = document.createElement("img");
//       // image.src = value
//       // image.onload = function() {
//       //   var scale = image.width/image.height
//       //   if(scale > 1 || scale == 1) {
//       //     $(image).css({
//       //       'width': '100%',
//       //       'height': 'auto'
//       //     });
//       //   } else {
//       //     $(image).css({
//       //       'width': 'auto',
//       //       'height': '100%'
//       //     });
//       //   }
//       // }
//       // element.wrapInner(image);
//     });
//   };
// }])

// File Manage controller
.controller('fileManage', ['$rootScope', '$scope', '$log', function($rootScope, $scope, $log) {

  $scope.filejson = {};
  $rootScope.fileData = {
    source: null,
    id: null
  };
  // 將資料庫來源的參數與 $scope.filejson 合併
  $scope.extend = function(src) {
    angular.extend($scope.filejson, src);
    angular.forEach($scope.filejson.file, function(element, index) {
      element.id == $scope.initial.sourceId ? element.checked = true : element.checked = false;
      $rootScope.fileData.source = $scope.initial.preview;
    })
  };

  $scope.$watch('windowWidth', function(width) {
    if(width < $rootScope.screen.xs) {
      $scope.fileGroup = $scope.action.regroup($scope.filejson.file, 2);
      return false;
    } else if (width > $rootScope.screen.xs && width < $rootScope.screen.sm) {
      $scope.fileGroup = $scope.action.regroup($scope.filejson.file, 3);
      return false;
    } else if (width > $rootScope.screen.sm && width < $rootScope.screen.mb) {
      $scope.fileGroup = $scope.action.regroup($scope.filejson.file, 4);
      return false;
    } else if (width > $rootScope.screen.mb && width < $rootScope.screen.lg) {
      $scope.fileGroup = $scope.action.regroup($scope.filejson.file, 5);
      return false;
    } else if (width > $rootScope.screen.lg && width < 1440) {
      $scope.fileGroup = $scope.action.regroup($scope.filejson.file, 6);
      return false;
    } else {
      $scope.fileGroup = $scope.action.regroup($scope.filejson.file, 10);
      return false;
    }
  });
  
  $scope.action = {
    regroup: function(value, col) {
      var set = [];
      angular.forEach(value, function(element, index) {
        if(index % col == 0) {
          set.push([]);
        };
        set[set.length-1].push(element);
      });
      return set
    },
    thumbnail: function(value, size) {
      var source = null;
      if(value.class == "image") {
        var src = null
        angular.forEach(value.source, function(v, k) {
          if(k == size) {
            src = v
          }
        })
        source = $scope.filejson.location + value.class + '/' + src + '.' + value.type
      } else {
        source = $scope.filejson.location + 'icon/' + value.type + '.png'
      }
      return source
    },
    source: function(value) {
      angular.forEach($scope.filejson.file, function(element, index) {
        element.id == value.id ? element.checked = true : element.checked = false
      })
      var source = null;
      if(value.class == "image") {
        source = $scope.filejson.location + value.class + '/' + value.source.large + '.' + value.type
      } else {
        source = $scope.filejson.location + value.class + '/' + value.source + '.' + value.type
      }
      $rootScope.fileData.source = source
      $rootScope.fileData.id = value.id
    }
  }
}]);