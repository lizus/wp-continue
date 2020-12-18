<?php
namespace LizusContinue\User;

class QueryUser extends \LizusVitara\User\QueryUser
{
    protected function get_item($uid){
        return compact('uid');
    }
}