<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
//记录浏览量
//

add_action('wp_ajax_views', 'vitara_ajax_views');
add_action('wp_ajax_nopriv_views', 'vitara_ajax_views');
function vitara_ajax_views(){
  $opt=array();
  $error=array();
  $data=array();

  $id=(isset($_REQUEST['id'])) ? sanitize_text_field($_REQUEST['id']) : '';
  $ids=(isset($_REQUEST['ids'])) ? $_REQUEST['ids'] : '';

  if (!empty($id)) {
    $p=new \LizusContinue\Post\Post($id);
    $p->addViews();
  }
  if (!empty($ids) && is_array($ids)) {
    foreach ($ids as $id) {
      $p=new \LizusContinue\Post\Post($id);
      $p->addViews();
    }
  }

  //可用在记录浏览量的时候给客户端输出一些内容
  $data=apply_filters('ajax_views','');

  $opt['error']=$error;
  $opt['data']=$data;
  echo json_encode($opt);
  die();
}
