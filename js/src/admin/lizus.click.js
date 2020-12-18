/** ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
 * @Name jQuery点击事件函数式Curry化
 * @Author lizus.com
 * @Updated 20190512
 * @Description
 使用Curry组织jQuery的DOM点击事件
 *
 * @param fn 点击事件的处理函数或函数数组
 * @param tag 点击事件的dom对像查询字符串
 *
 * @Return null
 *
---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=* */
(function($){
  orz.click=orz.curry(function (fn,tag){
    if (orz.isArray(fn)) {
      for (var i = 0; i < fn.length; i++) {
        if(orz.isFunction(fn[i])) {
          $('body').on('click',tag,fn[i]);
        }
      }
    }else if(orz.isFunction(fn)){
      $('body').on('click',tag,fn);
    }
  });
})(jQuery);
