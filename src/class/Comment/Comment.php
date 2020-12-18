<?php
namespace LizusContinue\Comment;

class Comment extends \LizusVitara\Comment\Comment
{
    protected function metaKeysInit(){
        return array_merge(parent::metaKeysInit(),[
        ]);
    }
}