<?php
namespace LizusContinue\Comment;

/**
 * comment_ID -> 评论ID
 * comment_parent -> 父评论ID
 * comment_date -> 评论时间
 * comment_content -> 评论内容
 * comment_author -> 评论者名称,如果用户已登录通常不使用该段
 * comment_author_IP -> 评论者IP
 * comment_author_email -> 评论者email
 * user_id -> 用户ID，如果值大于0则为登录用户的ID，值为0则为未登录用户
 * comment_agent -> 用户浏览器代理，可用来判断浏览器和设备
 * comment_approved -> 1为已过审的评论，trash为回收站中的评论
 * comment_post_ID -> 评论对应的文章ID
 * 
 * sticky -> 是否置顶评论 使用时用方法 isSticky
 */

class Comment extends \LizusVitara\Comment\Comment
{
    protected function metaKeysInit(){
        return array_merge(parent::metaKeysInit(),[
        ]);
    }
    
    /**
     * getCommentAuthor
     * 获取评论者昵称，登录用户使用用户设置的昵称，未登录用户则使用comment_author
     * @return void
     */
    public function getCommentAuthor(){
        $name=$this->comment_author;
        if($this->user_id>0) {
            $u=new \LizusContinue\User\User($this->user_id);
            if($u->exist()) {
                $name=$u->display_name;
            }
        }
        return $name;
    }
}