'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', [])

// Main List controller
.controller('articleList', ['$scope', '$timeout', '$log', '$location', '$window', '$modal', '$jsonData', 'ngProgress', function($scope, $timeout, $log, $location, $window, $modal, $jsonData, ngProgress) {

  // get list json data use $jsonData services
  $jsonData.getData('/public/article-for-list.json').then(function(data) {
    $scope.articleList = data;
  });

  // Definition main list controller scope initial
  $scope.initial = {
    publics: false,       // 公開以及私密的參數
    trash: false,         // 回收桶參數
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
          templateUrl: 'confirmModal.html',
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
      $jsonData.postData('POST', '/admin/article/', {action: type, id: $scope.initial.selection}, function(data, status) {
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
}])
// Main Form controller
.controller('articleForm', ['$scope', '$log', '$window', '$location', '$jsonData', 'ngProgress', function($scope, $log, $window, $location, $jsonData, ngProgress) {

  // 建立空的文章物件
  $scope.articleData = {};

  // 檢查頁面是新增或是編輯
  var path = $window.location.pathname.split("/");
      path = path[path.length - 1];
  if(path !== "new") {

    // 如果頁面為編輯則將後端資料與文章物件合併
    $scope.extend = function(src) {
      angular.extend($scope.articleData, src);
    };

    // 並監看文章物件裡的日期屬性，如果有值則將 $scope.initial.publishDate 設定為 true
    $scope.$watch('articleData.date', function(date) {
      date ? $scope.initial.publishDate = true : null
    });
  }

  // 讀取關連物件的資料
  $jsonData.getData('/public/relation-data.json').then(function(data) {
    $scope.relationData = data;
  });

  // Definition main form controller scope initial
  $scope.initial = {
    today: new Date(),
    toggleVel: {
      bl: false,
      srt: "Add New"
    },
    publishDate: false,
    link: {
      url: null,
      text: null
    },
    error: {
      title: false,
      category: false
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
      $scope.articleData.category = null;
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
      $scope.articleData.title ? $scope.initial.error.title = false : $scope.initial.error.title = true;
      $scope.articleData.category != null || $scope.articleData.category != undefined ? $scope.initial.error.category = false : $scope.initial.error.category = true;

      // 欄位驗證通過透過Ajax送出欄位資料
      if(!$scope.initial.error.title && !$scope.initial.error.category) {
        ngProgress.start();
        $jsonData.postData('POST', '/admin/article/', $scope.articleData, function(data, status) {
          ngProgress.complete();
          $window.location = $window.location.pathname.match(/\/\w*/g).slice(0, -1).join("");
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
      open: function($event) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened = true;
      },

      // 清除以設定的日期
      clear: function (value) {
        value && $scope.articleData ? $scope.articleData.date = null : null;
      }
    }
  }
}])

.controller('articleCategory', ['$scope', '$log', '$timeout', '$modal', '$jsonData', 'ngProgress', function($scope, $log, $timeout, $modal, $jsonData, ngProgress) {

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
          $jsonData.postData('POST', '/admin/article/', {action: 'add', value: value}, function(data, status) {
            //需要取得新增後的ID值
            toastr.success('Category has been added');
            $scope.initial.buffer = false;
            $scope.category.push({id: 124521, name: value, quantity: 0})
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
        $jsonData.postData('POST', '/admin/article/', {action: 'update', id: $scope.initial.id, value: value}, function(data, status) {
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
        $scope.category[index].name = $scope.initial.edited;
        $scope.category[index].edited = false;
      }
    },

    // 移除類別
    remove: function(item, index) {
      var modalInstance = $modal.open({
        templateUrl: 'confirmModal.html',
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
        $jsonData.postData('POST', '/admin/article/', data, function(data, status) {
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

var ModalListCtrl = function ($scope, $log, $modalInstance, msg) {
  $scope.msg = msg || "Your message has not been set";
  $scope.delete = function () {
    $modalInstance.close();
  };
  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}

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