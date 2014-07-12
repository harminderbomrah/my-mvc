'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', ['nyfnApp.controller.fileManage'])

.controller('productForm', ['$scope', '$log', '$window', '$location', '$modal', '$jsonData', 'ngProgress', function($scope, $log, $window, $location, $modal, $jsonData, ngProgress) {

  // 建立空的文章物件
  $scope.productData = {
    img: [],
    specs: {
      countryOfOrigin: null,
      waterAbsorption: 0,
      durability: 0,
      evaluate: 0
    }
  };
  // Definition main form controller scope initial
  $scope.initial = {
    preview: [],
    submit: false,
    addDisabled: false
  }

  // 檢查頁面是新增或是編輯
  var path = $window.location.pathname.split("/");
      path = path[path.length - 1];
  var postPath = "create";
  var productID = "";

  if(path !== "new") {

    // 如果頁面為編輯則將後端資料與文章物件合併
    $scope.extend = function(src) {
      angular.extend($scope.productData, src);
      $scope.initial.id = $scope.productData.img
      $scope.initial.preview = $scope.productData.preview;
    };

    postPath = "update";
    productID = path;
  }


  // 讀取關連物件的資料
  $jsonData.getData('/admin/product/get_relation_data').then(function(data) {
    $scope.relationData = data;
  });

  // chose js options
  $scope.choseOptions = {
    'width': '100%',
    'classes': 'chosen-sm'
  }

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
        $scope.initial.submit = true;

        postPath=='update' ? $scope.productData['id'] = articleID : null;

        $jsonData.postData('POST', '/admin/product/'+postPath, $scope.productData, function(data, status) {
          ngProgress.complete();
          // $window.location = '/admin/product/';
        }, function(data, status) {
          toastr.error('Oops! There is something wrong whit server');
          $log.warn(data, status);
          $scope.initial.submit = false;
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

    clearImg: function() {
      $scope.productData.img = [];
      $scope.initial.preview = [];
    },

    regroup: function(value, col) {
      var set = [];
      angular.forEach(value, function(element, index) {
        if(index % col == 0) {
          set.push([]);
        };
        set[set.length-1].push(element);
      });
      return set
    },

    fileUpLoad: function() {
      var fileManageModal = $modal.open({
        templateUrl: '/modal/filemanage',
        controller: FileManage,
        windowClass: 'file-manage',
        resolve: {
          initial: function () {
            return {
              multiple: true,
              tabSelect: "folder",
              sourceId: (function() {
                var array = []
                angular.forEach($scope.productData.img, function(element) {
                  array.push(element)
                });
                return array;
              })(),
              originalImgId: (function() {
                var array = []
                angular.forEach($scope.productData.img, function(element) {
                  array.push(element)
                });
                return array;
              })(),
              preview: (function() {
                var array = []
                angular.forEach($scope.initial.preview, function(element) {
                  array.push(element)
                });
                return array;
              })(),
              clearImg: $scope.action.clearImg
            };
          }
        }
      });
      fileManageModal.result.then(function(fileData) {
        $scope.productData.img = fileData.id
        $scope.initial.preview = fileData.source
        $scope.previewGroup = $scope.action.regroup($scope.initial.preview, 3);
        $log.log($scope.previewGroup)
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
