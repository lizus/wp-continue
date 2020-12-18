<?php

/**
 * v_load_article
 * post文章类型模板文件夹
 * @param  mixed $name
 * @param  mixed $data
 * @return void
 */
function v_load_article($name,$data=[]){
    return v_load_template('article',$name,$data);
}