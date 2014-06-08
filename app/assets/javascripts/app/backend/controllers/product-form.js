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
  var postPath = "create";
  var productID = "";

  if(path !== "new") {

    // 如果頁面為編輯則將後端資料與文章物件合併
    $scope.extend = function(src) {
      angular.extend($scope.productData, src);
    };

    postPath = "update";
    productID = path;
  }

  // 讀取關連物件的資料
  $jsonData.getData('/admin/product/get_relation_data').then(function(data) {
    $scope.relationData = data;
  });

  // Definition main form controller scope initial
  $scope.initial = {
    addDisabled: false
  }

  // chose js options
  $scope.choseOptions = {
    'width': '100%',
    'classes': 'chosen-sm'
  }

  $scope.action = {

    // 送出資料
    submit: function(form) {
      $log.log(form)
      // 驗證必填欄位

      if(form.$error.required.length) {
        angular.forEach(form.$error.required, function(element) {
          element.$pristine = false;
        });
      }

      // 欄位驗證通過透過Ajax送出欄位資料

      if(form.$valid) {
        ngProgress.start();

        if(postPath=='update') $scope.productData['id'] = productID;

        $jsonData.postData('POST', '/admin/product/'+postPath, $scope.productData, function(data, status) {
          ngProgress.complete();
          $window.location = $window.location.pathname.match(/\/\w*/g).slice(0, 2).join("");
        }, function(data, status) {
          toastr.error('Oops! There is something wrong whit server');
          $log.warn(data, status);
          ngProgress.reset();
        });
      }
    },

    addSpec: function(event) {
      $scope.productData.specs.push({item: '', detail: null});
      if($scope.relationData.specs.length == $scope.productData.specs.length) {
        $scope.initial.addDisabled = true;
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