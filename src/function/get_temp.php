<?php
namespace LizusContinue;

/**
 * get_temp
 * 获取临时数据，同时清空该全局变量
 * @return void
 */
function get_temp(){
    global $_continue_temp;
    $tmp=$_continue_temp;
    $_continue_temp=[];
    return $tmp;
}