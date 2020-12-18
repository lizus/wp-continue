<?php
namespace LizusContinue;

/**
 * get_ajax_url
 * 获取前端调用的ajax地址
 * @return string
 */
function get_ajax_url(){
    return get_continue_uri().'/ajax.php';
}