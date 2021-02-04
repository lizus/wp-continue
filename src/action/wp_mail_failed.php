<?php
/**
 * 在开发环境中，如果邮件发生错误，则直接打印错误信息
 */
add_action( 'wp_mail_failed', 'onMailError', 10, 1 );
function onMailError( $wp_error ) {
  if (!\LizusContinue\is_dev() || \LizusContinue\is_cli() || \LizusContinue\is_ajax() || \LizusContinue\is_admin_ajax()) return;
    echo "<pre>";
    print_r($wp_error);
    echo "</pre>";
} 