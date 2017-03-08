<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

if(!defined('DS'))   define('DS', DIRECTORY_SEPARATOR);       // 设定系统分割符号
if(!defined('ROOT')) define('ROOT', dirname(__FILE__).DS);    // 设定系统目录


require ROOT.'funcs/global.fn.php';

require ROOT . 'core/Loader.class.php';
spl_autoload_register('Loader::libs');
