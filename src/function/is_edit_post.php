<?php
namespace LizusContinue;

/**
 * 用于判断当前页面是否是某文章的编辑页面，包括点击更新后跳转的页面
 * @param  int  $pid [文章ID]
 * @return boolean
 */
function is_edit_post($pid){
	if ($pid<1) return false;
  if (in_array($GLOBALS['pagenow'], array('post.php'))) {
    if(isset($_POST['post_ID'])) return $_POST['post_ID'] == $pid;
    if(isset($_GET['post']) && isset($_GET['action'])) return $_GET['post'] == $pid && $_GET['action'] == 'edit';
  }
  return false;
}
