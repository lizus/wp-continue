<?php

add_action('wp_ajax_crop_upload', 'vitara_ajax_crop_upload');
add_action('wp_ajax_nopriv_crop_upload', 'vitara_ajax_crop_upload');
function vitara_ajax_crop_upload(){
  if (!is_user_logged_in()) die();

  $img=isset($_REQUEST['img']) ? strip_tags($_REQUEST['img']) : '';
  $source=isset($_REQUEST['source']) ? strip_tags($_REQUEST['source']) : '';
  if (!empty($img)) {
    $type='jpg';
    if (preg_match('/data:image\/([^;]+);base64,/',$img,$m)) {
      $type=$m[1];
      switch ($type) {
        case 'png':
        $type='png';
        break;
        case 'gif':
          $type='gif';
        break;
        default:
          $type='jpg';
        break;
      }
    }
    $img=preg_replace('/data:image\/([^;]+);base64,/','',$img);
    $name=md5($img).'.'.$type;
    $source=preg_replace('/data:image\/([^;]+);base64,/','',$source);
    $sourcename=md5($img).'_source.'.$type;
    $dir=wp_upload_dir();
    if ($dir['error'] == false) {
      $r=file_put_contents($dir['path'].'/'.$name,base64_decode($img));
      $sourcer=file_put_contents($dir['path'].'/'.$sourcename,base64_decode($source));
      if ($r) {
        echo json_encode([
          'src'=> $dir['url'].'/'.$name,
          'source_src'=> $dir['url'].'/'.$sourcename,
          'error'=>false,
        ]);
      }else {
        echo json_encode([
          'error'=> '未生成图像',
        ]);
      }
    }else {
      echo json_encode([
        'error'=>$dir['error'],
      ]);
    }
  }

  die();
}
