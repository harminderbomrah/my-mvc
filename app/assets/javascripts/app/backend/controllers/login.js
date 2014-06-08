'use strict';

/* Controllers */

var flickrAPI = angular.module('flickrAPI', [
  'nyfnApp.services'
])

// login controller
.controller('login', ['$scope', '$timeout', '$log', '$jsonData', function($scope, $timeout, $log, $jsonData) {

  var apiKey = 'd8deddbbc005b57a17af6ce86a251b5b',
      photoSetId = '72157644576955310',
      url = 'https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' + apiKey + '&photoset_id=' + photoSetId +'&media=photos&format=json&nojsoncallback=1';

  $scope.photo = {
    ownername: null,
    backgroundImg: null
  };

  $jsonData.getData(url).then(function(data) {
    $log.log(data)
    var number = Math.floor(Math.random() * data.photoset.photo.length),
        photoId = data.photoset.photo[number].id;

    $scope.photo.ownername = data.photoset.ownername;

    $jsonData.getData('https://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=' + apiKey + '&photo_id=' + photoId + '&format=json&nojsoncallback=1').then(function(data) {
      var source = data.sizes.size.filter(function(index) {
        return index.label == 'Original';
      })[0].source;
      (function(source){
        $scope.photo.backgroundImg = function() {
          return {'background-image': 'url('+source+')'}
        }
      }(source));
    });
  });
}])

// password resets controller
.controller('resets', ['$scope', '$timeout', '$log', '$jsonData', '$window', function($scope, $timeout, $log, $jsonData, $window) {
  var emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
  $scope.feedback = {
    msg: null,
    show: 0
  };
  $scope.psw = {
    A: null,
    B: null
  }
  $scope.submitEmail = function() {
    if(!$scope.email) {
      $scope.feedback.msg = 'Please enter the E-mail';
      $scope.feedback.show = 1;
    } else {
      var regexResult = $scope.email.search(emailRule)
      if(regexResult == 0) {
        $scope.feedback.msg = null;
        $scope.feedback.show = 0;
        $jsonData.postData('POST', '/admin/article/', {email: $scope.email}, function(data, status) {
          $window.location = '/user/success';
        }, function(data, status) {
          $log.log(data)
        });
      } else {
        $scope.feedback.msg = 'E-mail format error';
        $scope.feedback.show = 2;
      }
    }
  }
  $scope.submitPassword = function() {
    if(!$scope.psw.A && !$scope.psw.B) {
      $scope.feedback.msg = 'Please enter the Password';
      $scope.feedback.show = 1;
    } else if($scope.psw.A.length < 8) {
      $scope.feedback.msg = 'Minimum 8 characters';
      $scope.feedback.show = 1;
    } else if($scope.psw.A == $scope.psw.B) {
      $scope.feedback.msg = null;
      $scope.feedback.show = 0;
      $jsonData.postData('POST', '/admin/article/', {password: $scope.psw.A}, function(data, status) {
        $window.location = '/user/success';
      }, function(data, status) {
        $log.log(data)
      });
    } else {
      $scope.feedback.msg = 'Make sure the password is the same';
      $scope.feedback.show = 2;
    }
  }
}]);