<?php
namespace LizusContinue;

/**
 * get_next_post_from_root
 * 获取后一个同根分类文章
 * @param  mixed $pid
 * @param  mixed $taxonomy
 * @param  mixed $post_type
 * @return void
 */
function get_next_post_from_root($pid,$taxonomy='category',$post_type='post'){
  return \LizusContinue\get_adjacent_post_from_root($pid,false,$taxonomy='category',$post_type='post');
}