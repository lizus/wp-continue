<?php

/**
 * 要求图标css放在静态文件夹中的css文件夹中
 * 通过STATIC_DIR来定义静态文件夹相对当前主题根目录的位置
 */

add_action('admin_menu',function (){
    if(!defined('STATIC_DIR')) return;
    $title='图标说明';
    $page=add_submenu_page('vitara',$title,$title,'edit_posts','fontello','fontelloAdminPanel');
},10,999);

function fontelloAdminPanel(){
    if(!defined('STATIC_DIR')) return;
    ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri().STATIC_DIR.'/css/fontello.css?v='.\LizusContinue\get_version(); ?>">
<div class='wrap vitara'>
    <div class="vitara_panel">
        <h1>Fontello图标说明</h1>
        <p>以下为网站中可用的fontello图标</p>
        <div class="items row" style="font-size:18px;line-height:2;">
        <?php
        $file=get_template_directory().STATIC_DIR.'/css/fontello.css';
        $content=file_get_contents($file);
        if(preg_match_all('/\.icon-(.+?):before/',$content,$m)) {
            foreach($m[1] as $item) {
                echo '<div class="col-sm-2"><div class="item" style="margin-bottom:0.5em;">'.ico($item).'<span class="text" style="margin-left:1em;">'.$item.'</span></div></div>';
            }
        }
        ?>
        </div>
    </div>
</div>
    <?php
}