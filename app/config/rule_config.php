<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| qq login config
| -------------------------------------------------------------------
*/
$config['rule_config'] = array(
	array('reg' => '/<a(.*?)href="(.*?)\/(item\.htm|guang\-detail\.html)\?id=(\d+)(.*?)"(.*?)>/i','offset' =>4),
	array('reg' => '/<a(.*?)href="(.*?)\/detail\.htm\?(.*?)contentId=(\d+)(.*?)"(.*?)>/i','offset' =>4),
	array('reg' => '/href="http:\/\/(item\.taobao\.com|detail\.tmall\.com)\/item\.htm\?id=(\d+)&?(.*?)"/i','offset' =>2),
	array('reg' => '/\/d\/goods\/detail\?item_id=(\d+)/i','id'=>4,'offset' =>1),
	array('reg' => '/contentId=(\d+)/i','offset' =>1),
	array('reg' => '/"nid":"(\d+)"/i','offset' =>1),
	array('reg' => '/data-id="(\d+)\_(\d+)"/i','offset' =>2),
	array('reg' => '/detail\/(\d+)\.html/i','offset' =>1)
);
?>