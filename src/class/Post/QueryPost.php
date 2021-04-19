<?php
namespace LizusContinue\Post;

class QueryPost extends \LizusVitara\Post\QueryPost
{
    protected function get_item($id){
        $pid=$id;
        return compact('id','pid');
    }
}