<?php

/**
 * v_load_comment
 * 评论模板文件夹
 * @param  mixed $name
 * @param  mixed $data
 * @return void
 */
function v_load_comment($name,$data=[]){
    return v_load_template('comment',$name,$data);
}