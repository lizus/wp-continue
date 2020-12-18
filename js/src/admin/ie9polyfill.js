/* ---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=*
IE9补丁
---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=* */
(function(){
  window.requestAnimationFrame = (function(){
    return  window.requestAnimationFrame       ||
    window.webkitRequestAnimationFrame ||
    window.mozRequestAnimationFrame    ||
    function( callback ){
      window.setTimeout(callback, 1000 / 60);
    };
  })();
  window.cancelAnimationFrame=window.cancelAnimationFrame ||
	Window.webkitCancelAnimationFrame ||
	window.mozCancelAnimationFrame ||
	window.msCancelAnimationFrame ||
	window.oCancelAnimationFrame ||
	function( id ){
		window.clearTimeout( id );
	};
})();
