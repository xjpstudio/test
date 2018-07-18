<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * goods detail
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 *
 */
class Shops extends Controller
{
		
	function Shops()
	{
		parent::Controller();
		$this->load->database();
		if ($this->config->item('sys_cache_time') > 0) $this->output->cache($this->config->item('sys_cache_time'));
	}
	
	function index()
	{
		$data = array(
			'site_title'	=> '店铺导航--'.$this->config->item('sys_site_title')
		);
		$this->load->view(TPL_FOLDER.'shops',$data);
	}
}
?>