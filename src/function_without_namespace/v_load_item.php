<?php

/**
 * v_load_item
 * 列表单项模板文件夹
 * @param  mixed $name
 * @param  mixed $data
 * @return void
 */
function v_load_item($name,$data=[]){
    return v_load_template('item',$name,$data);
}