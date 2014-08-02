var slide = function(element) {
  // jQuery.easing.def = "easeOutExpo";
  this.element = $(element);
  this.setHeight = function(options) {
    // this.minHeight = options.minHeight || 0;
    // this.maxHeight = options.maxHeight || window.innerHeight;
    // this.emptySpace = options.emptySpace || 0;
    // var _elementHeight = Math.round((window.innerWidth - this.emptySpace) / 1.618);
    // if(_elementHeight < this.minHeight) {
    //   _elementHeight = this.minHeight;
    // } else if(_elementHeight > this.maxHeight) {
    //   _elementHeight = this.maxHeight;
    // };
    // this.element.animate({
    //   height: _elementHeight
    // }, 500);
    var _elementHeight = options || Math.round((window.innerHeight * 0.7));
    this.element.height(_elementHeight)
  };
  this.slide = function(element) {
    var now = 0,
        $el = $(element),
        _length = $el.length - 1;
    $el.eq(now).addClass('active');
    setInterval(function() {
      $el.eq(now).addClass('out');
      now == _length ? $el.eq(now - _length).addClass('in') : $el.eq(now + 1).addClass('in');
      var timeout = setTimeout(function() {
        $el.eq(now).removeClass('out active');
        now == _length ? $el.eq(now - _length).removeClass('in').addClass('active') : $el.eq(now + 1).removeClass('in').addClass('active');
        now == _length ? now = 0 : now ++;
        clearTimeout(timeout)
      }, 2000);
    }, 6000);
  }
};
var homeSlide;
homeSlide = new slide('#slide');
jQuery(document).ready(function($) {
  "use strict";
  homeSlide.setHeight((function() {
    if($('footer').height() > Math.round(window.innerHeight * 0.4)) {
      return Math.round(window.innerHeight * 0.8);
    } else {
      return Math.round((window.innerHeight * 0.7) - $('footer').height());
    };
  })());
  homeSlide.slide('.slide-item');
});