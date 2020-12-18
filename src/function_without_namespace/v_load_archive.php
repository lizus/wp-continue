<?php

/**
 * v_load_archive
 * 列表页及存档页模板文件夹
 * @param  mixed $name
 * @param  mixed $data
 * @return void
 */
function v_load_archive($name,$data=[]){
    return v_load_template('archive',$name,$data);
}