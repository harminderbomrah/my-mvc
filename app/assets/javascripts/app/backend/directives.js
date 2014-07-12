'use strict';

/* Directives */


angular.module('nyfnApp.directives', [])
.directive('resizable', ['$rootScope', '$window', function($rootScope, $window) {
  return {
    link: function(scope, element, attrs) {
      // var options = scope.$eval(attrs.resizable) || {};
      scope.initializeWindowSize = function() {
        scope.windowHeight = $window.innerHeight;
        scope.windowWidth  = $window.innerWidth;
      };
      angular.element($window).bind("resize", function() {
        scope.initializeWindowSize();
        scope.$apply();
      });
      scope.initializeWindowSize();
    }
  }
}])
// .directive('bullseye', ['$log', function($log) {
//   return {
//     restrict: 'A',
//     template: '<img class="{{init.class}}" data-ng-src="{{init.imgsrc}}">',
//     link: function (scope, element, attrs) {
//       scope.init = {}
//       attrs.$observe('bullseye', function(value) {
//         angular.extend(scope.init = {}, scope.$eval(value));
//         var image = document.createElement("img");
//         image.src = scope.init.imgsrc;
//         // element.wrapInner(image);
//         image.onload = function() {
//           var scale = image.width/image.height;
//           $(image).css({
//             'position': 'absolute'
//           });
//           if(scale > 1 || scale == 1) {
//             $log.log(image.height, $(element).width(), image.width)
//             $(element).children('img').css({
//               'top': 0,
//               'left': '50%',
//               'width': 'auto',
//               'height': '100%',
//               'max-width': 'none',
//               'margin-left': image.width*($(element).height()/image.height)/-2
//             });
//           } else {
//             $log.log(image.width, $(element).height(), image.height)
//             $(element).children('img').css({
//               'top': '50%',
//               'left': 0,
//               'width': '100%',
//               'height': 'auto',
//               'max-height': 'none',
//               'margin-top': image.height*($(element).width()/image.width)/-2
//             });
//           }
//         }
//       });
//       element.css({
//         'position': 'relative',
//         'overflow': 'hidden'
//       });
//     }
//   };
  // return function(scope, element, attrs) {
  //   attrs.$observe('bullseye', function(value) {
  //     $log.log(scope.$eval(value))
  //     // element.css({
  //     //   'background-image': 'url(' + value + ')'
  //     // })
  //     // var image = document.createElement("img");
  //     // image.src = value
  //     // image.onload = function() {
  //     //   var scale = image.width/image.height
  //     //   if(scale > 1 || scale == 1) {
  //     //     $(image).css({
  //     //       'width': '100%',
  //     //       'height': 'auto'
  //     //     });
  //     //   } else {
  //     //     $(image).css({
  //     //       'width': 'auto',
  //     //       'height': '100%'
  //     //     });
  //     //   }
  //     // }
  //     // element.wrapInner(image);
  //   });
  // };
