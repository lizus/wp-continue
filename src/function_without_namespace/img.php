<?php

/**
 * img
 * 用于插入图片
 *
 * @param  mixed $src
 * @param  mixed $class
 * @return void
 */
function img($src,$class=''){
  return '<i class="thumb '.$class.'" style="background-image:url('.$src.')"></i>';
}