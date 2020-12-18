<?php
namespace LizusContinue;

//主题版本信息
function get_version(){
  $my_theme=\wp_get_theme();
  return $my_theme->get('Version');
}
