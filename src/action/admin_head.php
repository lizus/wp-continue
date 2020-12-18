<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
/**
 * 后台挂载需要的css样式，用于后台添加的功能
 */
add_action('admin_head',function (){
    $arr=[
        'colorbox',
        'fontello',
        'jquery.smartSelect',
        'jquery.crop',
        'admin',
    ];
    foreach ($arr as $item) {
        echo '<link rel="stylesheet" href="'.\LizusContinue\get_static_uri().'/css/admin/'.$item.'.css?ver='.\LizusContinue\get_version().'">'."\n";
    }
});
