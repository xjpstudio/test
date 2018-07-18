<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * goods detail
 * @author		Jade Xia
 * @copyright	Copyright (c) 2010 - 2011 天夏网络.
 * @link		http://www.tianxianet.com
 *
 */
class Ajax extends Controller
{
	function Ajax()
	{
		parent::Controller();
		$this->load->database();
	}
	
	function get_product()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		$page = 2;
		$page_size = 20;
		if(isset($get['page']) && $get['page'] > 0) $page = $get['page'];
		$offset = ($page - 1) * $page_size;
		$sql = 'SELECT id,title,small_pic_path,shop_price,dc_price,volume,nick,love,num_iid FROM '.$this->db->dbprefix.'shop_product WHERE 1=1';
		if(isset($get['q']) && ! empty($get['q'])) $sql .= " AND title like '%{$get['q']}%'";
		if(isset($get['cid']) && $get['cid'] > 0) $sql .= " AND catalog_id like '%,{$get['cid']},%'";
		$sql .= ' ORDER BY seqorder DESC,id DESC LIMIT '.$offset.','.$page_size;
		$query = $this->common_model->get_records($sql);
		if( ! $query) diem('nodata');
		
		$data = array(
			'query'		=> $query
		);
		unset($get);
		$this->load->view(TPL_FOLDER.'get_product',$data);
	}
}
?>