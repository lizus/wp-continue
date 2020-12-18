<?php
namespace LizusContinue;

/**
 * get_adjacent_post_from_root
 * 获得某文章的邻近的同根分类(分类的parent为0)的文章,使用该文章所在的大类
 *
 * @param  int $pid - 文章ID
 * @param  boolean $prev - true为前一篇，false为后一篇，此前后相对$pid的文章的发布时间而定
 * @param  string $taxonomy
 * @param  string $post_type
 * @return mixed
 */
function get_adjacent_post_from_root($pid,$prev=true,$taxonomy='category',$post_type='post'){
  $date=\get_post_field('post_date',$pid);
  $terms=\get_the_terms($pid,$taxonomy);
  $tax_query=[];
  $args=[
    'posts_per_page'=>1,
    'post_type'=>$post_type,
  ];
  if ($prev) {
    $args['order']='DESC';
    $args['date_query']=['before'=>$date];
  }else {
    $args['order']='ASC';
    $args['date_query']=['after'=>$date];
  }
  if (!empty($terms)) {
	$term=$terms[0];
	$tid=$term->term_id;
	$r=\get_ancestors($term->term_id,$taxonomy);
	if(!empty($r)) $tid=\array_pop($r);
    $tax_query=[
    	'relation'=>'AND',//AND,OR
      [
    		'taxonomy'=>$taxonomy,
    		'field'=>'id',//id,slug
    		'terms'=>array( $tid ),
    		'operator'=>'IN'//IN,NOT IN,AND
      ],
    ];
    $args['tax_query']=$tax_query;
  }
  $data=new \LizusContinue\Post\QueryPost($args);
  $items=$data->get();
  if (\count($items)>0) return $items[0];
  return false;
}