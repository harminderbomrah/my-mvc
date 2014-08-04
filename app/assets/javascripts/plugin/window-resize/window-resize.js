!function ($) {
  "use strict";

  var now = new Date(),
      out = false,
      delta = 300,
      fnArray = [],
      convertToFunction = function(fn){
        var x = new Function();
        x = fn;
        return x;
      };

  $.windowResize = function(fn) {
    fnArray.push(fn)
    for(var _index in fnArray) {
      if(typeof fnArray[_index].start === 'function') {
        $.windowResize.start[_index] = convertToFunction(fnArray[_index].start);
      }
      if(typeof fnArray[_index].stop === 'function') {
        $.windowResize.stop[_index] = convertToFunction(fnArray[_index].stop);
      }
    }
    window.onresize = function() {
      now = new Date();
      if(out === false) {
        if($.windowResize.start.length) {
          for(var _index in $.windowResize.start) {
            $.windowResize.start[_index]()
          }
        }
        out = true;
        setTimeout(resizeend, delta);
      }
    };
    function resizeend() {
      if (new Date() - now < delta) {
        setTimeout(resizeend, delta);
      } else {
        out = false;
        if($.windowResize.stop.length) {
          for(var _index in $.windowResize.stop) {
            $.windowResize.stop[_index]()
          }
        }
      }
    }
  };
  $.windowResize.start = [];
  $.windowResize.stop = [];
}(window.jQuery);