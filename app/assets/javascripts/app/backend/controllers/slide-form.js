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
    previewLeft: null,
    previewRight: null,
    submit: false
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
      $scope.initial.id = $scope.slideData.img
      $scope.initial.preview = $scope.slideData.preview;
    };

    // 並監看文章物件裡的日期屬性，如果有值則將 $scope.initial.publishDate 設定為 true
    $scope.$watch('slideData.date', function(date) {
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
  // $scope.choseOptions = {
  //   'width': '100%',
  //   'classes': 'chosen-sm'
  // }

  // ui-ng data options
  $scope.dateOptions = {
    'year-range': 10,
    'year-format': "'yyyy'",
    'starting-day': 1,
    'show-weeks': false,
    'month-format': "'MMM'",
  };

  // tinyMCE options
  // $scope.tinyMceOptions = {
  //   skin : 'nyfm',
  //   language: 'zh_TW',
  //   height: 700,
  //   menubar: false,
  //   toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image template | lists charmap print preview | code",
  //   plugins: 'advlist autolink link image lists charmap print preview template code codemirror',
  //   templates: [
  //       {
  //           title: "Editor Details",
  //           url: "/public/templates/a.html",
  //           description: "Adds Editor Name and Staff ID"
  //       },
  //       {
  //           title: "Timestamp",
  //           url: "/public/templates/b.html",
  //           description: "Adds an editing timestamp."
  //       }
  //   ],
  //   codemirror: {
  //     indentOnInit: true,
  //     path: '/public/CodeMirror'
  //   }
  // };

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
          // $window.location = '/admin/slide/';
        }, function(data, status) {
          toastr.error('Oops! There is something wrong whit server');
          $log.warn(data, status);
          $scope.initial.submit = false;
          ngProgress.reset();
        });
      }
    },

    // 相關連結功能
    // linkAction: {

    //   // 新增連結
    //   add: function() {
    //     if($scope.initial.link.url && $scope.initial.link.text) {

    //       // 驗證資料是否為網址類型
    //       var regex = /(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?/,
    //           regexResult = $scope.initial.link.url.match(regex)
    //       angular.isArray($scope.slideData.link) ? null : $scope.slideData.link = [];

    //       // 通過驗證並加入到陣列
    //       if(regexResult != null) {
    //         $scope.slideData.link.push({
    //           url: $scope.initial.link.url,
    //           text: $scope.initial.link.text
    //         })
    //         $scope.initial.link.url = $scope.initial.link.text = null;
    //       } else {

    //         // 填入資料非網址類型跳出提示訊息
    //         alert("URL is incorrect")
    //       }
    //     } else {

    //       // 未填入任何資料就送出時所跳出的提示訊息
    //       alert("Enter the URL and title")
    //     }
    //   },

    //   // 移除連結
    //   remove: function(idx) {
    //     $scope.slideData.link.splice(idx, 1)
    //   }
    // },

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
              tabSelect: "upload",
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