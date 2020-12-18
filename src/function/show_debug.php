<?php
namespace LizusContinue;

/*
显示调试信息，需要开启WP_DEBUG,SAVEQUERIES，通常应该输出在页面最底部
*/

function show_debug(){
  global $wp_query,$wpdb;
  $q=(!empty($wp_query->queried_object)) ? $wp_query->queried_object : $wp_query;

  $actions=array();
  foreach( $GLOBALS['wp_actions'] as $action => $count ) {
    $actions[]=sprintf( '%s (%d)', $action, $count );
  }
  ?>
  <script type="text/javascript">
  (function(){
    var s='<?php echo json_encode($actions); ?>';
    var actions=JSON.parse(s);
    if(console.table) {
      console.table(actions);
    }else {
      console.log(actions);
    }
    var q='<?php echo addslashes(json_encode($wpdb->queries)); ?>';
    var queries=JSON.parse(q);
    console.log('<?php echo \get_num_queries() . ' queries in ' . \timer_stop(0) . ' seconds.'; ?>');
    if(console.table) {
      console.table(queries);
    }else {
      console.log(queries);
    }
  })();
  </script>
  <?php
}
