<?php

/**
 * 勾子在wp_dropdown_users函数中，用于过滤或重组查询参数
 * 用户量大的站点在拉取用户列表的时候会很慢，数据库查询太久
 * 此处传入need_cache=yes，用于在查询用户信息的时候进行缓存，减少数据库查询
 * 见action/pre_user_query.php
 */
add_filter('wp_dropdown_users_args',function ($query_args,$parsed_args){
    $query_args['need_cache']='yes';
    return $query_args;
},10,2);