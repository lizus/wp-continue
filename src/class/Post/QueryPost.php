<?php

namespace LizusContinue\Post;

class QueryPost extends \LizusVitara\Post\QueryPost
{
    /**
     * 在cache的key中添加last_changed标识，以便于缓存在文章更新时自动刷新
     */
    protected function key()
    {
        $query = $this->args;
        $pts = $query['post_type'];
        if (is_string($pts)) $pts = [$pts];
        $pts = array_map(function ($pt) {
            $last_changed = wp_cache_get_last_changed($pt . '_posts');
            list($microseconds, $seconds) = explode(' ', $last_changed);
            return intval($seconds);
        }, $pts);
        $pts = max($pts);
        return parent::key() . ':' . $pts;
    }
    protected function get_item($id)
    {
        $pid = $id;
        return compact('id', 'pid');
    }
}
