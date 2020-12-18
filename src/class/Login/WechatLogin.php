<?php
namespace LizusContinue\Login;


/**
* WechatLogin
* 微信端浏览器登录处理
* 主题中使用的时候请确保在\App\Login\中使用同名类并填写$AppID和$AppSecret
*/
class WechatLogin extends LizusVitara\Login\Login
{    
    protected static $AppID='';
    protected static $AppSecret='';
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
                $this->formatedData['wx_'.$key]=$value;
            }else {
                $this->formatedData[$key]=$value;
            }
        }
        $this->formatedData['from']='微信内浏览器';
        $this->formatedData['user_login']=md5($this->formatedData['nickname'].microtime(true));
        $this->formatedData['user_email']=$this->formatedData['user_login'].'@'.$_SERVER['SERVER_NAME'];
        $this->formatedData['avatar']=$this->formatedData['headimgurl'];
        $this->formatedData['display_name']=$this->formatedData['nickname'];
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
    
    //用于生成向微信传递的验证state
    public static function create_state(){
        return md5(date('Y-m-d',time()));
    }
    
    /**
    * check_state
    * 接收微信端返回时的state是否一致，不一致的话，说明数据有问题，不应该往下处理
    * @param  string $state
    * @return boolean
    */
    public static function check_state(string $state){
        return $state ==self::create_state();
    }
    
    
    /**
    * getAPIUrl
    * 生成微信扫码地址，在网页中用iframe加载
    * $bind为true时开户绑定帐号模式，此时需要用户已登录
    * Note: 暂时关闭bind功能
    * 示例：
    * $url=WechatWebLogin::getAPIUrl(true); 
    * echo '<iframe src="'.$url.'" width="500" height="500"></iframe>';
    * @return string
    */
    public static function getAPIUrl($bind=false){
        $bind_code='';
        /*
        if(\is_user_logged_in() && $bind===true) {
            $user=wp_get_current_user();
            $user=new User($user->ID);
            $bind_code=$user->createBindCode();
        }
        */
        return 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.static::$AppID.'&redirect_uri='.urlencode(\LizusFunction\v_url(\get_bloginfo('url').'/ajax.php','action=wechat_login&bind='.$bind_code.'&redirect='.urlencode(\LizusFunction\get_current_url()))).'&state='.static::create_state().'&response_type=code&scope=snsapi_userinfo#wechat_redirect';
    }
    
    /**
    * getAccessTokenUrl
    * 生成获取用户access_token和openid的url，需要扫码返回的code
    * @param  string $code
    * @return string 
    */
    public static function getAccessTokenUrl(string $code){
        return 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.static::$AppID.'&secret='.static::$AppSecret.'&code='.$code.'&grant_type=authorization_code';
    }
    
    /**
    * getUserinfoUrl
    * 生成获取微信用户信息的url
    * @param  mixed $token
    * @param  mixed $openid
    * @return void
    */
    public static function getUserinfoUrl($token,$openid){
        return 'https://api.weixin.qq.com/sns/userinfo?access_token='.$token.'&openid='.$openid;
    }
}