(function($){
  $('body').on('cropImageUploaded','[data-component="image-crop"]',function (e,res){
    if (res) {
      res=JSON.parse(res);
      if (res) {
        console.log(res.src);
        $(this).siblings('.crop_textarea').val(res.src).trigger('change');
      }
    }else {
      alert('error');
    }

  });
  $('.crop_textarea').each(image_colorbox);
  $('body').on('change','.crop_textarea',image_colorbox);

  function image_colorbox(){
    var src=$(this).val();
    if (src.search(/https?:\/\//i)==0) {
      var review=$(this).siblings('.review');
      if (review.length<1) {
        review=$(' <a href="#" class="review btn btn-review"><img src="'+src+'" alt="thumb"><div class="review_big"><img src="'+src+'" alt="big"></div></a> ');
        $(this).before(review);
      }
      review.find('img').attr('src',src);
    }else {
      $(this).siblings('.review').remove();
    }
  }
})(jQuery);
