<?php

/**
 * 用于载入模板文件，使用时：
 * $load=\LizusContinue\Util\Load::getInstance();
 * $load->loadHeader('default',$data);
 * 即可载入header/header-default.php文件
 * 
 * 子类继承只需更换$path_root路径，即可更换不同的模板地址
 */

namespace LizusContinue\Util;

class Load {
    protected $path_root='template/';//根目录

    private static $_instance=[];
    private function __construct(){ }
    public static function getInstance(){
        $name=\get_called_class();
        if(!isset(self::$_instance[$name])) {
            self::$_instance[$name]= new $name();
        }
        return self::$_instance[$name];
    }
    private function __clone() {
        trigger_error('Clone is not allow!',E_USER_ERROR);
    }
    protected function load_template($path,$name,$data=[]) {
        if(!empty($data) && is_array($data)) \LizusContinue\set_temp($data);
        \get_template_part($this->path_root.$path.'/'.$path,$name);
    }

    public function __call($name,$args){
        /**
         * 调用形如loadHeader($name,$data)的方法的时候，载入$path_root.'/header-'.$name.php的模板
         */
        if(\preg_match('/load([A-Z0-9][_a-zA-Z0-9]*)/',$name,$m)) {
            $path=\lcfirst($m[1]);
            $name=$args[0] ?? '';
            $data=(isset($args[1]) && is_array($args[1])) ? $args[1] : [];
            return $this->load_template($path,$name,$data);
        }
        /**
         * 使用getHeader($name,$data)的方法的时候，获取模板的内容可以存储在变量中
         */
        if(\preg_match('/get([A-Z0-9][_a-zA-Z0-9]*)/',$name,$m)) {
            \ob_start();
            $path=\lcfirst($m[1]);
            $name=$args[0] ?? '';
            $data=(isset($args[1]) && is_array($args[1])) ? $args[1] : [];
            $this->load_template($path,$name,$data);
            $rs=\ob_get_contents();
            \ob_end_clean();
            return $rs;
        }
    }
}