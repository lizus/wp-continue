<?php

/**
 * v_load_widget
 * widget模板文件夹
 * @param  mixed $name
 * @param  mixed $data
 * @return void
 */
function v_load_widget($name,$data=[]){
    return v_load_template('widget',$name,$data);
}