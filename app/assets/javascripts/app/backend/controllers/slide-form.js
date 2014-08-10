'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', ['nyfnApp.controller.fileManage'])

// Main Form controller
.controller('slideForm', ['$scope', '$log', '$window', '$location', '$filter', '$modal', '$jsonData', 'ngProgress', function($scope, $log, $window, $location, $filter, $modal, $jsonData, ngProgress) {

  // 建立空的文章物件
  $scope.slideData = {
    imgLeft: null,
    imgRight: null
  };

  // Definition main form controller scope initial
  $scope.initial = {
    today: new Date(),
    publishDate: false,
    editPublishDate: false,
    previewLeft: null,
    previewRight: null,
    submit: false,
    series: [{
      class: 'modern',
      name: '現代'
    }, {
      class: 'luxury',
      name: '奢華'
    }, {
      class: 'green',
      name: '環保'
    }]
  }

  // 檢查頁面是新增或是編輯
  var path = $window.location.pathname.split("/");
      path = path[path.length - 1];
  var postPath = "create";
  var slideID = "";

  if(path !== "new") {

    // 如果頁面為編輯則將後端資料與文章物件合併
    $scope.extend = function(src) {
      angular.extend($scope.slideData, src);
      $log.log($scope.slideData)
      $scope.initial.id = $scope.slideData.img
      $scope.initial.previewLeft = $scope.slideData.previewLeft;
      $scope.initial.previewRight = $scope.slideData.previewRight;
      $scope.initial.editPublishDate = $scope.caseData.publishDate;
    };

    // 並監看文章物件裡的日期屬性，如果有值則將 $scope.initial.publishDate 設定為 true
    $scope.$watch('slideData.publishDate', function(date) {
      date ? $scope.initial.publishDate = true : null
    });

    // 並監看文章物件裡的日期屬性，如果有值則將 $scope.initial.endDate 設定為 true
    $scope.$watch('slideData.endDate', function(date) {
      date ? $scope.initial.endDate = true : null
    });

    postPath = "update";
    slideID = path;
  }

  // 讀取關連物件的資料
  $jsonData.getData('/admin/slide/get_relation_data').then(function(data) {
    $scope.relationData = data;
  });

  // chose js options
  $scope.choseOptions = {
    'width': '150px',
    'classes': 'chosen-sm pull-right',
    'disable_search_threshold': 10
  }

  // ui-ng data options
  $scope.dateOptions = {
    'year-range': 10,
    'year-format': "'yyyy'",
    'starting-day': 1,
    'show-weeks': false,
    'month-format': "'MMM'",
  };

  $scope.action = {

    // 送出資料
    submit: function(form) {

      // 驗證必填欄位

      if(form.$error.required.length) {
        angular.forEach(form.$error.required, function(element) {
          element.$pristine = false;
        });
      }

      // 欄位驗證通過透過Ajax送出欄位資料
      if(typeof $scope.slideData.publishDate == "object") {
        $scope.slideData.publishDate = $filter('date')($scope.slideData.publishDate, 'yyyy-MM-dd');
      } else if(typeof $scope.slideData.publishDate == "number") {
        $scope.slideData.publishDate = new Date($scope.slideData.publishDate);
        $scope.slideData.publishDate = $filter('date')($scope.slideData.publishDate, 'yyyy-MM-dd');
      }

      // 欄位驗證通過透過Ajax送出欄位資料
      if(typeof $scope.slideData.endDate == "object") {
        $scope.slideData.endDate = $filter('date')($scope.slideData.endDate, 'yyyy-MM-dd');
      } else if(typeof $scope.slideData.endDate == "number") {
        $scope.slideData.endDate = new Date($scope.slideData.endDate);
        $scope.slideData.endDate = $filter('date')($scope.slideData.endDate, 'yyyy-MM-dd');
      }

      if(form.$valid) {
        ngProgress.start();
        $scope.initial.submit = true;

        if(postPath=='update') $scope.slideData['id'] = slideID;

        $jsonData.postData('POST', '/admin/slide/'+postPath, $scope.slideData, function(data, status) {
          ngProgress.complete();
          $window.location = '/admin/slide/';
        }, function(data, status) {
          toastr.error('Oops! There is something wrong whit server');
          $log.warn(data, status);
          $scope.initial.submit = false;
          ngProgress.reset();
        });
      }
    },

    // datapicker 動作
    datepicker: {

      // 打開 datapick window
      open: function($event, type) {
        $event.preventDefault();
        $event.stopPropagation();
        if(type == 'publish') {
          $scope.openedPuplish = true;
          $scope.openedEnd = false;
        } else if(type == 'end') {
          $scope.openedPuplish = false;
          $scope.openedEnd = true;
        }
      },

      // 清除以設定的日期
      clear: function (value, type) {
        if(value && $scope.slideData) {
          if(type == 'publish') {
            $scope.slideData.publishDate = undefined;
            $scope.initial.endDate = false;
            $scope.slideData.endDate = undefined;
          } else if(type == 'end') {
            $scope.slideData.endDate = undefined
          }
        } else if(!value && type == 'end') {
          $scope.initial.publishDate = true;
        };
      }
    },

    clearImg: function(value) {
      if(value == 'left') {
        $scope.slideData.imgLeft = null;
        $scope.initial.previewLeft = null;
      } else if(value == 'right') {
        $scope.slideData.imgRight = null;
        $scope.initial.previewRight = null;
      }
    },

    fileUpLoad: function(value) {
      var fileManageModal = $modal.open({
        templateUrl: '/modal/filemanage',
        controller: FileManage,
        windowClass: 'file-manage',
        resolve: {
          initial: function () {
            return {
              tabSelect: "folder",
              sourceId: (function() {
                if(value == 'left') {
                  return $scope.slideData.imgLeft;
                } else if(value == 'right') {
                  return $scope.slideData.imgRight;
                }
              })(),
              originalImgId: (function() {
                if(value == 'left') {
                  return $scope.slideData.imgLeft;
                } else if(value == 'right') {
                  return $scope.slideData.imgRight;
                }
              })(),
              preview: (function() {
                if(value == 'left') {
                  return $scope.initial.previewLeft;
                } else if(value == 'right') {
                  return $scope.initial.previewRight;
                }
              })(),
              clearImg: $scope.action.clearImg,
              assign: value
            };
          }
        }
      });
      fileManageModal.result.then(function(fileData) {
        if(value == 'left') {
          $scope.slideData.imgLeft = fileData.id
          $scope.initial.previewLeft = fileData.source
        } else if(value == 'right') {
          $scope.slideData.imgRight = fileData.id
          $scope.initial.previewRight = fileData.source
        }
      });
      // fileManageModal.opened.then(function() {});
    }
  }
}]);

var FileManage = function ($rootScope, $scope, $log, $modalInstance, initial) {
  $scope.initial = initial;
  $scope.insert = function() {
    $modalInstance.close($rootScope.fileData);
  }
  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}