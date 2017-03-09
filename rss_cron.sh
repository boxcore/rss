#!/usr/bin/env bash

RSS_DIR='/home/wwwroot/rss.jp.laikansha.com/'

php ${RSS_DIR}'rss_spider/freebuf.rss.php'
php ${RSS_DIR}'rss_spider/dbaplus.rss.php'
php ${RSS_DIR}'rss_spider/dataguru.rss.php'
php ${RSS_DIR}'rss_spider/laravel-china.rss.php'