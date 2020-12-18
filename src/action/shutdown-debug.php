<?php

//开发环境调试用
add_action( 'shutdown', function(){
  if (!\LizusContinue\is_dev() || \LizusContinue\is_cli() || \LizusContinue\is_ajax() || \LizusContinue\is_admin_ajax()) return;
  \LizusContinue\show_debug();
},999);
