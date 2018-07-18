<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*1、采集的详细内容 过滤部分代码 比方js 2、图片路径是否为相对路径 这个要替换为绝对路径3、可以按分类入库4、相同标题将不入库*/
class Spider
{    
	// 第一页网址    
	var $url;    
	// 列表超链接开始    
	var $list_link_s;    
	// 列表超链接结束    
	var $list_link_e;   
	//采集页面的网页编码    
	var $charset;
	
	function __construct()
	{
		
	}
	
	function init($a)
	{
		foreach($a as $k => $v)
		{
			$this->$k = $v;
		}
	}
	
	/**   
	* 得到页面内容   
	* @return String 列表页面内容   
	*/   
	function get_page_content($url)
	{                    
		$c = get_content($url);
		if($c) $c = @iconv($this->charset,'utf-8//IGNORE',$c);
		if($this->charset == 'gbk')
		{
			$t =& get_instance();
			$t->load->library('trans');
			$c = $t->trans->t2c($c);
		}
		return $c;
	}    
	/**   
	* 根据标记得到列表段   
	* @param $content 页面源数据   
	* @return String   列表段内容   
	*/   
	function get_block_content( $content,$ps,$pe )    
	{    
	   $content = $this->getContent( $content,$ps,$pe);
	   if(!$content) $content=$this->cut($content,$ps,$pe);    
	   return $content;    
	} 
	
	/**   
	* 根据标记得到列表段   
	* @param $content 页面源数据   
	* @return String   列表段内容   
	*/   
	function cut( $content,$ps,$pe )    
	{    
	   $sp = strpos($content,$ps);
	   $se = strpos($content,$pe);
	   if($sp !== FALSE && $se !== FALSE)
	   return substr($content,$sp+1,$se - $sp);
	   else
	   return '';
	} 
	   
	/**   
	* 得到一个字符串中的某一部分   
	* @param $sourceStr 源数据   
	* @return boolean 操作成功返回true   
	*/   
	function getContent ( $sourceStr,$ps,$pe)    
	{    
	   $s = preg_quote($ps);    
	   $e = preg_quote($pe);    
	   $s = str_replace( " ", "[[:space:]]", $s );    
	   $e = str_replace( " ", "[[:space:]]", $e );    
	   $s = str_replace( "\r\n", "[[:cntrl:]]", $s );    
	   $e = str_replace( "\r\n", "[[:cntrl:]]", $e );     
	   preg_match_all( "@" . $s . "(.*?)". $e ."@is", $sourceStr, $tpl );     
	   $content = $tpl[1];    
	   $content = implode( "", $content );
	   return $content;    
	}    
	
	/**   
	* 得到只含有连接和内容的列表数组   
	* @param $sList 页面列表源数据   
	* @return array 列表段内容   
	*/   
	function getSourceList ( $sList )    
	{    
	   $s = preg_quote( $this->list_link_s  );    
	   $e = preg_quote( $this->list_link_e  );    
	   $s = str_replace( " ", "[[:space:]]", $s );    
	   $e = str_replace( " ", "[[:space:]]", $e );    
	   $s = str_replace( "\r\n", "[[:cntrl:]]", $s );    
	   $e = str_replace( "\r\n", "[[:cntrl:]]", $e );     
	   preg_match_all( "@" . $s . "(.*?)". $e ."@is", $sList, $tpl );
	   $content = $tpl[1]; 
	   $content = implode( '', $content );
	   return $this->getList($content);
	}   
	
	/**   
	* 得到列表内容   
	* @param $list 列表段内容   
	* @return array 含有标题和连接的数组
	*/   
	function getList ( $list )    
	{    
	    $a = array();
		preg_match_all('/<a(.*?)href=([^>\f\r\n\t\v\s]+)(.*?)>(.*?)<\/a>/i', $list, $temp); 
		$i = 0; 
		if(is_array($temp[2]))
		{
			foreach($temp[2] as $row)
			{
				$row = trim(trim($row,'"'),"'");
				$a[$i]['title'] = $this->clear_html($temp[4][$i]);
				if( strpos( strtolower($row), "http" ) !== 0 )    
				{    
				  $aurl = parse_url($this->url);
				  $url = $aurl['scheme'].'://'.$aurl['host'].'/'.ltrim($row,'/');
				} else $url = $row;
				$a[$i]['url'] = $url;
				$i++;
			}
		}
		return $a;
	}  
	
	/**   
	* 移除详细正文内容部分html代码  
	* @param $c 要过滤的内容   
	* @return string 过滤之后的字符
	*/   
	function remove_html( $document )    
	{    
		$document = trim($document);
		if (strlen($document) <= 0)
		{
		  return $document;
		}
		$search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
						"'<vbscript[^>]*?>.*?</vbscript>'si",  // 去掉 vbscript
						  "'<style[^>]*?>.*?</style>'si",          // style
						  "'<object[^>]*?>.*?</object>'si",          // object
						  "'<link[^>]*?/>'si",          // style
						  "'<a[^>]*?>'si",          // a
						  "'</a>'si",          // a
						   "'<meta[^>]*?/>'si",          // meta
						  "'<iframe[^>]*?>.*?</iframe>'si",          // iframe
						  "'<frameset[^>]*?>.*?</frameset>'si",          // frameset
						  "'<frame[^>]*?>.*?</frame>'si",          // iframe
						  "'<form[^>]*?>.*?</form>'si",          // form
						  "'<applet[^>]*?>.*?</applet>'si",          // form
						  "'<body[^>]*?>.*?</body>'si",          // body
						  "'<html[^>]*?>.*?</html>'si",          // html
						  "'<head[^>]*?>.*?</head>'si"          // head
				  );// 作为 PHP 代码运行
		
		$replace = array ('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
		return @preg_replace ($search, $replace, $document);
	}  
	
	/**   
	* 过滤html代码  
	* @param $c 要过滤的内容   
	* @return string 过滤之后的字符
	*/   
	function clear_html( $document )    
	{    
		$document = trim($document);
		if (strlen($document) <= 0)
		{
		  return $document;
		}
		$search = array("'<[\/\!]*?[^<>]*?>'si","'([\r\n\t])[\s]+'");
		$replace = array ('', '');
		return @preg_replace($search, $replace, $document);
	}  
	
	/**   
	* 把正文中的图片相对路径 替换为绝对路径 
	* @param $c 要过滤的内容   
	* @return string 过滤之后的字符
	*/   
	function r_to_a($c)
	{    
		$aurl = parse_url($this->url);
		$url = $aurl['scheme'].'://'.$aurl['host'].'/';
		$c = @preg_replace('/(?<=src=[\'"])(?!(\/|http:))/si', $url, $c);
		$c = @preg_replace('/(?<=src=[\'"])(?=\\/)/si', rtrim($url,'/'), $c);
		return $c;
	}  
}
?> 