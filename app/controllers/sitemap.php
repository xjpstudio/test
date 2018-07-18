<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * product and info search page
 * @author		Soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 *
 */
class Sitemap extends Controller
{
	function Sitemap()
	{
		parent::Controller();
		$this->load->database();
	}
	
	function index()
	{
		if ($this->config->item('sys_cache_time') > 0) $this->output->cache($this->config->item('sys_cache_time'));
		$data = array(
			'site_title'		=> '网站地图--'.$this->config->item('sys_site_title'),
			'product'		=> $this->common_model->get_records('SELECT id,title FROM '.$this->db->dbprefix.'shop_product WHERE id >= FLOOR(RAND() * (SELECT MAX(id) FROM '.$this->db->dbprefix.'shop_product)) LIMIT 300'),
			'shop'		=> $this->common_model->get_records('SELECT id,title FROM '.$this->db->dbprefix.'shop WHERE id >= FLOOR(RAND() * (SELECT MAX(id) FROM '.$this->db->dbprefix.'shop)) LIMIT 100'),
			'news'		=> $this->common_model->get_records('SELECT id,title FROM '.$this->db->dbprefix.'shop_news WHERE id >= FLOOR(RAND() * (SELECT MAX(id) FROM '.$this->db->dbprefix.'shop_news)) LIMIT 300'),
			'nav' => ' &gt; 网站地图'
		);
		$this->load->view(TPL_FOLDER.'sitemap',$data); 
	}
}
?>