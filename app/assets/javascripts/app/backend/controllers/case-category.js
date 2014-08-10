'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', [])

// Main Category controller
.controller('caseCategory', ['$scope', '$log', '$timeout', '$modal', '$jsonData', 'ngProgress', function($scope, $log, $timeout, $modal, $jsonData, ngProgress) {

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
        $jsonData.postData('POST', '/admin/case/category/' + type, data, function(data, status) {
          if(type === 'new') {
            toastr.success('Category has been added');
            $scope.category.push({id: data['id'], name: value.name, description: value.description, quantity: 0});
          } else {
            toastr.success('Category updated');
            $scope.category[index].name = value.name;
            $scope.category[index].description = value.description;
          }
          ngProgress.complete();
        }, function(data, status) {
          toastr.error('Category not saved');
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

var modifyCategory = function ($scope, $log, $modalInstance, config) {
  $scope.data = {};
  angular.extend($scope.data, config.data);
  $scope.error = false;
  $scope.length = false;
  $scope.msg = '';
  $scope.buttonText = '';
  config.type === 'new' ? $scope.buttonText = 'Create' : $scope.buttonText = 'OK';
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