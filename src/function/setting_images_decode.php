<?php
namespace LizusContinue;

/**
 * setting_images_decode
 * 后台设置多张图片的解码,输出图片地址数组，并去掉空值
 * @param  string $str
 * @return array
 */
function setting_images_decode($str=''){
    return array_merge([],array_filter(array_map(function($item){
        return trim($item);
    },explode('|',$str))));
}