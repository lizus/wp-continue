<?php
namespace LizusContinue;

/**
 * current_is_administrator
 * 判断当前用户是否是管理员
 * @return boolean
 */
function current_is_administrator(){
    return \current_user_can('manage_options');
}