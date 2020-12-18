<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
/**
 * 后台加载的js脚本
 */
add_action( "admin_footer", function (){
    $arr=[
        'jquery.colorbox',
        'jquery.smartSelect',
        'jquery.crop',
        'jquery.dragsort.min',
        'admin',
    ];
    foreach ($arr as $item) {
        echo '<script src="'.\LizusContinue\get_static_uri().'/js/admin/'.$item.'.js?ver='.\LizusContinue\get_version().'"></script>'."\n";
    }
    
});
