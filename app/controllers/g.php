<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Click
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 *
 */
class G extends Controller
{
		
	function G()
	{
		parent::Controller();
	}
	
	function index()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		if(isset($get['u']) && $get['u'] != '')
		{
			$click_url = authcode($get['u']);
			redirect($click_url);
		}
		else
		{
			echo_msg('<li>提交的url参数有误</li>');
		}
	}
}
?>