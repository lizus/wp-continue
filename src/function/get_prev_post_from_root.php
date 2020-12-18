<?php
namespace LizusContinue;

/**
 * get_prev_post_from_root
 * 获取前一个同根分类文章
 * @param  mixed $pid
 * @param  mixed $taxonomy
 * @param  mixed $post_type
 * @return void
 */
function get_prev_post_from_root($pid,$taxonomy='category',$post_type='post'){
  return \LizusContinue\get_adjacent_post_from_root($pid,true,$taxonomy='category',$post_type='post');
}