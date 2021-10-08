<?php
namespace LizusContinue;
/**
 * is_admin_ajax
 * 用于判断后端使用的ajax
 *
 * @return boolean 
 */
function is_admin_ajax(){
  if(preg_match('/^admin\-ajax\.php/',basename($_SERVER['REQUEST_URI']))) return true;
  if(preg_match('/^async\-upload\.php/',basename($_SERVER['REQUEST_URI']))) return true;
  return false;
}