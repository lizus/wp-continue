<?php

// ---=*--*=*-=*-=-*-=* 🌹 *---=*--*=*-=*-=-*-=*
/**
* 用于微信端浏览器登录返回处理
* 需要有\App\Login\WechatLogin
*/

add_action('wp_ajax_wechat_login', 'vitara_ajax_wechat_login');
add_action('wp_ajax_nopriv_wechat_login', 'vitara_ajax_wechat_login');
function vitara_ajax_wechat_login(){
    
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
    
    if (!empty($code) && \App\Login\WechatLogin::check_state($state)) {
        $url=\App\Login\WechatLogin::getAccessTokenUrl($code);
        $curl=new \Lizus\PHPCurl\PHPCurl();
        $data=$curl->get($url);
        if ($data['err']==0) {
            $data=json_decode($data['data'],true);
            $token=$data['access_token'] ?? '';
            $openid=$data['openid'] ?? '';
            if (!empty($token) && !empty($openid)) {
                $url=\App\Login\WechatLogin::getUserinfoUrl($token,$openid);
                $data=$curl->get($url);
                if ($data['err']==0) {
                    $data=json_decode($data['data'],true);
                    if (isset($data['openid'])) {
                        $login=new \App\Login\WechatLogin($data,$bind);
                        $user=$login->login();
                        if(!empty($redirect)) {
                            wp_redirect($redirect);
                        }else {
                            wp_redirect(get_bloginfo('url'));
                        }
                        die();
                    }
                }
            }
        }
    }else {
        wp_redirect(get_bloginfo('url'));
    }
    
    die();
}