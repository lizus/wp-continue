//后台广告预览
(function($){
  var tag='.dragsort_ad_ul [name="item_ad"]';//广告输出框

  function has_div(ele){
    return $(ele).siblings('.pre_views').length>0;
  }

  function add_div(ele){
    $(ele).after('<div class="pre_views"></div>');
  }

  function div_html(ele){
    $(ele).siblings('.pre_views').html($(ele).val());
  }

  function hide_div(ele){
    $(ele).siblings('.pre_views').addClass('hidden');
  }

  function show_div(ele){
    if (!ele) ele=this;
    $(ele).siblings('.pre_views').removeClass('hidden');
  }

  function view_div(ele){
    if (!has_div(ele)) add_div(ele);
    div_html(ele);
  }

  $('body').on('keyup',tag,function (){
    view_div(this);
  });
  $('body').on('focus',tag,function (){
    view_div(this);
    show_div(this);
  })
  $('body').on('blur',tag,function (){
    hide_div(this);
  })
})(jQuery);
