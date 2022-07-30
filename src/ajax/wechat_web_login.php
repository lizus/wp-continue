<?php
// ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
/**
* 用于网页端微信扫码返回处理
* 需要有\App\Login\WechatWebLogin
*/

add_action('wp_ajax_wechat_web_login', 'vitara_ajax_wechat_web_login');
add_action('wp_ajax_nopriv_wechat_web_login', 'vitara_ajax_wechat_web_login');
function vitara_ajax_wechat_web_login(){
    
    $code=isset($_GET['code']) ? sanitize_text_field($_GET['code']) : '';
    $redirect=isset($_REQUEST['redirect']) ? sanitize_text_field($_REQUEST['redirect']) : '';
    $state=isset($_REQUEST['state']) ? sanitize_text_field($_REQUEST['state']) : '';
    $bind=isset($_REQUEST['bind']) ? sanitize_text_field($_REQUEST['bind']) : '';

    //是否是绑定微信号操作
    if(!empty($bind)) {
        $currentUser=\LizusContinue\User\User::current();
        if($currentUser->exist() && $currentUser->verifyBindCode($bind)) {
            $bind=true;
        }else {
            $bind=false;
        }
    }else {
        $bind=false;
    }
    if(empty($redirect)) {
        $redirect=get_bloginfo('url');
    }
    
    if (!empty($code) && \App\Login\WechatWebLogin::check_state($state)) {
        $url=\App\Login\WechatWebLogin::getAccessTokenUrl($code);
        $curl=new \Lizus\PHPCurl\PHPCurl(\App\Login\WechatWebLogin::curloptions());
        $data=$curl->get($url);
        if ($data['err']==0) {
            $data=json_decode($data['data'],true);
            $token=$data['access_token'] ?? '';
            $openid=$data['openid'] ?? '';
            if (!empty($token) && !empty($openid)) {
                $url=\App\Login\WechatWebLogin::getUserinfoUrl($token,$openid);
                $data=$curl->get($url);
                if ($data['err']==0) {
                    $data=json_decode($data['data'],true);
                    if (isset($data['openid'])) {
                        $login=new \App\Login\WechatWebLogin($data,$bind);
                        $user=$login->login();
                        //wp_redirect($redirect);
                        //die();
                    }
                }
            }
        }
    //}else {
    //    wp_redirect(get_bloginfo('url'));
    }
    wp_redirect(\LizusContinue\get_redirect_url($redirect));
    
    die();
}