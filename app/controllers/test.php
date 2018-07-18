<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * goods detail
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 *
 */
class Test extends Controller
{
		
	function Test()
	{
		parent::Controller();
		$this->load->database();
	}
	
	function index()
	{
		$c = get_url_content('http://detail.tmall.com/item.htm?spm=a220m.1000858.1000725.95.CBDzHy&id=35443951435&_u=i1j5eiq1849&areaId=&user_id=378537552&is_b=1&cat_id=50025145&q=&rn=ef206e0067ba46865bfa3463b3347d6b');
		$c = @iconv("gbk","utf-8//IGNORE",$c);
		preg_match_all('/<a href="#"><img src="((.*?)_60x60\.jpg)" \/><\/a>/i', $c, $a);
		print_r($a);exit();
		if(isset($a[0][0]))
		{
			$item_html = '';
			foreach($a[0] as $v)
			{
				if(strpos($v,'='.$num_iid) !== FALSE)
				{
					$item_html = $v;
				}
			}
			if($item_html)
			{
				preg_match('/<span class="s-price">(.*?)<\/span>/i', $item_html, $a);
				if(isset($a[1]) && $a[1])
				{
					$shop_price = trim($a[1]);
					preg_match('/<span class="c-price">(.*?)<\/span>/i', $item_html, $a);
					if(isset($a[1]) && $a[1]) $dc_price = trim($a[1]);
				}
				else
				{
					preg_match('/<span class="c-price">(.*?)<\/span>/i', $item_html, $a);
					if(isset($a[1]) && $a[1]) $shop_price = trim($a[1]);
				}
				
				preg_match('/<span class="sale-num">(.*?)<\/span>/i', $item_html, $a);
				if(isset($a[1])) $volume = trim($a[1]);
			}

		}
		
		//获取标题
		preg_match('/<title>(.*)<\/title>/i', $c, $a);
		$title = '';
		if(isset($a[1])) $title = str_replace('-tmall.com天猫','',str_replace('-淘宝网','',$a[1]));
		echo $title."\n\r";
		
		//获取价格
		$price = 0;
		preg_match('/"price" : "(\d+(\.\d+)?)"/i', $c, $a);
		if(isset($a[1])) $price = $a[1];
		echo $price."\n\r";
		
		//销量
		$volume = 0;
		preg_match('/"(http:\/\/detailskip\.taobao\.com\/json\/ifq\.htm.*)"/i', $c, $a);
		if(isset($a[1]))
		{
			$sale_c = get_url_content($a[1]);
			preg_match('/quanity: (\d+)/i', $sale_c, $a);
			if(isset($a[1])) $volume = $a[1];
		}
		echo $volume."\n\r";
		
		//昵称
		$nick = '';
		preg_match('/sellerNick:"(.*)"/i', $c, $a);
		if(isset($a[1]))
		{
			$nick = $a[1];
		}
		echo $nick."\n\r";
		
		//图片
		$pic_url = array();
		preg_match_all('/<img data-src="(.*)" \/>/i', $c, $a);
		if(isset($a[1]))
		{
			foreach($a[1] as $v)
			{
				$pic_url[] = substr($v,0,strrpos($v,'_'));
			}
		}
		print_r($pic_url);
		
		
		
		////内容
//		$content = '';
//		preg_match('/"(http:\/\/dsc\.taobaocdn\.com\/.*)"/i', $c, $a);
//		if(isset($a[1]))
//		{
//			$content = get_url_content($a[1]);
//			$content = ltrim($content,"var desc='");
//			$content = str_replace("';",'',$content);
//		}
//		echo $content."\n\r";
	}
}
?>