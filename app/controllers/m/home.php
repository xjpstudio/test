<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author		Jade Xia
 * @copyright	Copyright (c) 2010 - 2011 天夏网络.
 * @link		http://www.tianxianet.com
 */
class Home extends Controller
{
	function Home()
	{
		parent::Controller();
		$this->load->database();
	}
	
	function index()
	{
		if ($this->config->item('sys_cache_time') > 0) $this->output->cache($this->config->item('sys_cache_time'));
		$data = array(
			'site_title' => $this->config->item('sys_site_title'),
			'top_product' => $this->common_model->get_records('SELECT id,title,small_pic_path,shop_price,dc_price,volume,nick FROM '.$this->db->dbprefix."shop_product ORDER BY id DESC LIMIT 15")
		);
		$this->load->view(TPL_FOLDER.'home',$data);
	}
}
?>