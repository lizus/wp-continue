<?php
/* ---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=*
后台主设置页面
---=*--*=*-=*-=-*-=* ^.^ *---=*--*=*-=*-=-*-=* */
/**
 * 使用VITARA_PANEL_INFO来显示控制面板首页的内容，支持html
 */

add_action('admin_menu',function (){
  $page=add_menu_page(get_bloginfo('name').'设置',get_bloginfo('name').'设置','edit_posts','vitara',function (){
    $opt='<div class="wrap vitara"><div class="vitara_panel">';
    $opt.='<h1>'.get_bloginfo('name').'管理系统</h1>';
    $opt.='<div class="wrap-content">';
    $p='';
    if(defined('VITARA_PANEL_INFO')) $p=VITARA_PANEL_INFO;
    $opt.=$p;
    $opt.='</div>';
    $opt.='</div></div>';
    echo $opt;
  });
},1);

