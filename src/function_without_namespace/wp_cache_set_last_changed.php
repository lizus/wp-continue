<?php

/**
 * wordpress6.3版本开始添加了wp_cache_set_last_changed函数，用于设置缓存的最后更新时间，以便于缓存的更新，但是在6.3之前的版本没有这个函数，所以需要添加这个函数
 */
if (!function_exists('wp_cache_set_last_changed')) {
    /**
     * Sets last changed date for the specified cache group to now.
     *
     * @since 6.3.0
     *
     * @param string $group Where the cache contents are grouped.
     * @return string UNIX timestamp when the group was last changed.
     */
    function wp_cache_set_last_changed($group)
    {
        $previous_time = wp_cache_get('last_changed', $group);

        $time = microtime();

        wp_cache_set('last_changed', $time, $group);

        /**
         * Fires after a cache group `last_changed` time is updated.
         * This may occur multiple times per page load and registered
         * actions must be performant.
         *
         * @since 6.3.0
         *
         * @param string    $group         The cache group name.
         * @param int       $time          The new last changed time.
         * @param int|false $previous_time The previous last changed time. False if not previously set.
         */
        do_action('wp_cache_set_last_changed', $group, $time, $previous_time);

        return $time;
    }
}
