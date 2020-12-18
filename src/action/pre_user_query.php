<?php

/**
 * 该勾子在WP_User_Query->prepare_query()方法结尾。
 * 在勾子中根据$user->query_vars的值来生成缓存key，然后查询该key是否存在，存在则直接赋值给$user->results，再配合users_pre_query的filter，则可以省掉数据库查询，节省资源。
 * $key中使用date函数来生成缓存每天固定时间到期，18000为5*3600，意味着每天早上5点之后，生成的key就会是新值，这样就替换了旧值，旧的key等过期时间到了再自动销毁即可。
 * $user的获取数据中，还需要有一个total_users用来计数总的用户数，所以增加$key_total来存储相关结果
 */
add_action('pre_user_query',function (&$user){
    $qvs=$user->query_vars;

    //需要在查询中有need_cache值等于yes，见filter/wp_dropdown_users_args.php
    if(!isset($qvs['need_cache']) ||$qvs['need_cache'] != 'yes') return;

    $key=\LizusFunction\v_key('pre_user_query_'.md5(json_encode($qvs)).'_'.date('Ymd',current_time('timestamp')-18000));
    $key_total=$key.'_tatal';
    $results = \LizusFunction\get_transient($key);
    $results_total = \LizusFunction\get_transient($key_total);
    if (false === $results) {
        $user->query();
        $results=$user->results;
        $results_total=$user->total_users;
        set_transient($key,$results,86400);
        set_transient($key_total,$results_total,86400);
    }else {
        $user->results=$results;
        $user->total_users=$results_total;
    }
});