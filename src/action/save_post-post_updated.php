<?php

/**
 * 文章有更新或发布的时候，更新对应文章类型的缓存的最后更新时间
 */
add_action("save_post", function ($pid, $post, $update) {

  if ($post->post_status == 'publish' || $update === true) {
    /**
     * 文章发布的时候更新缓存的最后更新时间
     */
    wp_cache_set_last_changed('posts');
    wp_cache_set_last_changed($post->post_type . '_posts');
  }
}, 10, 3);
