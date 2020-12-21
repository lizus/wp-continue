/* ---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=*
后台所有页面会加载的js
---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=* */

function getJSON(str) {
  if (typeof str == 'string') {
    try {
      return JSON.parse(str);
    } catch (e) {
      console.log(e);
      return false;
    }
  }
  console.log('JSON string check false!')
  return false;
}

//模拟开关处理
jQuery(function ($) {
  $('.toggle').click(function (e) {
    var toggle = this;
    e.preventDefault();
    $(toggle).toggleClass('toggle-on')
      .toggleClass('toggle-off')
      .addClass('toggle-moving');
    setTimeout(function () {
      $(toggle).removeClass('toggle-moving');
    }, 200);
    if ($(toggle).hasClass('toggle-on')) {
      $(toggle).siblings('input.form_value').val('on');
    } else {
      $(toggle).siblings('input.form_value').val('');
    }
  });
});

//关闭按钮
jQuery(function ($) {
  $('body').on('click', '.close', function () {
    $(this).parent().remove();
  });
});

//表单点击全选
jQuery(function ($) {
  $('body').on('click', '.all-select', function () {
    $(this).children().select();
  });
});

//单张图片上传
jQuery(function ($) {
  var vitara_upload;
  var that;
  $('body').on('click', '.upload_image', function (event) {
    var mtitle = $(this).attr('data-title');
    var mbtn = $(this).attr('data-btn');
    that = $(this);
    event.preventDefault();
    if (vitara_upload) {
      vitara_upload.open();
      return;
    }
    vitara_upload = wp.media({
      title: (mtitle || '请上传或选择一张图片'),
      button: {
        text: (mbtn || '插入'),
      },
      multiple: false
    });
    vitara_upload.on('select', function () {
      attachment = vitara_upload.state().get('selection').first().toJSON();
      that.siblings('.image_input').val(attachment.url).trigger('change');
    });
    vitara_upload.open();
  });
  $('.image_input').each(image_init);
  $('body').on('change', '.image_input', image_colorbox);
  $('body').on('focus', '.image_input', function () {
    $(this).select();
  });

  function image_init() {
    var src = $(this).val();
    if (src.search(/https?:\/\//i) == 0) {
      var review = $(this).siblings('.review');
      if (review.length < 1) {
        review = $(' <a href="#" class="review btn btn-review"><img src="' + src + '" alt="thumb"><div class="review_big"><img src="' + src + '" alt="big"></div></a> ');
        $(this).before(review);
      }
      review.find('img').attr('src', src);
    } else {
      $(this).siblings('.review').remove();
    }
  }

  function image_colorbox() {
    var src = $(this).val();
    if (src.search(/https?:\/\//i) == 0) {
      var review = $(this).siblings('.review');
      if (review.length < 1) {
        review = $(' <a href="#" class="review btn btn-review"><img src="' + src + '" alt="thumb"><div class="review_big"><img src="' + src + '" alt="big"></div></a> ');
        $(this).before(review);
      }
      review.find('img').attr('src', src);
      var p = review.parents('li.row');
      if (p.length > 0) {
        var color_ele = p.find('[name="item_color"]');
        if (color_ele.length > 0) {
          var data = {
            action: 'get_color',
            img: src
          };
          $.post(ajaxurl, data, function (res) {
            if (res && res != 0) {
              color_ele.val(res);
              color_ele.trigger('change');
            }
          });
        }
      }
    }
  }
});

//多张图片上传
jQuery(function ($) {
  var vitara_upload;
  var value_id;
  $('body').on('click', '.upload_images', function (event) {
    value_id = $(this).attr('id');
    var mtitle = $(this).attr('data-title');
    var mbtn = $(this).attr('data-btn');
    event.preventDefault();
    if (vitara_upload) {
      vitara_upload.open();
      return;
    }
    vitara_upload = wp.media({
      title: (mtitle || '请上传或选择一张图片'),
      button: {
        text: (mbtn || '插入'),
      },
      multiple: true
    });
    vitara_upload.on('select', function () {
      var arrImages = [];
      attachment = vitara_upload.state().get('selection').map(function (file) {
        var objImage = file.toJSON();
        var obj = {};
        obj.url = objImage.url;
        obj.id = objImage.id;
        obj.width = objImage.width;
        obj.height = objImage.height;
        arrImages.push(obj);
      });
      var srcs = [];
      for (var i = 0; i < arrImages.length; i++) {
        srcs.push(arrImages[i].url);
      }
      $('textarea[data-id=' + value_id + ']').val(srcs.join("|") + '|' + $('textarea[data-id=' + value_id + ']').val()).trigger('change');
    });
    vitara_upload.open();
  });
  $('body').on('change', '.images_textarea', function () {
    show_imgs($(this));
  });
  $('.images_textarea').each(function () {
    show_imgs($(this));
  });
  //传入存有图片的textarea的ID号,在它后面生成图片预览
  function show_imgs(jq) {
    var imgs = jq.val();
    var rel = jq.attr('data-id') || 'imgs';
    if (imgs) {
      imgs = imgs.split('|');
    }
    if (imgs.length > 0) {
      var show = jq.siblings('.images_show');
      if (show.length < 1) {
        var html = '<div class="images_show row">';
        html += '</div>';
        jq.after(html);
      }
      show = jq.siblings('.images_show');
      html = '';
      for (var i = 0; i < imgs.length; i++) {
        if (!imgs[i]) continue;
        html += '<div class="col-xs-6 col-md-3 col-lg-2">';
        html += '<a href="' + imgs[i] + '" class="colorbox" rel="' + rel + '" title="click to show bigs">';
        html += '<div class="item" style="background-image:url(' + imgs[i] + ');">';
        html += '</div>'; //item
        html += '</a>';
        html += '<span class="close" data-target="' + rel + '" data-src="' + imgs[i] + '"><i class="icon-close"></i></span>';
        html += '</div>';
      }
      show.html(html);
      auto_colorbox();
    }
  }
  $('body').on('click', '.images_show .close', function () {
    var t = $('textarea[data-id=' + $(this).attr('data-target') + ']');
    if (t.length < 1) return;
    var src = $(this).attr('data-src');
    var req = new RegExp(src);
    t.val(t.val().replace(req, '')).trigger('change');
    return;
  });
});

//slde_item 设置脚本
jQuery(function ($) {
  $('.slide_item').each(function () {
    var that = $(this);
    //设置中的各项改变时,相应的去改变主设置项
    var target = that.find('.slide_textarea').eq(0);
    var obj = getJSON(target.val());
    if (typeof obj != 'object') {
      obj = {};
    }
    var btn = that.find('.add_slide');
    that.on('change', '[data-name]', function () {
      if ($(this).attr('data-name') == 'slide_item') {
        var lis = that.find('.slide_items_ul>li');
        that.find('[data-name=slide_item]').each(function () {
          var index = lis.index($(this).parent().parent());
          obj[$(this).attr('name') + '_' + index] = $(this).val();
          delete obj[$(this).attr('name') + '_' + obj['length']];
        });
      } else {
        obj[$(this).attr('name')] = $(this).val();
      }
      target.val(JSON.stringify(obj));
    });
    btn.on('click', function () {
      var me = $(this);
      var data = {
        action: 'slide_item'
      };
      $.post(ajaxurl, data, function (res) {
        me.siblings('.slide_items_ul').prepend(res);
      });
      var len = obj['length'] || 0;
      obj['length'] = ++len;
      list_sort();
    });
    that.on('click', '.btn-close', function () {
      $(this).parent().remove();
      obj['length']--;
      that.find('[data-name=slide_item]').eq(0).trigger('change');
      list_sort();
    });
    list_sort();

    function list_sort() {
      that.find('.slide_items_ul').dragsort('destroy');
      that.find('.slide_items_ul').dragsort({
        dragSelector: 'em',
        dragEnd: function () {
          that.find('[data-name=slide_item]').eq(0).trigger('change');
        },
        dragBetween: false,
        placeHolderTemplate: '<li class="placeHolder"></li>'
      });
    }
  });
});

//dragsort_item 设置脚本
jQuery(function ($) {
  $('.dragsort_setting').each(function () {
    var that = $(this);
    //设置中的各项改变时,相应的去改变主设置项
    var target = that.find('.dragsort_textarea').eq(0);
    var obj = getJSON(target.val());
    if (typeof obj != 'object') {
      obj = {};
    }
    var btn = that.find('.add_dragsort');
    that.on('change', '[data-name]', function () {
      if ($(this).attr('data-name') == 'dragsort_item') {
        var lis = that.find('.dragsort_items_ul>li');
        that.find('[data-name=dragsort_item]').each(function () {
          var index = lis.index($(this).parent().parent());
          obj[$(this).attr('name') + '_' + index] = $(this).val();
          delete obj[$(this).attr('name') + '_' + obj['length']];
        });
      } else {
        obj[$(this).attr('name')] = $(this).val();
      }
      target.val(JSON.stringify(obj));
    });
    btn.on('click', function () {
      var me = $(this);
      var data = {
        action: 'dragsort_item',
        dragsort: me.attr('data-dragsort')
      };
      $.post(ajaxurl, data, function (res) {
        me.siblings('.dragsort_items_ul').prepend(res);
      });
      var len = obj['length'] || 0;
      obj['length'] = ++len;
      list_sort();
    });
    that.on('click', '.btn-close', function () {
      $(this).parent().remove();
      obj['length']--;
      if (obj['length'] < 1) {
        target.val('');
      } else {
        that.find('[data-name=dragsort_item]').eq(0).trigger('change');
      }
      list_sort();
    });
    list_sort();
  });

  function list_sort() {
    $('.dragsort_setting').find('.dragsort_items_ul').dragsort('destroy');
    $('.dragsort_setting').find('.dragsort_items_ul').dragsort({
      dragSelector: 'em',
      dragEnd: function () {
        $('.dragsort_setting').each(function () {
          $(this).find('[data-name=dragsort_item]').eq(0).trigger('change');
        });
      },
      dragBetween: false,
      placeHolderTemplate: '<li class="placeHolder"></li>'
    });
  }
});

//自定义文章类型显示多少条新信息
(function ($) {
  var data = {
    action: 'get_new_custom_posts',
  };
  $.post(ajaxurl, data, function (res) {
    res = JSON.parse(res);
    if (res && res.error.length < 1) {
      var counts = res.data;
      var id = '';
      for (var prop in counts) {
        if (counts.hasOwnProperty(prop)) {
          if (counts[prop] > 0) {
            id = '#menu-posts-' + prop;
            if (prop == 'post') id = '#menu-posts';
            $(id).find('.wp-menu-name').append('<span class="awaiting-mod count-' + counts[prop] + '"><span class="pending-count">' + counts[prop] + '</span></span>');
          }
        }
      }
    }
  });
})(jQuery);