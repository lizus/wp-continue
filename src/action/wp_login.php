<?php

/* ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
用户最近一次登录时间
添加用户的登录记录
---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=* */
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

add_action('wp_login', function ($user_login,$user){
  $u=new \LizusContinue\User\User($user->ID);
  $u->set('lastlogin',date('Y-m-d H:i:s',time()));
  $u->addLoginLog();
}, 10, 2);
