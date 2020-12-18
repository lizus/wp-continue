<?php
namespace LizusContinue\User;


class User extends \LizusVitara\User\User
{
    
    protected function metaKeysInit(){
        return array_merge(parent::metaKeysInit(),[
            //'views'=>'\intval',//用户总人气（文章总浏览量）
            ]
        );
    }

}