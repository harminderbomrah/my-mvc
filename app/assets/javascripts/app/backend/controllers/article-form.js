'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', ['nyfnApp.controller.fileManage', 'ui.tinymce'])

// Main Form controller
.controller('articleForm', ['$scope', '$log', '$window', '$location', '$modal', '$jsonData', 'ngProgress', function($scope, $log, $window, $location, $modal, $jsonData, ngProgress) {

  // 建立空的文章物件
  $scope.articleData = {};

  // 檢查頁面是新增或是編輯
  var path = $window.location.pathname.split("/");
      path = path[path.length - 1];
  var postPath = "create";
  var articleID = "";

  if(path !== "new") {

    // 如果頁面為編輯則將後端資料與文章物件合併
    $scope.extend = function(src) {
      angular.extend($scope.articleData, src);
    };

    // 並監看文章物件裡的日期屬性，如果有值則將 $scope.initial.publishDate 設定為 true
    $scope.$watch('articleData.publishDate', function(date) {
      date ? $scope.initial.publishDate = true : null
    });

    // 並監看文章物件裡的日期屬性，如果有值則將 $scope.initial.endDate 設定為 true
    $scope.$watch('articleData.endDate', function(date) {
      date ? $scope.initial.endDate = true : null
    });

    postPath = "update";
    articleID = path;
  }

  // 讀取關連物件的資料
  $jsonData.getData('/admin/article/get_relation_data').then(function(data) {
    $scope.relationData = data;
  });

  // Definition main form controller scope initial
  $scope.initial = {
    today: new Date(),
    publishDate: false,
    link: {
      url: null,
      text: null
    },
    preview: null,
    submit: false
  }

  // chose js options
  $scope.choseOptions = {
    'width': '100%',
    'classes': 'chosen-sm'
  }

  // ui-ng data options
  $scope.dateOptions = {
    'year-range': 10,
    'year-format': "'yyyy'",
    'starting-day': 1,
    'show-weeks': false,
    'month-format': "'MMM'",
  };

  // tinyMCE options
  $scope.tinyMceOptions = {
    skin : 'nyfm',
    language: 'zh_TW',
    height: 700,
    menubar: false,
    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image template | lists charmap print preview | code",
    plugins: 'advlist autolink link image lists charmap print preview template code codemirror',
    templates: [
        {
            title: "Editor Details",
            url: "/public/templates/a.html",
            description: "Adds Editor Name and Staff ID"
        },
        {
            title: "Timestamp",
            url: "/public/templates/b.html",
            description: "Adds an editing timestamp."
        }
    ],
    codemirror: {
      indentOnInit: true,
      path: '/public/CodeMirror'
    }
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
      if(typeof $scope.articleData.publishDate == "object") {
        $scope.articleData.publishDate = $scope.articleData.publishDate.getTime()
      }

      // 欄位驗證通過透過Ajax送出欄位資料
      if(typeof $scope.articleData.endDate == "object") {
        $scope.articleData.endDate = $scope.articleData.endDate.getTime()
      }
      if(form.$valid) {
        ngProgress.start();
        $scope.initial.submit = true;

        if(postPath=='update') $scope.articleData['id'] = articleID;

        $jsonData.postData('POST', '/admin/article/'+postPath, $scope.articleData, function(data, status) {
          ngProgress.complete();
          // $window.location = '/admin/article/';
        }, function(data, status) {
          toastr.error('Oops! There is something wrong whit server');
          $log.warn(data, status);
          $scope.initial.submit = false;
          ngProgress.reset();
        });
      }
    },

    // 相關連結功能
    linkAction: {

      // 新增連結
      add: function() {
        if($scope.initial.link.url && $scope.initial.link.text) {

          // 驗證資料是否為網址類型
          var regex = /(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?/,
              regexResult = $scope.initial.link.url.match(regex)
          angular.isArray($scope.articleData.link) ? null : $scope.articleData.link = [];

          // 通過驗證並加入到陣列
          if(regexResult != null) {
            $scope.articleData.link.push({
              url: $scope.initial.link.url,
              text: $scope.initial.link.text
            })
            $scope.initial.link.url = $scope.initial.link.text = null;
          } else {

            // 填入資料非網址類型跳出提示訊息
            alert("URL is incorrect")
          }
        } else {

          // 未填入任何資料就送出時所跳出的提示訊息
          alert("Enter the URL and title")
        }
      },

      // 移除連結
      remove: function(idx) {
        $scope.articleData.link.splice(idx, 1)
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
        if(value && $scope.articleData) {
          if(type == 'publish') {
            $scope.articleData.publishDate = undefined
          } else if(type == 'end') {
            $scope.articleData.endDate = undefined
          }
        };
      }
    },

    clearImg: function() {
      $scope.articleData.img = null;
      $scope.initial.preview = null;
    },

    fileUpLoad: function() {
      var fileManageModal = $modal.open({
        templateUrl: '/modal/filemanage',
        controller: FileManage,
        windowClass: 'file-manage',
        resolve: {
          initial: function () {
            return {
              tabSelect: "folder",
              sourceId: $scope.articleData.img,
              preview: $scope.initial.preview
            };
          }
        }
      });
      fileManageModal.result.then(function(fileData) {
        $scope.articleData.img = fileData.id
        $scope.initial.preview = fileData.source
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