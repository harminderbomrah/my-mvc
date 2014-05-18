'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('nyfnApp.services', [])

//Definition system version
.value('version', '0.1')

// Definition get json data factory
.factory('$jsonData', function($http, $q) {
  return {
    getData: function(URL) {
      var deferred = $q.defer();
      $http.get(URL).then(function (result) {
        deferred.resolve(result.data);
      });
      return deferred.promise;
    },
    postData: function($method, $url, $data, $successFn, $errorFn) {
      $http({method: $method, url: $url, data: $data})
      .success(function(data, status) {
        $successFn(data, status);
      })
      .error(function(data, status) {
        $errorFn(data, status);
      });
    }
  };
})
.factory('pagination', [function() {
  return {

  };
}]);