<?php

//后台评论相关的页面，包括评论编辑，列表，及ajax中评论的action
function is_admin_comment_pages(){
  if (!is_admin()) return false;
  if (preg_match('/comment/',$_SERVER['REQUEST_URI'])) return true;
  if (isset($_POST['action']) && preg_match('/admin-ajax\.php/',$_SERVER['REQUEST_URI'])) {
    if ($_POST['action'] == 'edit-comment') return true;
    if ($_POST['action'] == 'dim-comment') return true;
    if ($_POST['action'] == 'replyto-comment') return true;
    if ($_POST['action'] == 'delete-comment') return true;
  }
  return false;
}