<?php

/**
 * 用于需要更新rewrite_rule的时候，管理员登录网站，在任意页面使用地址添加update=rewrite_rule即可。
 */
add_action('init', function () {
    if (isset($_GET['update']) && $_GET['update'] == 'rewrite_rule' && current_user_can('manage_options')) {
        flush_rewrite_rules();
    }
}, 999);
