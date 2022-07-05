<?php
/**
 * 用于地址跳转，使用该程序跳转时会相应的生成cookie
 */
add_action('wp_ajax_redirect', 'vitara_ajax_redirect');
add_action('wp_ajax_nopriv_redirect', 'vitara_ajax_redirect');
function vitara_ajax_redirect(){
    $redirect=isset($_REQUEST['redirect']) ? sanitize_text_field($_REQUEST['redirect']) :get_bloginfo('url'); 

    echo '<script>location.href="'.$redirect.'";</script>';
    die();
}