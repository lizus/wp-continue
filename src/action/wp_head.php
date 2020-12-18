<?php

add_action('wp_head',function (){
    echo '<meta content="'.\get_bloginfo('name').'" name="Author" />';
    echo "\n";
    echo '<meta content="'.\get_bloginfo('name').'版权所有" name="Copyright" />';
    echo "\n";
},2);