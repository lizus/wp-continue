<?php

/**
 * v_load_component
 * 载入组件模板
 * @param  mixed $name
 * @param  mixed $data
 * @return void
 */
function v_load_component($name,$data=[]){
    return v_load_template('component',$name,$data);
}