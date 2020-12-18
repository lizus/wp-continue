<?php
namespace LizusContinue\Post;

class Post extends \LizusVitara\Post\Post 
{
    protected function metaKeysInit(){
        return array_merge(parent::metaKeysInit(),[
            //'zan'=>'\intval',//文章点赞数据
        ]);
    }
 
}