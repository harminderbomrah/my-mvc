'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', [])

// Main List controller
.controller('articleList', ['$scope', '$timeout', '$log', '$location', '$window', '$modal', '$jsonData', 'ngProgress', function($scope, $timeout, $log, $location, $window, $modal, $jsonData, ngProgress) {

  // get list json data use $jsonData services
  $jsonData.getData('/admin/article/list').then(function(data) {
    $scope.articleList = data;
    angular.forEach($scope.articleList, function(item, index) {
      $scope.articleList[index].date = new Date(item.date);
    });
  });

  // Definition main list controller scope initial
  $scope.initial = {
    publics: 0,       // 公開以及私密的參數
    trash: 0,         // 回收桶參數
    allChecked: false,    // 項目全選
    checkedEach: 0,       // checkbox 圖示參數
    currentPage: 1,       // 目前分頁
    maxSize: 10,          // 分頁最大顯示數目
    pageSize: 25,         // 每頁項目最大顯示數目
    selection: [],        // 已被勾選的項目陣列
    listLength: [],       // 每頁分頁狀態陣列(提供判斷選取框是否勾選用)
    orderName: "date",    // 預設的排序參數
    reverse: true,        // 預設的排序方向
    alerts: [],           // 提供action.alerts使用的陣列
    choseOptions: {       // Chose Options
      'allow_single_deselect': true,
      'width': '200px',
      'classes': 'chosen-sm'
    }
  };

  // 將資料庫來源的參數與 $scope.initial 合併
  $scope.extend = function(src) {
    angular.extend($scope.initial, src);
  };

  // 監看 $scope.initial.currentPage 當參數變動時會將先的參數回傳至網址列
  // 並且會將該頁的項目選取狀態存入$scope.initial.checkedEach , $scope.initial.allChecked 和 $scope.initial.listLength
  $scope.$watch('initial.currentPage', function(page_no) {
    $location.path("admin/article/" + String(page_no));
    var leng = page_no - 1
    if($scope.initial.listLength[leng]) {
      $scope.initial.checkedEach = $scope.initial.listLength[leng]
      $scope.initial.listLength[leng] > 1 ? $scope.initial.allChecked = false : $scope.initial.allChecked = true;
    } else {
      $scope.initial.checkedEach = $scope.initial.listLength[leng] = 0;
      $scope.initial.allChecked = false;
    }
  });

  // 監看 $scope.initial.category 如有值為 null 將會轉換為 undefined
  $scope.$watch('initial.category', function(category) {
    category == null ? $scope.initial.category = undefined : "";
  })

  // 監看瀏覽器網址列是否改變
  $scope.$on("$locationChangeSuccess", function(event, newUrl, oldUrl) {
    if(newUrl != oldUrl){
      var new_path = $window.location.pathname.split("/");
      new_path = new_path[new_path.length - 1];
      isNaN(new_path) ? $window.history.go(-1) : $scope.initial.currentPage = new_path
    }
  });

  $scope.action = {

    // 將被勾選的項目加入到 $scope.initial.selection 陣列中
    toggleSelection: function (id) {
      var idx = $scope.initial.selection.indexOf(id);
      idx > -1 ? $scope.initial.selection.splice(idx, 1) : $scope.initial.selection.push(id);
      // $log.log($scope.initial.selection.length)
    },

    // 勾選該頁全部項目
    checkAll: function (data) {
      angular.forEach(data, function(element) {
        if(!element.checked || !$scope.initial.allChecked) {
          $scope.action.toggleSelection(element.id);
        }
        element.checked = $scope.initial.allChecked;
      });
      var leng = $scope.initial.currentPage - 1
      if($scope.initial.allChecked) {
        $scope.initial.listLength[leng] = $scope.initial.checkedEach = 1;
      } else {
        $scope.initial.listLength[leng] = $scope.initial.checkedEach = 0;
      };
    },

    // 勾選單一項目
    checkSelected: function (index, id) {
      $scope.newList[index].checked != $scope.newList[index].checked;
      var listLength = 0,
          leng = $scope.initial.currentPage - 1

      // 建立已勾選項目的數量
      angular.forEach($scope.newList, function(element){
        element.checked ? listLength += 1 : "";
      });

      // 比對已勾選項目與整筆資料的長度
      // 如果相同 $scope.initial.checkedEach = 1
      // 如果小於整筆資料長度 $scope.initial.checkedEach = 2
      // 如果沒有資料 $scope.initial.checkedEach = 0
      if(listLength == $scope.newList.length) {
        $scope.initial.listLength[leng] = $scope.initial.checkedEach = 1;
        $scope.initial.allChecked = true;
      } else if(listLength > 0 && listLength < $scope.newList.length) {
        $scope.initial.listLength[leng] = $scope.initial.checkedEach = 2;
        $scope.initial.allChecked = false;
      } else {
        $scope.initial.listLength[leng] = $scope.initial.checkedEach = 0;
        $scope.initial.allChecked = false;
      };

      // 將被勾選項目的id傳送到 $scope.action.toggleSelection 處理
      $scope.action.toggleSelection($scope.newList[index].id);
    },

    // 取消選取並將先關參數還原以及修改物件項目的值
    deselect: function(undo) {
      angular.forEach($scope.initial.selection, function(element) {
        var mainElement = element;
        angular.forEach($scope.articleList, function(element, index) {
          if(mainElement == element.id) {
            if($scope.initial.trash) {
              undo ? element.checked = element.trash = false : $scope.articleList.splice(index, 1)
            } else {
              element.trash = true;
              element.checked = false;
            }
          }
        });
      });
      $scope.initial.currentPage = 1;
      $scope.initial.allChecked = false;
      $scope.initial.listLength = [];
      $scope.initial.checkedEach = 0;
      $scope.initial.selection = [];
    },

    // 將項目丟進垃圾桶,還原或刪除
    modal: function(undo, msg) {
      var trash = $scope.initial.trash,
          modalInstance;
      // 如果顯示狀態為回收桶而且不是點選還原，則會開啟 Modal 確認是否刪除項目
      if(trash && !undo) {
        modalInstance = $modal.open({
          templateUrl: '/modal/confirm',
          controller: ModalListCtrl,
          resolve: {
            msg: function () {
              return msg;
            }
          }
        });
        modalInstance.result.then(function() {
          $scope.action.itemAction(undo)
        });
      } else {
        $scope.action.itemAction(undo)
      };
    },

    // 按下 esc 時會清除文字搜尋框內的文字
    clearModelWhenEscape: function(_evt, _model) {
      var currKey = _evt.keyCode || _evt.which || _evt.charCode;
      if (currKey == 27) $scope[_model] = '';
      $scope.action.deselect();
    },

    // 排序文章
    sorting: function(element) {
      $scope.initial.orderName = element;
      $scope.initial.reverse = !$scope.initial.reverse;
    },

    // 項目動作 Alerts 的顯示內容 以及 將所選取的項目ID以及資料庫動作參數送回資料庫
    itemAction: function(undo) {
      var msg, type;
      if($scope.initial.trash) {
        if(undo) {
          type = "undo";
          msg = "Article is revert";
        } else {
          type = "delete";
          msg = "Article is delete";
        }
      } else {
        type = "trash";
        msg = "Article move to trash";
      }
      ngProgress.start();
      $jsonData.postData('POST', '/admin/article/delete', {action: type,ids: $scope.initial.selection}, function(data, status) {
        toastr.success(msg);
        $scope.action.deselect(undo);
        ngProgress.complete();
      }, function(data, status) {
        toastr.error('Oops! There is something wrong whit server');
        $log.warn('Article [', value ,'] is wrong');
        ngProgress.reset();
      });
    }
  };
}]);

var ModalListCtrl = function ($scope, $log, $modalInstance, msg) {
  $scope.msg = msg || "Your message has not been set";
  $scope.delete = function () {
    $modalInstance.close();
  };
  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}