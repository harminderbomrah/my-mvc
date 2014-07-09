'use strict';

/* Controllers */

angular.module('nyfnApp.controller.fileManage', ['angularFileUpload', 'wu.masonry'])
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
.controller('fileManage', ['$rootScope', '$scope', '$log', '$fileUploader', '$jsonData', 'ngProgress', function($rootScope, $scope, $log, $fileUploader, $jsonData, ngProgress) {

  $scope.filejson = {
    file: []
  };

  $rootScope.fileData = {
    source: null,
    id: null
  };
  $scope.masonryOptions = {
    columnWidth: '.problem',
    itemSelector: '.file-content'
  }
  // 將資料庫來源的參數與 $scope.filejson 合併
  $scope.extend = function(src) {
    angular.extend($scope.filejson, src);
    angular.forEach($scope.filejson.file, function(element, index) {
      element.id == $scope.initial.sourceId ? element.use = true : element.use = false;
    });
    $rootScope.fileData.source = $scope.initial.preview;
    $rootScope.fileData.originalImgId = $scope.initial.originalImgId;
    $rootScope.fileData.id = $scope.initial.sourceId;
  };

  $scope.$watch('windowWidth', function(width) {
    if(width < $rootScope.screen.xs) {
      $scope.style = 'col-1';
      $scope.masonryOptions.columnWidth
      return false;
    } else if (width > $rootScope.screen.xs && width < $rootScope.screen.sm) {
      $scope.style = 'col-2';
      return false;
    } else if (width > $rootScope.screen.sm && width < $rootScope.screen.mb) {
      $scope.style = 'col-3';
      return false;
    } else if (width > $rootScope.screen.mb && width < $rootScope.screen.lg) {
      $scope.style = 'col-4';
      return false;
    } else if (width > $rootScope.screen.lg && width < 1440) {
      $scope.style = 'col-5';
      return false;
    } else {
      $scope.style = 'col-8';
      return false;
    }
  });

  $scope.action = {
    source: function(value) {
      angular.forEach($scope.filejson.file, function(element, index) {
        element.id == value.id ? element.checked = true : element.checked = false
      });
      $rootScope.fileData.source = value.source.large;
      $rootScope.fileData.id = value.id;
    },
    delete: function(id) {
      var d = confirm("你確定要刪除這個檔案嗎？");
      if(d) {
        ngProgress.start();
        $jsonData.postData('POST', '/admin/assets/delete', {'id': id}, function(data, status) {
          angular.forEach($scope.filejson.file, function(element, index) {
            if(element.id == id) {
              if(id == $scope.initial.originalImgId) {
                $rootScope.fileData.id = $rootScope.fileData.source = null;
                $scope.initial.clearImg();
              }
              $scope.filejson.file.splice(index, 1);
            }
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
  // ADDING FILTERS

  // Images only
  // uploader.filters.push(function(item) {
  //   var type = uploader.isHTML5 ? item.type : '/' + item.value.slice(item.value.lastIndexOf('.') + 1);
  //   type = '|' + type.toLowerCase().slice(type.lastIndexOf('/') + 1) + '|';
  //   // return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
  //   return true;
  // });

  // REGISTER HANDLERS
  // uploader.bind('afteraddingfile', function (event, item) {
  //   console.info('After adding a file', item);
  // });
  // uploader.bind('whenaddingfilefailed', function (event, item) {
  //   console.info('When adding a file failed', item);
  // });
  // uploader.bind('afteraddingall', function (event, items) {
  //   console.info('After adding all files', items);
  // });
  // uploader.bind('beforeupload', function (event, item) {
  //   console.info('Before upload', item);
  // });
  // uploader.bind('progress', function (event, item, progress) {
  //   console.info('Progress: ' + progress, item);
  // });
  uploader.bind('success', function (event, xhr, item, response) {
    $scope.filejson.file.push(response);
  });
  // uploader.bind('cancel', function (event, xhr, item) {
  //   console.info('Cancel', xhr, item);
  // });
  // uploader.bind('error', function (event, xhr, item, response) {
  //   console.info('Error', xhr, item, response);
  // });
  // uploader.bind('complete', function (event, xhr, item, response) {
  //   console.info('Complete', xhr, item, response);
  // });
  // uploader.bind('progressall', function (event, progress) {
  //   console.info('Total progress: ' + progress);
  // });
  // uploader.bind('completeall', function (event, items) {
  //   console.info('Complete all', items);
  // });
}]);