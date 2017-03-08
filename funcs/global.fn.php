<?php
/**
 * Created by PhpStorm.
 * User: boxcore
 * Date: 17/3/8
 * Time: 上午9:58
 */

/**
 * @param        $url
 * @param null   $json
 * @param string $code
 * @return mixed|string
 */
function gethtml($url,$json=null,$code='UTF-8'){
    $args = array();
    if($json) $args = json_decode($json,true);
    $useragent = isset($args["useragent"]) ? $args["useragent"] : 'Mozilla/5.0';
    $timeout = isset($args["timeout"]) ? $args["timeout"] : 9000;
    $ch = curl_init();
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => $useragent,
        CURLOPT_TIMEOUT_MS => $timeout,
        CURLOPT_NOSIGNAL => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FOLLOWLOCATION => 1
    );
    if(isset($args["ip"])){
        $options[CURLOPT_HTTPHEADER] = array('CLIENT-IP:'.$args["ip"],'X-FORWARDED-FOR:'.$args["ip"]);
    }
    if (preg_match('/^https/',$url)){
        $options[CURLOPT_SSL_VERIFYHOST] = 1;
        $options[CURLOPT_SSL_VERIFYPEER] = 0;
    }
    curl_setopt_array($ch, $options);
    $data = curl_exec($ch);
    if($code != 'UTF-8'){
        $data = iconv($code, "UTF-8", $data); 
    }
    
    $curl_errno = curl_errno($ch);
    curl_close($ch);
    if($curl_errno>0){
        return 'error';
    }else{
        return $data;
    }
}

/**
 * 自定义抛出日志格式
 *
 * @author boxcore
 * @date   2015-01-31
 * @param  string     $str
 * @return string
 */
function throw_log($str, $is_return=false){
    $s = '['.date('Y-m-d H:i:s').']';
    $s .= basename($_SERVER['SCRIPT_NAME']);
    $s .= ': ' . trim($str)."\n";
    if($is_return){
        return $s;
    }
    echo $s;
}