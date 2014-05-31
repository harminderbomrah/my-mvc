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
  $scope.initial = {};
  // $rootScope.fileUrl = '555.jpg'
  // 將資料庫來源的參數與 $scope.initial 合併
  $scope.extend = function(src) {
    angular.extend($scope.initial, src);
    $log.log($scope.initial)
  };
}]);