<?php

add_action('wp_ajax_get_color', 'vitara_ajax_get_color');
add_action('wp_ajax_nopriv_get_color', 'vitara_ajax_get_color');
function vitara_ajax_get_color(){

  $img=isset($_REQUEST['img']) ? sanitize_text_field($_REQUEST['img']) : '';
  if (!empty($img)) {
    echo \LizusFunction\get_color($img);
  }

  die();
}
