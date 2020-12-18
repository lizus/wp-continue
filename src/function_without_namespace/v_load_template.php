<?php

/**
 * v_load_template
 * 加载模板
 * @param  string $path 文件夹名称，同时也是该文件夹中使用的文件前缀名称
 * @param  string $name 模板文件除前缀后的名称 ($path-$name.php)
 * @param  array $data 传入模板的临时数据，总是使用array
 * @return void
 */
function v_load_template($path,$name,$data=[]) {
	return LizusContinue\load_template('template/'.$path.'/'.$path,$name,$data);
}