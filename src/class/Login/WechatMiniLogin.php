<?php
namespace LizusContinue\Login;


/**
* WechatMiniLogin
* 微信小程序登录处理
* 该渠道不可用于绑定帐号
* 主题中使用的时候请确保在\App\Login\中使用同名类并填写$AppID和$AppSecret
*/
class WechatMiniLogin extends LizusVitara\Login\Login
{
    protected static $AppID='';
    protected static $AppSecret='';

    public function __construct($data){
        parent::__construct($data,false);
    }
    
    /**
    * existUserQuery
    * 设置已存在用户的查询语句
    * @return array
    */
    protected function existUserQuery(){
        $openid=$this->sourceData['openid'];
        $unionid=$this->sourceData['unionid'];
        $args=[];
        if (!empty($openid)) {
            $args=array(
                'meta_key'=>\LizusFunction\v_key('xcx_openid','user'),
                'meta_value'=>$openid,
            );
        }
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
                $this->formatedData['xcx_'.$key]=$value;
            }else {
                $this->formatedData[$key]=$value;
            }
        }
        $this->formatedData['from']='微信小程序';
        $this->formatedData['user_login']=md5($this->formatedData['nickname'].microtime(true));
        $this->formatedData['user_email']=$this->formatedData['user_login'].'@'.$_SERVER['SERVER_NAME'];
        $this->formatedData['avatar']=$this->formatedData['headimgurl'];
        $this->formatedData['display_name']=$this->formatedData['nickname'];
        return $this;
    }
    
    protected function removeExistBind($uid){}
    
    /**
    * getOpenid
    * 通过code获得用户openid和unionid
    * @param  mixed $code
    * @return void
    */
    public static function getOpenid(string $code){
        return 'https://api.weixin.qq.com/sns/jscode2session?appid='.static::$AppID.'&secret='.static::$AppSecret.'&js_code='.$code.'&grant_type=authorization_code';
    }
    
}