<?php
namespace LizusContinue;

/**
 * get_redirect_url
 * 获取跳转调用的ajax地址
 * @return string
 */
function get_redirect_url($redirect){
    return \LizusFunction\v_url(\LizusContinue\get_ajax_url(),'action=redirect&redirect='.$redirect);
}