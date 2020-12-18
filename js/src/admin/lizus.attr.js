/** ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
 * @Name jQuery获取DOM以data-开头的attr的Curry化
 * @Author lizus.com
 * @Updated 20190512
 * @Description
 使用Curry组织jQuery的DOM元素的属性获取，以data-开头
 *
 * @param attr 属性名
 * @param tag dom对像查询字符串或jQuery对象
 *
 * @Return 获取到的属性值
 *
---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=* */
(function($){
  orz.attr=orz.curry(function (attr,tag){
      return $(tag).attr('data-'+attr);
  });
  orz.setAttr=orz.curry(function (attr,value,tag){
      return $(tag).attr('data-'+attr,value);
  });
  orz.attrEq=orz.curry(function (attr,value,tag){
    return orz.attr(attr,tag) == value;
  });
  orz.addClass=orz.curry(function (className,tag){
    return $(tag).addClass(className);
  });
  orz.removeClass=orz.curry(function (className,tag){
    return $(tag).removeClass(className);
  });
  orz.hasClass=orz.curry(function (className,tag){
    return $(tag).hasClass(className);
  });
})(jQuery);
