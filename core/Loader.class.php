<?php
/**
 * Created by PhpStorm.
 * User: boxcore
 * Date: 17/3/8
 * Time: 上午10:25
 */

//namespace RSS\Loader;

class Loader {

    public function __construct() {

    }

    public static function autoload($class_name){
        $class_file = strtolower($class_name).".php";
        if (file_exists($class_file)){
            require_once($class_file);
        }

    }

    public static function libs($class_name){
        $class_file = ROOT.'libs'.DS.$class_name.DS.$class_name.".php";
        if (file_exists($class_file)){
            require_once($class_file);
        }

    }
}

