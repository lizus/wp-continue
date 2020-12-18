<?php
namespace LizusContinue;

/**
 * get_option
 * 用于获取options表中网站定制的设置值
 * @param  mixed $key
 * @return void
 */
function get_option($key){
    return \get_option(\LizusFunction\v_key($key));
}