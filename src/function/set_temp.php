<?php
namespace LizusContinue;

/**
 * set_temp
 * 临时数据设置，方便用于在模板间传值，但要求传值为键值对的数组
 * @param  array $data
 * @return void
 */
function set_temp($data=[]){
    global $_continue_temp;
    if(is_array($data)) $_continue_temp=$data;
}