<?php
namespace LizusContinue;

/**
 * set_option
 * 设置网站定制的设置项
 * @param  string $key
 * @param  mixed $data
 * @param  string $autoload 是否自动加载，默认为no，可选yes则会加载在wp_load_alloptions中
 * @return void
 */
function set_option($key,$data,$autoload='no'){
  return \update_option(\LizusFunction\v_key($key),$data,$autoload);
}