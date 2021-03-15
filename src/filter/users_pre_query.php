<?php

/**
 * 该勾子在WP_User_Query->query()方法中，返回null则查询数据库，其他值都不查数据库
 * 我们利用pre_user_query的勾子，查询缓存中是否已有查询过，直接将缓存保存在$user->results中，所以只要看$user->results是否非空数组，如果非空，则直接返回该数组，不必再查数据库。
 * 具体详见action/pre_user_query.php
 */
add_filter('users_pre_query',function ($val,$user){
    if(is_array($user->results) && count($user->results)>0) return $user->results;
    return null;
},10,2);