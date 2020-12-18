/* ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
优化页面滚动事件，在$(window).on('scroll')滚动事件中添加事件用orz.scroll包裹
示例:
(function($){
  var go=orz.scroll(function (e) {
    var st=window.pageYOffset
    			|| document.documentElement.scrollTop
    			|| document.body.scrollTop
    			|| 0;
    orz.log(st);
  });
  $(window).on('scroll',go);
})(jQuery);
---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=* */
(function($){
  orz.scroll=function (fn) {
    var scrolling=false;
    return function (e) {
      if (!scrolling) {
        window.requestAnimationFrame(function (e){
          fn.call(e);
          scrolling=false;
        });
        scrolling=true;
      }
    };
  };
})(jQuery);
