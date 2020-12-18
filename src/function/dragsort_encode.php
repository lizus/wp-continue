<?php
namespace LizusContinue;

/**
* dragsort_encode
* 将key=>value键值对数组打包成dragsort存储使用的json字符串
* @param  array $data
* @return string
*/
function dragsort_encode($data=[]){
    return \LizusVitara\Singleton\Dragsort::encode($data);
}