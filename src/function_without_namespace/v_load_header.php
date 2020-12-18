<?php

/**
 * v_load_header
 * header模板文件夹
 * @param  mixed $name
 * @param  mixed $data
 * @return void
 */
function v_load_header($name,$data=[]){
    return v_load_template('header',$name,$data);
}