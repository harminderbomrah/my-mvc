'use strict';

/* Controllers */

angular.module('nyfnApp.controller.main', [])

// Main Form controller
.controller('siteSettingForm', ['$scope', '$log', '$jsonData', 'ngProgress', function($scope, $log, $jsonData, ngProgress) {
  $scope.siteInfo = {};
  $scope.psw = {};
  $scope.confirm = [false, false];
  $scope.pswSubmit = true;
  $scope.extend = function(src) {
    angular.extend($scope.siteInfo, src);
  };
  $scope.setSubmit = function(form) {
    if(form.$error.required.length) {
      angular.forEach(form.$error.required, function(element) {
        element.$pristine = false;
      });
    }

    if(form.$valid) {
      ngProgress.start();

      $jsonData.postData('POST', '/admin/setting/update', $scope.siteInfo, function(data, status) {
        ngProgress.complete();
        toastr.success("網站資訊已更新");
      }, function(data, status) {
        toastr.error('Oops! There is something wrong whit server');
        $log.warn(data, status);
        ngProgress.reset();
      });
    }
  }
  $scope.checkPassword = function(value, type) {
    if(type == "old") {
      if(value.oldPassword.$dirty) {
        $jsonData.postData('POST', '/admin/setting/checkpassword', {password: $scope.psw.old}, function(data, status) {
          if(data.success) {
            $scope.pswold = ['has-success', 'glyphicon-ok'];
            $scope.confirm[0] = true;
            $scope.oldmsg = null;
          }else{
            $scope.pswold = ['has-warning', 'glyphicon-warning-sign'];
            $scope.confirm[0] = false;
            $scope.oldmsg = "密碼錯誤";
          }
        }, function(data, status) {
          toastr.error('Oops! There is something wrong whit server');
          $log.warn(data, status);
        });
      }
    }
    if(type == "new") {
      if(value.newPassword.$dirty) {
        if(value.newPassword.$modelValue.length > 7) {
          if(value.confirmPassword.$modelValue) {
            if(value.confirmPassword.$modelValue == value.newPassword.$modelValue) {
              $scope.pswnew = $scope.pswconf = ['has-success', 'glyphicon-ok'];
              $scope.confirm[1] = true;
              $scope.newmsg = null;
            } else {
              $scope.pswnew = $scope.pswconf = ['has-error', 'glyphicon-remove'];
              $scope.confirm[1] = false;
              $scope.newmsg = '密碼有誤請確認';
            }
          } else {
            $scope.pswnew = ['', '']
            $scope.confirm[1] = false;
            $scope.newmsg = null;
          }
        } else {
          $scope.pswnew = ['has-error', 'glyphicon-remove', false]
          $scope.confirm[1] = false;
          $scope.newmsg = '密碼請勿少於8位';
        }
      }
    }
    if(type == "conf") {
      if(value.confirmPassword.$dirty) {
        if(value.confirmPassword.$modelValue.length > 7) {
          if(value.newPassword.$modelValue) {
            if(value.confirmPassword.$modelValue == value.newPassword.$modelValue) {
              $scope.pswnew = $scope.pswconf = ['has-success', 'glyphicon-ok'];
              $scope.confirm[1] = true;
              $scope.confmsg = null;
            } else {
              $scope.pswnew = $scope.pswconf = ['has-error', 'glyphicon-remove'];
              $scope.confirm[1] = false;
              $scope.confmsg = '密碼有誤請確認';
            }
          } else {
            $scope.pswconf = ['has-warning', 'glyphicon-warning-sign']
            $scope.confirm[1] = false;
            $scope.confmsg = null;
          }
        } else {
          $scope.pswconf = ['has-error', 'glyphicon-remove']
          $scope.confirm[1] = false;
          $scope.confmsg = '密碼請勿少於8位';
        }
      }
    }
    if($scope.confirm[0] && $scope.confirm[1]) {
      $scope.pswSubmit = false;
      $scope.newmsg = $scope.confmsg =null;
    } else {
      $scope.pswSubmit = true;
    }
  }
  $scope.passwordSubmit = function(form) {
    ngProgress.start();

    $jsonData.postData('POST', '/admin/setting/changepassword', $scope.psw.new, function(data, status) {
      ngProgress.complete();
      toastr.success("密碼已更新");
    }, function(data, status) {
      toastr.error('Oops! There is something wrong whit server');
      $log.warn(data, status);
      ngProgress.reset();
    });
  }
}]);