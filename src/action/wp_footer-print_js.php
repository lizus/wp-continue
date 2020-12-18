<?php
add_action('wp_footer', function () {
    $ui='/ui';
    if(defined('STATIC_DIR')) $ui=STATIC_DIR;
    $data=apply_filters('continue_js',[
        'jquery'=>get_bloginfo('template_directory') .$ui.'/js/jquery.js',
        'web'=>get_bloginfo('template_directory') .$ui.'/js/web.js',
    ]);
    foreach ($data as $item) {
        echo '<script src="'.$item.'?v='.\LizusContinue\get_version().'" charset="utf-8"></script>';
    }
},100);