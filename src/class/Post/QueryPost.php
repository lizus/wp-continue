<?php
namespace LizusContinue\Post;

abstract class QueryPost extends LizusVitara\Post\QueryPost
{
    protected function get_item($pid){
        return compact('pid');
    }
}