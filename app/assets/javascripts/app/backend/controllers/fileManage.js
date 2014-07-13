'use strict';

/* Controllers */

angular.module('nyfnApp.controller.fileManage', ['angularFileUpload', 'wu.masonry'])

// File Manage controller
.controller('fileManage', ['$rootScope', '$scope', '$log', '$fileUploader', '$jsonData', 'ngProgress', function($rootScope, $scope, $log, $fileUploader, $jsonData, ngProgress) {

  $scope.filejson = {
    file: []
  };

  $rootScope.fileData = {
    source: $scope.initial.preview,
    id: $scope.initial.sourceId,
    originalImgId: $scope.initial.originalImgId
  };
  $scope.masonryOptions = {
    columnWidth: '.problem',
    itemSelector: '.file-content'
  }
  // 將資料庫來源的參數與 $scope.filejson 合併
  $scope.extend = function(src) {
    angular.extend($scope.filejson, src);
    angular.forEach($scope.filejson.file, function(element, index) {
      if($scope.initial.multiple) {
        var usePos = $scope.initial.sourceId.indexOf(element.id);
        usePos >= 0 ? element.use = true : element.use = false;
      } else {
        element.id == $scope.initial.sourceId ? element.use = true : element.use = false;
      }
    });
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
    source: function(value, index) {
      if($scope.initial.multiple) {
        if($scope.filejson.file[index].use) {
          $scope.filejson.file[index].use = false
        } else {
          $scope.filejson.file[index].checked = !$scope.filejson.file[index].checked;
        }

        var sourcePos = $rootScope.fileData.source.indexOf(value.source.medium);
        sourcePos >= 0 ? $rootScope.fileData.source.splice(sourcePos, 1) : $rootScope.fileData.source.push(value.source.medium);

        var idPos = $rootScope.fileData.id.indexOf(value.id);
        idPos >= 0 ? $rootScope.fileData.id.splice(idPos, 1) : $rootScope.fileData.id.push(value.id);
      } else {
        angular.forEach($scope.filejson.file, function(element, index) {
          element.id == value.id ? element.checked = true : element.checked = false
        });
        $rootScope.fileData.source = value.source.medium;
        $rootScope.fileData.id = value.id;
      }
    },
    delete: function(id) {
      var d = confirm("你確定要刪除這個檔案嗎？");
      if(d) {
        ngProgress.start();
        $jsonData.postData('POST', '/admin/assets/delete', {'id': id}, function(data, status) {
          angular.forEach($scope.filejson.file, function(element, index) {
            if(element.id == id) {
              if(id == $scope.initial.originalImgId) {
                $rootScope.fileData.id = null;
                if($scope.initial.assign != undefined) {
                  $scope.initial.clearImg($scope.initial.assign);
                } else {
                  $scope.initial.clearImg($scope.initial.assign);
                }
              }
              if(id == $rootScope.fileData.id) {
                $rootScope.fileData.id = $rootScope.fileData.source = null
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