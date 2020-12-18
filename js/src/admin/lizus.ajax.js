/** ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
 * @Name admin-ajax的curry化，后台专享
 * @Author lizus.com
 * @Updated 20190717
 * @Description

 *
 * @Example

 *
 * @Return

 *
---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=* */
(function($){
  orz.ajax=orz.curry(function (type,error,success,data,context){
    $.ajax({
      type:type,
      url:ajaxurl,
      context:context,
      data:data,
      success:success,
      error:error
    });
  });
  orz.get=orz.ajax('GET',function (){
    orz.log('ajax get error');
    orz.log(this);
  });
  orz.post=orz.ajax('POST',function (){
    orz.log('ajax post error');
    orz.log(this);
  });
})(jQuery);
