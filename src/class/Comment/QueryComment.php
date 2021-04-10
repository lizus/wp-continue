<?php
namespace LizusContinue\Comment;

class QueryComment extends \LizusVitara\Comment\QueryComment
{
    protected function get_item($id){
        return compact('id');
    }
}