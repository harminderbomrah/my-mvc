'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', ['ui.sortable'])

// Main Category controller
.controller('articleCategory', ['$scope', '$log', '$timeout', '$modal', '$jsonData', 'ngProgress', function($scope, $log, $timeout, $modal, $jsonData, ngProgress) {

  // Definition main category controller scope initial
  $scope.id = null;
  $scope.action = {

    // 建立類別
    modify: function(type, name, description, index) {
      var id
      index >= 0 ? id = $scope.category[index].id : id = null;
      var modalInstance = $modal.open({
        templateUrl: '/modal/modify-category',
        controller: modifyCategory,
        resolve: {
          config: function() {
            return {
              type: type,
              data: {
                name: name || null,
                description: description || null
              },
              categorys: (function() {
                if(type === 'new') {
                  return $scope.category
                } else {
                  var newCategory = [];
                  angular.forEach($scope.category, function(value, idx) {
                    if(idx != index) {
                      newCategory.push(value);
                    }
                  });
                  return newCategory
                }
              })()
            }
          }
        }
      });
      modalInstance.result.then(function(value) {
        var data = (function() {
          if(type === 'new') {
            return {action: 'add', name: value.name, description: value.description}
          } else {
            return {action: 'update', id: id, name: value.name, description: value.description}
          }
        })()
        ngProgress.start();
        $jsonData.postData('POST', '/admin/article/category/' + type, data, function(data, status) {
          if(type === 'new') {
            toastr.success('類別已新增');
            $scope.category.push({id: data['id'], name: value.name, description: value.description, quantity: 0});
          } else {
            toastr.success('類別已更新');
            $scope.category[index].name = value.name;
            $scope.category[index].description = value.description;
          }
          ngProgress.complete();
        }, function(data, status) {
          toastr.error('類別未儲存');
          ngProgress.reset();
        });
      });
    },

    // 移除類別
    remove: function(item, index) {
      var modalInstance = $modal.open({
        templateUrl: '/modal/delete-category',
        controller: deleteCategory,
        resolve: {
          msg: function () {
            return item.quantity > 0 ? "此類別中已有項目，你必須轉移到其他類別中" : "你確定真的要刪除嗎？";
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
        $jsonData.postData('POST', '/admin/article/category/delete', data, function(data, status) {
          if(replaceID != undefined) {
            var target = $scope.category.indexOf($scope.category.filter(function(category, index) {
              return category.id == replaceID;
            })[0]);
            $scope.category[target].quantity = $scope.category[target].quantity + $scope.category[index].quantity
          }
          $scope.category.splice(index, 1);
          toastr.success('類別已被刪除');
          ngProgress.complete();
        }, function(data, status) {
          toastr.error('類別未被刪除');
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

  $scope.sortableOptions = {
    update: function(e, ui) {
      var logEntry = []
      $scope.category.map(function(item) {
        logEntry.push(item.id);
      });
      // console.log(logEntry);
    }
  };
}]);

var modifyCategory = function ($scope, $log, $modalInstance, config) {
  $scope.data = {};
  angular.extend($scope.data, config.data);
  $scope.error = false;
  $scope.length = false;
  $scope.msg = '';
  $scope.buttonText = '';
  config.type === 'new' ? $scope.buttonText = '建立' : $scope.buttonText = '確認';
  $scope.checkValue = function(name) {
    var exists = null,
        _regex = new RegExp(name, 'i');

    exists = config.categorys.filter(function(obj) {
      if(_regex.test(obj.name) && obj.name.length === name.length) {
        return true;
      }
    })[0]
    if(exists) {
      $scope.error = true;
      $scope.msg = '類別名稱重複';
    } else {
      $scope.error = false;
    }
  }
  $scope.create = function() {
    if(!$scope.data.name) {
      $scope.length = true;
      $scope.msg = '類別名稱不得為空白';
    } else {
      if(!$scope.error) {
        $modalInstance.close($scope.data);
      }
    }
  };
  $scope.cancel = function() {
    $modalInstance.dismiss('cancel');
  };
}

var deleteCategory = function ($scope, $log, $modalInstance, msg, replace, categorys) {
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