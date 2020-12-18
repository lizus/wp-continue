<?php
namespace LizusContinue;

/**
 * is_cli 
 * 用于判断是否在命令行模式下，如使用wp-cli的环境
 *
 * @return boolean
 */
function is_cli(){
  return isset($_SERVER['SSH_CLIENT']);
}