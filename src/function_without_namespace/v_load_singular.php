<?php

/**
 * v_load_singular
 * 内容页模板文件夹
 * @param  mixed $name
 * @param  mixed $data
 * @return void
 */
function v_load_singular($name,$data=[]){
    return v_load_template('singular',$name,$data);
}