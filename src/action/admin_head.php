<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
    die();
}
/**
 * 后台挂载需要的css样式，用于后台添加的功能
 */
add_action('admin_head', function () {
    $arr = [
        'colorbox',
        'fontello',
        'jquery.smartSelect',
        'jquery.crop',
        'admin',
    ];

    foreach ($arr as $item) {
        echo '<link rel="stylesheet" href="' . \LizusContinue\get_static_uri() . '/css/' . $item . '.css?ver=' . \LizusContinue\get_version() . '">' . "\n";
    }

    /**
     * 解决高版本下colorbox出错
     * 该js最好从官网下载，因为官网在国内常常无法访问，所以尽量放本地
     */
    //echo '<script src="https://code.jquery.com/jquery-migrate-1.4.1.js" charset="utf-8"></script>'; 
});
