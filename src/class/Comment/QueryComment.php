<?php
namespace LizusContinue\Comment;

class QueryComment extends \LizusVitara\Comment\QueryComment
{
    protected function get_item($id){
        $cid=$id;
        return compact('id','cid');
    }
}