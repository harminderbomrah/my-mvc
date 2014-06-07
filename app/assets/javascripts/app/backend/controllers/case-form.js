'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', ['nyfnApp.controller.fileManage', 'ui.tinymce'])

// Main Form controller
.controller('caseForm', ['$scope', '$log', '$window', '$location', '$modal', '$jsonData', 'ngProgress', function($scope, $log, $window, $location, $modal, $jsonData, ngProgress) {

  // 建立空的文章物件
  $scope.caseData = {};

  // 檢查頁面是新增或是編輯
  var path = $window.location.pathname.split("/");
      path = path[path.length - 1];
  if(path !== "new") {

    // 如果頁面為編輯則將後端資料與文章物件合併
    $scope.extend = function(src) {
      angular.extend($scope.caseData, src);
    };

    // 並監看文章物件裡的日期屬性，如果有值則將 $scope.initial.publishDate 設定為 true
    $scope.$watch('caseData.date', function(date) {
      date ? $scope.initial.publishDate = true : null
    });
  }

  // 讀取關連物件的資料
  $jsonData.getData('/admin/case/get_relation_data').then(function(data) {
    $scope.relationData = data;
  });

  // Definition main form controller scope initial
  $scope.initial = {
    today: new Date(),
    publishDate: false,
    link: {
      url: null,
      text: null
    }
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
      if(form.$valid) {
        ngProgress.start();
        $jsonData.postData('POST', '/admin/case/', $scope.caseData, function(data, status) {
          ngProgress.complete();
          // $window.location = $window.location.pathname.match(/\/\w*/g).slice(0, -1).join("");
        }, function(data, status) {
          toastr.error('Oops! There is something wrong whit server');
          $log.warn(data, status);
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
          angular.isArray($scope.caseData.link) ? null : $scope.caseData.link = [];

          // 通過驗證並加入到陣列
          if(regexResult != null) {
            $scope.caseData.link.push({
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
        $scope.caseData.link.splice(idx, 1)
      }
    },

    // datapicker 動作
    datepicker: {

      // 打開 datapick window
      open: function($event) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened = true;
      },

      // 清除以設定的日期
      clear: function (value) {
        value && $scope.caseData ? $scope.caseData.date = null : null;
      }
    },

    fileUpLoad: function() {
      var fileManageModal = $modal.open({
        templateUrl: '/modal/filemanage',
        controller: FileManage,
        windowClass: 'file-manage',
        resolve: {
          msg: function () {
            return "msg";
          }
        }
      });
      fileManageModal.result.then(function(fileUrl) {
        $scope.caseData.img = fileUrl
      });
      // fileManageModal.opened.then(function() {});
    }
  }
}]);

var FileManage = function ($rootScope, $scope, $log, $modalInstance) {
  $scope.insert = function() {
    $modalInstance.close($rootScope.fileUrl);
  }
  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}