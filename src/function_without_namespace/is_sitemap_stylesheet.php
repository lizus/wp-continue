<?php

/**
 * 判断是否为sitemap样式页
 */
if ( ! function_exists( 'is_sitemap_stylesheet' ) ) {
function is_sitemap_stylesheet(){
    return !empty(get_query_var('sitemap-stylesheet'));
}
}