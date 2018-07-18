<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * goods detail
 * @author		Soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 *
 */
class Item extends Controller
{
		
	function Item()
	{
		parent::Controller();
		$this->load->database();
	}
	
	function index()
	{
		$rd_id=$this->uri->segment(2,0);
		if( ! preg_match( '/^[1-9]\d*$/',$rd_id)) echo_msg('<li>很抱歉，您浏览的商品不存在。</li>');
		$query = $this->common_model->get_record('SELECT * FROM '.$this->db->dbprefix.'shop_product WHERE id = ?',array($rd_id));
		if ( ! $query) echo_msg('<li>很抱歉，您浏览的商品不存在。</li>');
		$this->db->simple_query('UPDATE '.$this->db->dbprefix.'shop_product SET hits = hits + 1 WHERE id = '.$rd_id);
		
		$data = array(
			'site_title'		=> $query->title.'--'.$this->config->item('sys_site_title'),
			'product'		=> $query,
			'pic' => $this->common_model->get_records('SELECT * FROM '.$this->db->dbprefix.'shop_product_image WHERE product_id = ?',array($rd_id)),
			'page_keyword'		=> $query->keyword?$query->keyword:$query->title,
			'page_description'		=> $query->description?$query->description:$query->title,
			'relate'   => $this->_get_related_product($rd_id,10,$query->catalog_id),
			'nav' => $this->_get_nav($query->catalog_id)
		);
		if($query->btitle) $data['site_title'] = str_replace('{title}',$query->title,str_replace('{site_title}',$this->config->item('sys_site_title'),$query->btitle));
		
		$com = $this->common_model->get_record('SELECT COUNT(*) AS num FROM '.$this->db->dbprefix.'shop_comment WHERE product_id = ? AND is_pass = 1',array($rd_id));
		$data['com_num'] = $com->num;
		unset($com);
		
		//props
		if($query->props_name)
		{
			$pn = explode(';',$query->props_name);
			$n_pn = array();
			foreach($pn as $v)
			{
				$spn = explode(':',$v);
				$n_pn[$spn[0].':'.$spn[1]] = array($spn[2] => $spn[3]);
			}
			unset($pn);
			$kong = array();
			foreach($n_pn as $v)
			{
				$kong = array_merge_recursive($kong,$v);
			}
			$data['props'] = $kong;
			unset($kong);
		}
		else
		{
			$data['props'] = array();
		}
		unset($query);
		$this->load->config('comment_config');
		$this->load->view(TPL_FOLDER.'item',$data);
	}
	
	function _get_related_product($id,$n=8,$c='')
	{
		$sql = 'SELECT id,title,small_pic_path,dc_price,shop_price,volume,num_iid FROM '.$this->db->dbprefix."shop_product WHERE id != ".$id.' AND id >= FLOOR(RAND() * (SELECT MAX(id) FROM '.$this->db->dbprefix.'shop_product))';
		if($c) 
		{
			$c = trim($c,',');
			$c = explode(',',$c);
			$c = $c[0];
			$sql .= " AND catalog_id like '%,".$c.",%'";
		}
		$sql .= ' LIMIT 0,'.$n;
		return $this->common_model->get_records($sql);
	}
	
	function _get_nav($catalog_id)
	{
		$def = ' &gt; <a href="'.my_site_url(CTL_FOLDER.'search').'">商品列表</a>';
		if(strpos($catalog_id,',') !== FALSE)
		{
			$catalog_id = trim($catalog_id,',');
			$catalog_id = explode(',',$catalog_id);
			$mid = max($catalog_id);
			$query = $this->common_model->get_record('SELECT queue FROM '.$this->db->dbprefix."shop_product_catalog WHERE id = {$mid}");
			if( ! $query) return $def;
			if( ! $query->queue) return $def;
			$queue = trim($query->queue,',');
			$query = $this->common_model->get_records('SELECT cat_name,id FROM '.$this->db->dbprefix.'shop_product_catalog WHERE id in('.$queue.') ORDER BY deep_id ASC');
			$str='';
			foreach($query as $row)
			{
				$str.=' &gt; <a href="'.my_site_url(CTL_FOLDER.'search').'?cid='.$row->id.'">'.$row->cat_name.'</a>';
			}
			return $str;
		}
		else
		{
			return $def;
		}
	}
}
?>