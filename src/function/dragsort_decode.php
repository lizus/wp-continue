<?php
namespace LizusContinue;

/**
* dragsort_decode
* 用于解码dragsort字符串为键值对数组
* 后台存储的dragsort值需要先stripslashes一次才行
* @param  string $str
* @return array
*/
function dragsort_decode($str=''){
    return \LizusVitara\Singleton\Dragsort::decode($str);
}