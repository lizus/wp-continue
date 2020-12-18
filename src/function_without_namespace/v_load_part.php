<?php

/**
 * v_load_part
 * 页面中的块模板文件夹
 * @param  mixed $name
 * @param  mixed $data
 * @return void
 */
function v_load_part($name,$data=[]){
    return v_load_template('part',$name,$data);
}