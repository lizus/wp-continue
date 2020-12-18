<?php

/**
 * v_load_loop
 * loop模板文件夹
 * @param  mixed $name
 * @param  mixed $data
 * @return void
 */
function v_load_loop($name,$data=[]){
    return v_load_template('loop',$name,$data);
}