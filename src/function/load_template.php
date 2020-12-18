<?php
namespace LizusContinue;

/**
 * load_template
 * 用于载入分部模板
 *
 * https://developer.wordpress.org/reference/functions/get_template_part/
 * 
 * @param  string $path - 模板文件夹路径
 * @param  string $name - 模板名称（除去路径和后缀的部分）
 * @param  array $data - 临时传值给模板
 * @return void
 */
function load_template($path,$name,$data=[]) {
	if(!empty($data) && is_array($data)) \LizusContinue\set_temp($data);
	\get_template_part($path,$name);
}