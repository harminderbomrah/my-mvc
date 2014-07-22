'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('nyfnApp.services', [])

//Definition system version
.value('version', '0.1')

// Definition get json data factory
.factory('$jsonData', ['$http', '$q', function($http, $q) {
  return {
    getData: function(URL) {
      var deferred = $q.defer();
      $http.get(URL).then(function (result) {
        deferred.resolve(result.data);
      });
      return deferred.promise;
    },
    postData: function($method, $url, $data, $successFn, $errorFn) {
      $http({
        method: $method,
        url: $url,
        data: $.param($data),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      })
      .success(function(data, status) {
        $successFn(data, status);
      })
      .error(function(data, status) {
        $errorFn(data, status);
      });
    }
  };
}])
.factory('$myCookie', [function () {
  return {
    set: function(name, value, days) {
      var expires = "",
          url = "";
      if(days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 86400000));
        expires = "" + date.toGMTString()
      }
      document.cookie = name + '=' + value + '; expires=' + expires + '; path=/';
      return value;
    },
    get: function(name) {
      var value,
          cookie = document.cookie.split('; ');
      angular.forEach(cookie, function(item, index) {
        if(item.search(name) == 0) {
          value = item.split('=')[1]
        }
      });
      return value;
    },
    destroy: function(name) {
      this.set(name, "", -1)
      // if(document.cookie.indexOf(name) !== -1) {
      //   document.cookie = name + '=; expires=-1; path='
      // }
    }
  };
}])
.factory('pagination', [function() {
  return {

  };
}]);