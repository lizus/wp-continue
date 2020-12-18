<?php
/* ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
SMTP,在综合设置中设定

通常使用QQ邮箱比较稳，后台里设置邮箱的smtp信息
SMTP服务器：smtp.qq.com
端口号：465
---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=* */
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

//默认发信设置
add_action('phpmailer_init','mail_smtp');
function mail_smtp($phpmailer){
    if (!defined('USE_SMTP') || USE_SMTP != true) return;
    $smtp_email=(defined('SMTP_EMAIL') ? SMTP_EMAIL : '');
    $smtp_pass=(defined('SMTP_PASS') ? SMTP_PASS : '');
    $smtp_server=(defined('SMTP_SERVER') ? SMTP_SERVER : '');
    $smtp_port=(defined('SMTP_PORT') ? SMTP_PORT : '');
    if(!empty($smtp_email) && !empty($smtp_pass) && !empty($smtp_server) && !empty($smtp_port)){
        $secure="ssl";
        $phpmailer->IsSMTP();
        $phpmailer->SMTPAuth = true; //启用SMTPAuth服务
        $phpmailer->Port = $smtp_port; //SMTP邮件发送端口，这个和下面的对应，如果这里填写25，则下面为空白
        $phpmailer->SMTPSecure = $secure; //是否验证 ssl，这个和上面的对应，如果不填写，则上面的端口须为25
        $phpmailer->Host = $smtp_server; //邮箱的SMTP服务器地址，如果是QQ的则为：smtp.exmail.qq.com
        $phpmailer->Username = $smtp_email; //邮箱地址
        $phpmailer->Password = $smtp_pass; //邮箱密码
        //$phpmailer->SMTPDebug = 2;//调试邮箱登录用
    }
}

//默认发送邮件用的邮箱地址
add_filter('wp_mail_from',function ($return_email){
    if (!defined('USE_SMTP') || USE_SMTP != true) return $return_email;
    $server_name=$_SERVER['SERVER_NAME'];
    $server_name=preg_replace('/^www\./i','',$server_name);
    $email_info=(defined('SMTP_EMAIL') ? SMTP_EMAIL : '');
    $return_email='noreply@'.$server_name;
    if (!empty($email_info)) {
        $return_email=trim(strip_tags($email_info));
    }
    return $return_email;
});

//默认发送邮件用的名称
add_filter('wp_mail_from_name',function ($name){
    if (!defined('USE_SMTP') || USE_SMTP != true) return $name;
    return get_bloginfo('name');
});
