<?php

function get_q(){
    global $wp_query;
    $q=(!empty($wp_query->queried_object)) ? $wp_query->queried_object : $wp_query;
    return $q;
}