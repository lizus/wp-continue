<?php
/**
 * 文章发布的时候，在作者的usermeta中记录该作者最近的更新时间
 */
add_action( "save_post", function ($pid,$post,$update){
  if ($post->post_status=='publish') {
    $user=new \LizusContinue\User\User($post->post_author);
    $user->set('post_updated',time());
  }
},10,3);