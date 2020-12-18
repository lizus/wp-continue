<?php
namespace LizusContinue;

/**
 * get_continue_uri
 * wp-continue的根目录uri地址
 * @return void
 */
function get_continue_uri(){
    return \get_template_directory_uri().str_replace(\get_template_directory(),'',dirname(dirname(__DIR__)));
}