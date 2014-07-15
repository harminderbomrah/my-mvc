'use strict';

/* Controllers */
angular.module('tinymceFileManage', [
  'nyfnApp.services',
  'angularFileUpload',
  'wu.masonry',
  'ngProgress'
])

.run(function($rootScope, $log, $location, ngProgress) {

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
})

// File Manage controller
.controller('fileManage', ['$rootScope', '$scope', '$log', '$fileUploader', '$jsonData', 'ngProgress', function($rootScope, $scope, $log, $fileUploader, $jsonData, ngProgress) {
  $scope.ddd = 333;
  $log.log($scope.ddd)
}]);