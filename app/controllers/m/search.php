<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * goods search page
 * @author		Jade Xia
 * @copyright	Copyright (c) 2010 - 2011 天夏网络.
 * @link		http://www.tianxianet.com
 *
 */
class Search extends Controller
{
		
	function Search()
	{
		parent::Controller();
		$this->load->database();
	}
	
	function index()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		$sql = 'SELECT id,title,small_pic_path,shop_price,dc_price,volume,nick,love,num_iid FROM '.$this->db->dbprefix.'shop_product WHERE 1=1';
		if(isset($get['q']) && ! empty($get['q'])) $sql .= " AND title like '%{$get['q']}%'";
		if(isset($get['cid']) && $get['cid'] > 0) $sql .= " AND catalog_id like '%,{$get['cid']},%'";
		$sql .= ' ORDER BY seqorder DESC,id DESC LIMIT 0,20';
		
		$data = array(
			'site_title'		=> '商品搜索',
			'query'		=> $this->common_model->get_records($sql)
		);
		$data['get'] = $get;
		unset($get);
		$this->load->view(TPL_FOLDER.'search',$data);
	}
}
?>