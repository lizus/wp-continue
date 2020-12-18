(function($){
  function add_mask(){
    $('body').append('<div class="vitara_mask"></div>');
  }
  function remove_mask(){
    $('.vitara_mask').remove();
  }
  function show_model(content){
    add_mask();
    var model='<div class="vitara_model"><div class="vitara_model_content">'+content+'</div><div class="submit_btn"><button type="button" class="btn btn-primary btn-submit">确定</button></div><span class="close-model"><i class="icon-close"></i></span></div>';
    $('body').append(model);
  }
  function remove_model(){
    remove_mask();
    $('.vitara_model').remove();
  }
  function model_submit(fn){
    var eles=$('.vitara_model [name]');
    var data={
      action:'vitara_model_post'
    };
    eles.each(function (){
      data[$(this).attr('name')] = $(this).val();
    });
    $.post(ajaxurl,data,fn);
  }
  orz.add_mask=add_mask;
  orz.remove_mask=remove_mask;
  orz.show_model=show_model;
  orz.remove_model=remove_model;
  orz.model_submit=model_submit;
  $('body').on('click','.vitara_mask',remove_model);
  $('body').on('click','.vitara_model .close-model',remove_model);
})(jQuery);
