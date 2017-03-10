<?php

require 'rss_spider.init.php';

$rss_conf = array();
$rss_conf = array(
    'name' => '简明现代魔法',
    'mark' => 'nowamagic',
    'host' => 'nowamagic.net',
    'type' => 1,
    'list' => array(
        'url' => '/'
    ),
    'content' => array(

    ),
);

$url_list = "http://www.nowamagic.net/librarys/veda/feed/";
throw_log("开始获取列表：$url_list");
$html     = gethtml($url_list);
if($html =='error'){
    throw_log("获取列表异常");
    exit(-1);
}

// phpQuery::newDocumentXML($html);
// $source = pq('link');
// $div = $source->html();
preg_match_all('#</title><link>(.*?)</link><comments>#i',$html,$rs);
 //print_r($rs);exit;
if(!empty($rs[1])){
    $url_cnt = count($rs[1]);
    throw_log("获取到{$url_cnt}篇文章");
    $header     = '<?xml version="1.0" encoding="utf-8"?><rss version="2.0"><channel><title>'.$rss_conf['name'].'</title>';
    $footer     = '</channel></rss>';
    $rss = '';
    $i = 1;
    foreach($rs[1] as $url){
        throw_log("开始处理第{$i}篇文章： {$url}");
        $url_html = gethtml($url);
        if(($url_html =='error')){
            throw_log("没有获取到内容： {$url}");
        }

        phpQuery::newDocument($url_html);
        $content = pq('.post_content')->html();
        $title = pq('#content_area h1 a')->html();
        $content = trim($content);

        if($content){
            $rss.='<item><title>'.$title.'</title><link><![CDATA['.$url.']]></link><description><![CDATA['.$content.']]></description></item>';
            throw_log("获取文章成功！标题： $title");

        }else{
            throw_log("获取文章异常！地址： $url");
        }
        $i++;

        //print_r($rss);exit;

    }

    if($rss){
        $rss_path = RSS_STATIC . $rss_conf['mark'].'.xml';
        $rss_url = RSS_URL . $rss_conf['mark'].'.xml';
        file_put_contents($rss_path, $header. $rss. $footer);

        throw_log("RSS已生成！feed地址： {$rss_url}");

    }else{
        throw_log("获取文章规则异常！");
    }
}
