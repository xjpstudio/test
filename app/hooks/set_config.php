<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * config hooks
 * @author		Jade Xia
 * @copyright	Copyright (c) 2010 - 2011 天夏网络.
 * @link		http://www.tianxianet.com
 */
class set_config
{
	function set_path()
	{
		global $URI,$CFG;
		$segment = $URI -> segment(1);
		if( $segment == 'tadmin' )
		{
			define('CTL_FOLDER','tadmin/');
			define('TPL_FOLDER','tadmin/');
			define('TPL_PATH',ROOT_PATH.VIEW_PATH.TPL_FOLDER);
		}
		else if( $segment == 'm')
		{
			define('CTL_FOLDER','m/');
			define('TPL_FOLDER','m/');
			define('TPL_PATH',ROOT_PATH.VIEW_PATH.TPL_FOLDER);
			$CFG->load('shop_site_config');
			$CFG->load('mobile_config');
		}
		else
		{
			define('CTL_FOLDER','');
			define('TPL_FOLDER',TPL_FOLDER_NAME.'/');
			define('TPL_PATH',ROOT_PATH.VIEW_PATH.TPL_FOLDER);
			$CFG->load('shop_site_config');
			$CFG->load('rd_type');
		}
	}
}
?>