<?php
namespace LizusContinue;
/**
 * is_ajax 
 * 用于判断前端使用的ajax，该判断仅检查当前调用文件的名称，所以并不可靠，但一般够用
 *
 * @return boolean
 */
function is_ajax(){
  if(preg_match('/^ajax\.php/',basename($_SERVER['REQUEST_URI']))) return true;
  return false;
}