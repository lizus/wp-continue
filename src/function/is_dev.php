<?php
namespace LizusContinue;

/**
 * is_dev
 * 用来判断是否生产环境，开发环境请在wp-config.php中添加 define('CONTINUE_ENV', 'dev');
 * @return boolean
 */
function is_dev(){
    return env() == 'dev';
}