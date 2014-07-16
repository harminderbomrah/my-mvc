'use strict';

/* Controllers */
angular.module('tinymceFileManage', [
  'nyfnApp.services',
  'nyfnApp.directives',
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
.controller('fileManage', ['$scope', '$log', '$fileUploader', '$jsonData', 'ngProgress', function($scope, $log, $fileUploader, $jsonData, ngProgress) {
  $scope.filejson = {
    file: []
  };

  $scope.initial = {
    tabSelect: 'folder',
  }

  $scope.masonryOptions = {
    columnWidth: '.problem',
    itemSelector: '.file-content'
  }

  // 將資料庫來源的參數與 $scope.filejson 合併
  $scope.extend = function(src) {
    angular.extend($scope.filejson, src);
    angular.element('.filemanage').removeAttr('data-ng-init');
  };

  $scope.action = {
    source: function(value, index) {
      angular.forEach($scope.filejson.file, function(element, index) {
        element.id == value.id ? element.checked = true : element.checked = false
      });
      top.tinymce.activeEditor.windowManager.setParams({"selected" : value.source.large});
    },
    delete: function(id) {
      var d = confirm("你確定要刪除這個檔案嗎？");
      if(d) {
        ngProgress.start();
        $jsonData.postData('POST', '/admin/assets/delete', {'id': id}, function(data, status) {
          angular.forEach($scope.filejson.file, function(element, index) {
            element.id == id ? $scope.filejson.file.splice(index, 1) : null;
          });
          toastr.success('File has been removed');
          ngProgress.complete();
        }, function(data, status) {
          toastr.error('Oops! There is something wrong whit server');
          ngProgress.reset();
        });
      }
    }
  }

  // Creates a uploader
  var uploader = $scope.uploader = $fileUploader.create({
    scope: $scope,
    url: '/admin/assets/new'
  });

  uploader.bind('success', function (event, xhr, item, response) {
    $scope.filejson.file.push(response);
    $scope.initial.tabSelect = 'folder';
  });
  uploader.bind('error', function (event, xhr, item, response) {
    console.info('Error', xhr, item, response);
  });
}]);