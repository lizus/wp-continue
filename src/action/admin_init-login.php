<?php

//没有投稿者权限不允许进后台
add_action('admin_init',function (){
    if (\LizusContinue\is_admin_ajax()) return;
    if (is_admin() && is_user_logged_in()) {
        $user=wp_get_current_user();
        if (!current_user_can('edit_posts')) {
            wp_redirect(get_bloginfo('url'));
            die();
        }
    }
});
