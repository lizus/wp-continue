<?php
namespace LizusContinue\Login;


/**
* WechatOffiLogin
* 微信公众号扫码关注后登录处理
* 主题中使用的时候请确保使用App\Login\WechatOffiLogin来继承
*/
class WechatOffiLogin extends \LizusVitara\Login\Login
{
    /**
    * existUserQuery
    * 设置已存在用户的查询语句
    * @return array
    */
    protected function existUserQuery(){
        $unionid=$this->sourceData['unionid'];
        $args=[];
        if (!empty($unionid)) {
            $args=array(
                'meta_key'=>\LizusFunction\v_key('unionid','user'),
                'meta_value'=>$unionid,
            );
        }
        return $args;
    }
    
    protected function sourceDataFormat(){
        foreach ($this->sourceData as $key => $value) {
            if($key=='openid') {
                $this->formatedData['offi_'.$key]=$value;
            }else {
                $this->formatedData[$key]=$value;
            }
        }
        /**
         * 微信调整策略，从公众号扫码过来的用户拿不到头像和昵称，id的生成改用openid来生成，去掉头像，同时将昵称改为和id一样。
         */
        $user_login=md5($this->formatedData['openid'].microtime(true));
        $this->formatedData['from']='PC端微信公众号扫码';
        $this->formatedData['user_login']=$user_login;
        $this->formatedData['user_email']=$this->formatedData['user_login'].'@'.$_SERVER['SERVER_NAME'];
        $this->formatedData['avatar']='';
        $this->formatedData['display_name']=$user_login;
        return $this;
    }
    
    /**
    * removeExistBind
    * 清除已有绑定，微信渠道还需要清除个人号，小程序，公众号的绑定，openid,xcx_openid,offi_openid
    * @param  mixed $uid
    * @return void
    */
    protected function removeExistBind($uid){
        foreach ($this->sourceData as $key => $value) {
            \delete_user_meta($uid,\LizusFunction\v_key($key,'user'));
        }
        \delete_user_meta($uid,\LizusFunction\v_key('web_openid','user'));
        \delete_user_meta($uid,\LizusFunction\v_key('wx_openid','user'));
        \delete_user_meta($uid,\LizusFunction\v_key('xcx_openid','user'));
        \delete_user_meta($uid,\LizusFunction\v_key('offi_openid','user'));
    }
}