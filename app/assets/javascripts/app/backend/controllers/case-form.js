'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', ['nyfnApp.controller.fileManage', 'ui.tinymce'])

// Main Form controller
.controller('caseForm', ['$scope', '$log', '$window', '$location', '$filter', '$modal', '$jsonData', 'ngProgress', function($scope, $log, $window, $location, $filter, $modal, $jsonData, ngProgress) {

  // 建立空的文章物件
  $scope.caseData = {};

  // Definition main form controller scope initial
  $scope.initial = {
    today: new Date(),
    publishDate: false,
    link: {
      url: null,
      text: null
    },
    preview: null,
    submit: false,
    location: [
      {name: '基隆市', value: 'Keelung'},
      {name: '臺北市', value: 'Taipei'},
      {name: '新北市', value: 'New Taipei City'},
      {name: '桃園縣', value: 'Taoyuan County'},
      {name: '新竹市', value: 'Hsinchu City'},
      {name: '新竹縣', value: 'Hsinchu County'},
      {name: '苗栗縣', value: 'Miaoli County'},
      {name: '臺中市', value: 'Taichung'},
      {name: '彰化縣', value: 'Changhua County'},
      {name: '南投縣', value: 'Nantou County'},
      {name: '雲林縣', value: 'Yunlin County'},
      {name: '嘉義市', value: 'Chiayi City'},
      {name: '嘉義縣', value: 'Chiayi County'},
      {name: '臺南市', value: 'Tainan'},
      {name: '高雄市', value: 'Kaohsiung'},
      {name: '屏東縣', value: 'Pingtung County'},
      {name: '臺東縣', value: 'Taitung County'},
      {name: '花蓮縣', value: 'Hualien County'},
      {name: '宜蘭縣', value: 'Yilan County'},
      {name: '澎湖縣', value: 'Penghu County'}
    ]
  }

  // 檢查頁面是新增或是編輯
  var path = $window.location.pathname.split("/");
      path = path[path.length - 1];
  var postPath = "create";
  var caseID = "";

  if(path !== "new") {

    // 如果頁面為編輯則將後端資料與文章物件合併
    $scope.extend = function(src) {
      angular.extend($scope.caseData, src);
      $scope.initial.id = $scope.caseData.img
      $scope.initial.preview = $scope.caseData.preview;
    };

    // 並監看文章物件裡的日期屬性，如果有值則將 $scope.initial.publishDate 設定為 true
    $scope.$watch('caseData.publishDate', function(date) {
      date ? $scope.initial.publishDate = true : null
    });

    // 並監看文章物件裡的日期屬性，如果有值則將 $scope.initial.endDate 設定為 true
    $scope.$watch('caseData.endDate', function(date) {
      date ? $scope.initial.endDate = true : null
    });

    postPath = "update";
    caseID = path;
  }

  // 讀取關連物件的資料
  $jsonData.getData('/admin/case/get_relation_data').then(function(data) {
    $scope.relationData = data;
  });

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
      if(typeof $scope.caseData.publishDate == "object") {
        $scope.caseData.publishDate = $filter('date')($scope.caseData.publishDate, 'yyyy-MM-dd');
      } else if(typeof $scope.caseData.publishDate == "number") {
        $scope.caseData.publishDate = new Date($scope.caseData.publishDate);
        $scope.caseData.publishDate = $filter('date')($scope.caseData.publishDate, 'yyyy-MM-dd');
      }

      // 欄位驗證通過透過Ajax送出欄位資料
      if(typeof $scope.caseData.endDate == "object") {
        $scope.caseData.endDate = $filter('date')($scope.caseData.endDate, 'yyyy-MM-dd');
      } else if(typeof $scope.caseData.endDate == "number") {
        $scope.caseData.endDate = new Date($scope.caseData.endDate);
        $scope.caseData.endDate = $filter('date')($scope.caseData.endDate, 'yyyy-MM-dd');
      }

      if(form.$valid) {
        ngProgress.start();
        $scope.initial.submit = true;

        if(postPath=='update') $scope.caseData['id'] = caseID;

        $jsonData.postData('POST', '/admin/case/'+postPath, $scope.caseData, function(data, status) {
          ngProgress.complete();
          // $window.location = '/admin/case/';
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
        if(value && $scope.caseData) {
          if(type == 'publish') {
            $scope.caseData.publishDate = undefined;
            $scope.initial.endDate = false;
            $scope.caseData.endDate = undefined;
          } else if(type == 'end') {
            $scope.caseData.endDate = undefined
          }
        } else if(!value && type == 'end') {
          $scope.initial.publishDate = true;
        };
      }
    },

    clearImg: function() {
      $scope.caseData.img = null;
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
              sourceId: $scope.caseData.img,
              originalImgId: $scope.caseData.img,
              preview: $scope.initial.preview,
              clearImg: $scope.action.clearImg
            };
          }
        }
      });
      fileManageModal.result.then(function(fileData) {
        $scope.caseData.img = fileData.id
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