// }])
.directive('checkThumbnail', [function () {
  return {
    restrict: 'A',
    link: function (scope, element, attrs) {
      element.load(function() {
        element[0].naturalWidth > element[0].naturalHeight ? element.parent().addClass('landscape') : element.parent().addClass('problem');
      });
    }
  };
}])
.directive('ngThumb', ['$window', function($window) {
  var helper = {
    support: !!($window.FileReader && $window.CanvasRenderingContext2D),
    isFile: function(item) {
      return angular.isObject(item) && item instanceof $window.File;
    },
    isImage: function(file) {
      var type =  '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
      return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
    },
    isSpecialFile: function(file) {
      var type =  '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
      if('|doc|dot|docx|docm|dotx|dotm|'.indexOf(type) !== -1) {
        return helper.icon.doc
      } else if('|xls|xlt|xlm|xlsx|xlsm|xltx|xltm|xlsb|xla|xlam|xll|xlw|'.indexOf(type) !== -1) {
        return helper.icon.xls
      } else if('|ppt|pot|pot|pptx|pptm|potx|potm|ppam|ppsx|ppsm|sldx|sldm|'.indexOf(type) !== -1) {
        return helper.icon.ppt
      } else if('|pdf|'.indexOf(type) !== -1) {
        return helper.icon.pdf
      } else {
        return helper.icon.file
      }
      // return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
    },
    icon: {
      doc: "data:image/png;base64,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",
      pdf: "data:image/png;base64,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",
      ppt: "data:image/png;base64,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",
      xls: "data:image/png;base64,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",
      file: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGIAAACCCAYAAAC94R2MAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABJxJREFUeNrsnc9OE1EUhy8wTGc6DdNQCrVNa0mFyKLSJmwgJrpx784H0Adg6Ru49AXc69I1boiLdsv/LiAgEJS6EVOlFWjqPYOYhpTCtDNz77S/jzQkEAIz38w9v3PuNAw0Gg0GxDOIUwARACIgAkCE3CjtvlksFsL8U84XB6IoIVVV12dnc/t+FDFwU3zlEkjAMn+ZfjiQ4eFhZhih6tnZnxk/ymi3NPlGwhVDQ0N6IKDtrK2tvugJEfxueOo3Cf8PaHBQ4TLe+01GTxbrAY6m6R/W19feQYQE8DvjpV9k9Hx8JRmbm5s7ECFHosqQjNXVlfsQIYEMVQ2UZJXRV501xdtLGauPIUICGZqmfZYt3vblrIni7WWvsfYGIqToNbTXssTbvp++Urzd2FhfhggJ4AX8ieheAyKa4u3W1tYPUfEWIppQFCUsqteAiBbxVsQoHSJanRQBo3SIuKXX8CreQsTtMjwZpUPEHXsNt+MtRNiIt27KgAibMkql0qkb8RYiOoi3bozSIaJDGU6P0iGiy3jLZSxChAQyNE1/60S8hQiH4m23o3SIcIhuR+kQ4Xyv8a2TeAsRzsuIdTJKhwiX4q3dUTpEuITdUbri5C8/OTlh52fnQg48GAyykRG53knQNEp/ls0+euWpiNPfp0IO2gyHWUrexo9G6aydDCxNHvYa7eItRHgfb3dcX5pEUq/XraXRB2QKhUJ1YWFB70kRvyoV9mlpiZXLZW9rk2myEdN2SNC4iN5dmmKxGEun05Tj/Rd3e20dpit0enqaaboOEaJRVZU9yGTY6Oiob/5mR2tEmGd5I2hItVQd85pxeHDgXizVAnKKkI3oeJSlUklWKpXYxUUdS5PoujE3N8cMIwgRwtdgRWH5fJ5NTIxDhAxMTU1ZL0UZggjR0F2RzWZZIKBChGgMw7CWKtMcgQgZ6gbdGYlEvLf6CJEbQ90QMkJsPBple3t71vDQbh8RCGjyiRC1MeQEY2Nj7ODwkNWq1btHY/7hhAjsRzSh67o1GjFN77dcIeIaNLmlCW48HocIGYjympHhd4dXI3WIaFfEQyHPRuoQcQtejdQh4o51I5lMWi+IkAC6K2ipcqNu9PTGkFskEgm2vb3NKpUKNoZEE7sXszrxo6OvWJpEMzk56dhIHSK65Gqk3u3uH0Q4AI3USUYkMgoRoqGR+szMjPWgAkRIQCqV4kIe2q4bEOECkUiE5XI5W3XD0fh6fHzMarVaX510iuytYrumaVbdoIhbLn/3VgRJ8PPGUEeFuk0DS3WD4i0V893dPSxNoqG9jXw+17ZuQISHEbfd04YQ4XHEpUd4Wj01AhECoNEIREgKREAEcK2PoHfo2H1Szu/QnrZ0IqibBFiaIAJABEQAiIAI4JM+AhtDkojAxhCWJtQIABEQASACIgBEoKGzCzaGJBGBjSEsTRABIAIiAERABIAIiAAQAREAIiACQASACIgAEAERACIgAkAERACHRazw10+cHtfYv5OI+fkF+sfQizhfrkAX+PPrXxxoNBo3/kSxWEj/+6Ewzp8j0AX+kV/oX2yJACjWEAEgoq/5K8AA6GZFd5dsyg8AAAAASUVORK5CYII="
    }
  };

  return {
    restrict: 'A',
    template: '<canvas/>',
    link: function(scope, element, attributes) {
      if (!helper.support) return;

      var params = scope.$eval(attributes.ngThumb);

      if (!helper.isFile(params.file)) return;
      // if (!helper.isImage(params.file)) return;

      var canvas = element.find('canvas');
      var reader = new FileReader();

      reader.onload = onLoadFile;
      reader.readAsDataURL(params.file);

      function onLoadFile(event) {
        // console.log(event.target.result)
        var img = new Image();
        img.onload = onLoadImage;
        if(helper.isImage(params.file)) {
          img.src = event.target.result;
        } else {
          img.src = helper.isSpecialFile(params.file);
          // console.log(helper.isSpecialFile(params.file))
        }
      }

      function onLoadImage() {
        var width = params.width || this.width / this.height * params.height;
        var height = params.height || this.height / this.width * params.width;
        canvas.attr({ width: width, height: height });
        canvas[0].getContext('2d').drawImage(this, 0, 0, width, height);
      }
    }
  };
}])
.directive('appVersion', ['version', function(version) {
  return function(scope, element, attrs) {
    console.log(scope, element, attrs)
    element.text(version);
  };
}]);