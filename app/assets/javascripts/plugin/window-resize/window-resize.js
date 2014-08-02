!function ($) {
  "use strict";

  var now = new Date(),
      out = false,
      delta = 300,
      convertToFunction = function(fn){
        var x = new Function();
        x = fn;
        return x;
      };

  $.windowResize = function(fn) {
    if(typeof fn.start === 'function') {
      $.windowResize.start = convertToFunction(fn.start);
    }
    if(typeof fn.stop === 'function') {
      $.windowResize.stop = convertToFunction(fn.stop);
    }
    $(window).resize(function() {
      now = new Date();
      if(out === false) {
        if(typeof fn.start === 'function') {
          $.windowResize.start()
        }
        out = true;
        setTimeout(resizeend, delta);
      }
    });
    function resizeend() {
      if (new Date() - now < delta) {
        setTimeout(resizeend, delta);
      } else {
        out = false;
        if(typeof fn.stop === 'function') {
          $.windowResize.stop()
        }
      }
    }
  };
}(window.jQuery);