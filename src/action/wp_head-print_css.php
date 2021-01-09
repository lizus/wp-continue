<?php

add_action('wp_head', function () {
    $ui='/ui';
    if(defined('STATIC_DIR')) $ui=STATIC_DIR;
    $data=apply_filters('continue_css',[
        'styles'=>get_bloginfo('template_directory') .$ui.'/css/styles.css',
    ]);
    foreach ($data as $item) {
        echo '<link rel="stylesheet" href="'.$item.'?v='.\LizusContinue\get_version().'" type="text/css" media="all">'."\n";
    }
},100);