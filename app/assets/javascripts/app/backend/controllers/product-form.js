'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', ['nyfnApp.controller.fileManage'])

.controller('productForm', ['$scope', '$log', '$window', '$location', '$modal', '$jsonData', 'ngProgress', function($scope, $log, $window, $location, $modal, $jsonData, ngProgress) {

  // 建立空的文章物件
  $scope.productData = {
    specs: [
      {item: '', detail: null}
    ]
  };

  // 檢查頁面是新增或是編輯
  var path = $window.location.pathname.split("/");
      path = path[path.length - 1];
  if(path !== "new") {

    // 如果頁面為編輯則將後端資料與文章物件合併
    $scope.extend = function(src) {
      angular.extend($scope.productData, src);
    };
  }

  // 讀取關連物件的資料
  $jsonData.getData('/admin/product/get_relation_data').then(function(data) {
    $scope.relationData = data;
  });

  // Definition main form controller scope initial
  $scope.initial = {
    toggleVel: {
      bl: false,
      srt: "Add New"
    },
    link: {
      url: null,
      text: null
    },
    error: {
      title: false,
      category: false
    },
    addDisabled: false
  }

  // chose js options
  $scope.choseOptions = {
    'width': '100%',
    'classes': 'chosen-sm'
  }

  $scope.action = {

    // input select change event
    change: function(type) {
      switch(type) {
        case "category":
          if($scope.initial.toggleVel.bl) {
            $scope.initial.toggleVel.bl = false;
            $scope.initial.toggleVel.srt = "Add New";
          };
        break
      }
    },

    // 建立新的類別
    toggleBtn: function() {
      $scope.productData.category = null;
      $scope.initial.toggleVel.bl = !$scope.initial.toggleVel.bl
      if($scope.initial.toggleVel.bl) {
        $scope.initial.toggleVel.srt = "Cancel"
      } else {
        $scope.initial.toggleVel.srt = "Add New"
      }
    },

    // 送出資料
    submit: function() {

      // 驗證必填欄位
      $scope.productData.title ? $scope.initial.error.title = false : $scope.initial.error.title = true;
      $scope.productData.category != null || $scope.productData.category != undefined ? $scope.initial.error.category = false : $scope.initial.error.category = true;

      // 欄位驗證通過透過Ajax送出欄位資料
      if(!$scope.initial.error.title && !$scope.initial.error.category) {
        ngProgress.start();
        $jsonData.postData('POST', '/admin/article/', $scope.productData, function(data, status) {
          ngProgress.complete();
          $window.location = $window.location.pathname.match(/\/\w*/g).slice(0, 2).join("");
        }, function(data, status) {
          toastr.error('Oops! There is something wrong whit server');
          $log.warn(data, status);
          ngProgress.reset();
        });
      }
    },

    // 必填欄位驗證不通過後經過使用者回填時清除提示訊息
    clearError: function(event) {
      if($(event.target).closest('.form-group').hasClass('has-error') && $(event.target).val()) {
        $(event.target).closest('.form-group').removeClass('has-error');
        $scope.initial.error.title = false;
      } else if(!$(event.target).val()) {
        $scope.initial.error.title = true;
      }
    },

    addSpec: function(event) {
      if($scope.relationData.specs.length != $scope.productData.specs.length) {
        $scope.productData.specs.push({item: '', detail: null});
        if($scope.relationData.specs.length == $scope.productData.specs.length) {
          $scope.initial.addDisabled = true;
        }
      }
    },

    removeItem: function(index) {
      $scope.productData.specs.splice(index, 1);
      if($scope.relationData.specs.length != $scope.productData.specs.length) {
        $scope.initial.addDisabled = false;
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
        $scope.productData.img = fileUrl
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