<?php
namespace LizusContinue;

/**
 * console_dump
 * 方便在调试时打印在console里，线上调试时方便使用
 *
 * @param  mixed $data
 * @return void
 */
function console_dump($data){
  echo '<script>if(console && console.dir) console.dir(JSON.parse(\''.json_encode($data).'\'));</script>';
}
