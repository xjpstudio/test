<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * goods search page
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 *
 */
class Shop extends Controller
{
		
	function Shop()
	{
		parent::Controller();
		$this->load->database();
	}
	
	function index()
	{
		$sid = $this->uri->segment(2,0);
		$offset = $this->uri->segment(3,0);
		
		$shop = $this->common_model->get_record('SELECT title,btitle,sid,nick,pic_path,keyword,description FROM '.$this->db->dbprefix.'shop WHERE id = ?',array($sid));
		if( ! $shop) echo_msg('<li>浏览的店铺不存在</li>');
		
		$sql = 'SELECT id,title,small_pic_path,shop_price,dc_price,volume,nick,love,num_iid FROM '.$this->db->dbprefix.'shop_product WHERE sid = '.$sid.' ORDER BY id DESC';
		
		$page_size = 48;
		$page = array(
			'page_base' => CTL_FOLDER.'shop/'.$sid,
			'offset'   => $offset,
			'per_page' => $page_size,
			'sql' => $sql
		);
		$query = $this->common_model->get_pages_records($page);
		
		$data = array(
			'site_title'		=> $shop->title.'--'.$this->config->item('sys_site_title'),
			'query'		=> $query['query'],
			'paginate'		=> $query['paginate'],
			'shop' => $shop,
			'page_keyword'		=> $shop->keyword?$shop->keyword:$shop->title,
			'page_description'		=> $shop->description?$shop->description:$shop->title
		);
		if($shop->btitle) $data['site_title'] = str_replace('{title}',$shop->title,str_replace('{site_title}',$this->config->item('sys_site_title'),$shop->btitle));
		$this->load->view(TPL_FOLDER.'shop',$data);
	}
}
?>