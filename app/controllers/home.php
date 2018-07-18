<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
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
			'site_title' => $this->config->item('sys_site_title')
		);
		
		$rdata = array();
		$i = 0;
		foreach(get_cache('index_block') as $v)
		{
			if(isset($v['cat']) && $v['cat'] == 2) $rdata[$i]['items'] = $this->_get_shop($v); 
			else $rdata[$i]['items'] = $this->_get_product($v); 
			$rdata[$i]['item'] = $v;
			$i++;
		}
		$data['rdata'] = $rdata;
		
		if(TPL_FOLDER_NAME == 'meili')
		{
			$a = array();$i = 0;
			foreach(get_cache('ncatalog') as $v)
			{
				if($v->is_push == 1)
				{
					$a[$i]['b'] = $v;
					$a[$i]['item'] = $this->common_model->get_records('SELECT id,title,pic_path,summary FROM '.$this->db->dbprefix."shop_news WHERE catalog_id LIKE '%,{$v->id},%' ORDER BY seqorder DESC,id DESC LIMIT 21");
					$i++;
				}
			}
			$data['a'] = $a;
			$data['top_news'] = $this->common_model->get_records('SELECT id,title,hits FROM '.$this->db->dbprefix."shop_news ORDER BY hits DESC LIMIT 8");
		}
		else
		{
			$data['news'] = $this->common_model->get_records('SELECT id,title FROM '.$this->db->dbprefix."shop_news ORDER BY seqorder DESC,id DESC LIMIT 12");
		}
		$this->load->view(TPL_FOLDER.'home',$data);
	}
	
	function _get_product($v)
	{
		$sql = 'SELECT id,title,small_pic_path,shop_price,dc_price,volume,nick,num_iid FROM '.$this->db->dbprefix."shop_product WHERE 1=1";
		if($v['cid']) $sql .= " AND catalog_id like '%,".$v['cid'].",%'";
		if($v['q']) $sql .= " AND title like '%".$v['q']."%'";
		if($v['sp']) $sql .= " AND shop_price >= ".$v['sp'];
		if($v['ep']) $sql .= " AND shop_price <= ".$v['ep'];
		if($v['sorts']) 
		{
			if($v['sorts'] == 'p') $sql .= ' ORDER BY shop_price ASC';
			else if($v['sorts'] == 'pd') $sql .= ' ORDER BY shop_price DESC';
			else if($v['sorts'] == 'd') $sql .= ' ORDER BY volume DESC';
		} else $sql .= ' ORDER BY seqorder DESC,id DESC'; 
		$sql .= ' LIMIT 0,'.$v['num'];
		return $this->common_model->get_records($sql);
	}
	
	function _get_shop($v)
	{
		return $this->common_model->get_records('SELECT id,sid,title,pic_path FROM '.$this->db->dbprefix.'shop WHERE cid = '.$v['cid'].' ORDER BY seqorder DESC,id DESC LIMIT '.$v['num']);
	}
}
?>