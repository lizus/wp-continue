<?php

/**
 * 判断是否为sitemap页
 */
if ( ! function_exists( 'is_sitemap' ) ) {
function is_sitemap(){
    return !empty(get_query_var('sitemap'));
}
}