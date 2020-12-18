<?php
namespace LizusContinue;

/**
 * env
 * 当前环境标识
 * production - 产品发布线上环境
 * dev - 表示开发环境
 * 通过地址栏变量env或wp-config.php中定义常量CONTINUE_ENV来标识
 * @return string 
 */
function env(){
    if(isset($_GET['env']) && \LizusContinue\current_is_administrator()) return \sanitize_text_field($_GET['env']);
    if (!defined('CONTINUE_ENV')) return 'production';
    return CONTINUE_ENV;
}