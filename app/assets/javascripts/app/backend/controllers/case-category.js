'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', [])

// Main Category controller
.controller('caseCategory', ['$scope', '$log', '$timeout', '$modal', '$jsonData', 'ngProgress', function($scope, $log, $timeout, $modal, $jsonData, ngProgress) {

  // Definition main category controller scope initial
  $scope.initial = {
    edited: null,
    id: null,
    buffer: false
  };

  $scope.action = {

    // 新增類別
    new: function(value, event) {

      // 首先判斷值是否存在以及判斷送出時是點選按鈕或是按下enter
      if((value && event.type == "click") || (value && event.keyCode == 13)) {

        // buffer icon 顯示
        $scope.initial.buffer = true;

        // 檢查送出的值是否有與原始的資料重複
        var exists = null;
        exists = $scope.category.filter(function(obj) {
          return value == obj.name;
        })[0]

        if(exists == undefined) {

          // 如果送出的值沒有重複則將資料送出
          ngProgress.start();
          $jsonData.postData('POST', '/admin/case/category/new', {action: 'add', value: value}, function(data, status) {
            //需要取得新增後的ID值
            toastr.success('Category has been added');
            $scope.initial.buffer = false;
            $scope.category.push({id: data['id'], name: value, quantity: 0})
            $scope.newCategory = null;
            ngProgress.complete();
          }, function(data, status) {
            toastr.error('Category not saved');
            $scope.initial.buffer = false;
            ngProgress.reset();
          });
        } else {

          // 如果送出的值有重複則顯示錯誤訊息
          toastr.warning('Category already exists');
          $scope.initial.buffer = false;
        }
      }
    },

    // 編輯類別
    edit: function(value, index, event) {

      // 先將原始資料存起來
      $scope.initial.edited = value;

      // 設定該物件為編輯中
      $scope.category[index].edited = true;

      // 將該物件的id值傳入 $scope.initial.id
      $scope.initial.id = $scope.category[index].id;

      // focus input
      $timeout(function () {
        $(event.target).closest('.list-item').children('.edit').focus();
      }, 0);
    },

    // 完成編輯
    doneEditing: function(value, index) {
      if($scope.initial.edited != value) {

        // 如果原始資料與更改後的資料不相同則將資料送出
        ngProgress.start();
        $jsonData.postData('POST', '/admin/case/category/edit', {action: 'update', id: $scope.initial.id, value: value}, function(data, status) {
          toastr.success('Category updated');
          $scope.initial.edited = null;
          ngProgress.complete();
        }, function(data, status) {
          toastr.error('Category not saved');
          $scope.category[index].name = $scope.initial.edited;
          $scope.initial.edited = null;
          ngProgress.reset();
        });
      } else {

        // 如果相同則將 $scope.initial.edited 設定成 null
        $scope.initial.edited = null;
      }

      // 將該物件的選取狀態取消
      $scope.category[index].edited = false;
    },

    // 判斷鍵盤動作
    doneEditingWithKey: function(_evt, value, index) {
      var currKey = _evt.keyCode || _evt.which || _evt.charCode;
      if (currKey == 13) {

        // 按下 enter 則會將選取狀態取消
        _evt.target.blur();
        $scope.action.doneEditing(value, index);
      } else if(currKey == 27) {

        // 按下 esc 則會將選取狀態取消並將原始資料回存
        _evt.target.blur();
        $scope.category[index].name = $scope.initial.edited;
        $scope.category[index].edited = false;
      }
    },

    // 移除類別
    remove: function(item, index) {
      var modalInstance = $modal.open({
        templateUrl: '/modal/category',
        controller: ModalCategoryCtrl,
        resolve: {
          msg: function () {
            return item.quantity > 0 ? "There are items in this category, You have to transfer them to another category" : "Are you sure you want to delete?";
          },
          replace: function() {
            return item.quantity > 0
          },
          categorys: function() {
            var newCategory = [];
            angular.forEach($scope.category, function(value, idx) {
              if(idx != index) {
                newCategory.push(value);
              }
            });
            return newCategory
          }
        }
      });
      modalInstance.result.then(function(replaceID) {
        var data = {};
        if(replaceID != undefined) {
          data.action = 'replace';
          data.newID = replaceID;
          data.oldID = item.id;
        } else {
          data.action = 'delete';
          data.id = item.id;
        }
        ngProgress.start();
        $jsonData.postData('POST', '/admin/case/category/delete', data, function(data, status) {
          if(replaceID != undefined) {
            var target = $scope.category.indexOf($scope.category.filter(function(category, index) {
              return category.id == replaceID;
            })[0]);
            $scope.category[target].quantity = $scope.category[target].quantity + $scope.category[index].quantity
          }
          $scope.category.splice(index, 1);
          toastr.success('Category is deleted');
          ngProgress.complete();
        }, function(data, status) {
          toastr.error('Category not be deleted');
          ngProgress.reset();
        });
      });
    },

    // 按下 esc 時會清除文字搜尋框內的文字
    clearModelWhenEscape: function(_evt, _model) {
      var currKey = _evt.keyCode || _evt.which || _evt.charCode;
      if (currKey == 27) $scope[_model] = '';
    }
  }
}]);

var ModalCategoryCtrl = function ($scope, $log, $modalInstance, msg, replace, categorys) {
  $scope.config = {
    categorys: categorys,
    category: null,
    replace: replace,
    error: false,
    msg: msg || "Your message has not been set"
  }
  $scope.delete = function () {
    if($scope.config.replace) {
      if($scope.config.category == null) {
        $scope.config.error = true;
      } else {
        $modalInstance.close($scope.config.category);
      }
    } else {
      $modalInstance.close();
    }
  };
  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}