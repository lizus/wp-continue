<?php
namespace LizusContinue;

/**
 * get_setting_dragsort
 * 后台设置项的dragsort获取，需要stripslashes的处理
 * @param  string $str
 * @return array
 */
function get_setting_dragsort($str=''){
    return \LizusContinue\dragsort_decode(\stripslashes($str));
}