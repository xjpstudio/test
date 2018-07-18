<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * goods search page
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
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
		$this->load->config('price_range');
		$sql = '';
		if(isset($get['q']) && ! empty($get['q'])) $sql .= " AND title like '%{$get['q']}%'";
		if(isset($get['cid']) && $get['cid'] > 0) $sql .= " AND catalog_id like '%,{$get['cid']},%'";
		if(isset($get['p']) && $get['p'] > 0)
		{
			foreach($this->config->item('price_range') as $v)
			{
				if($v['id'] == $get['p'])
				{
					$sql .= " AND shop_price >= {$v['s']}"; 
					$sql .= " AND shop_price <= {$v['e']}";
					break;
				}
			}
		}
		else
		{
			if(isset($get['sp']) && $get['sp'] > 0) $sql .= " AND shop_price >= {$get['sp']}"; 
			if(isset($get['ep']) && $get['ep'] > 0) $sql .= " AND shop_price <= {$get['ep']}";
		}
		
		$sqlt = 'SELECT COUNT(*) AS num FROM '.$this->db->dbprefix.'shop_product WHERE 1=1'.$sql;
		$query = $this->common_model->get_record($sqlt);
		$total = $query->num;
		unset($query);
		
		if(isset($get['sorts']) && $get['sorts'])
		{
			if($get['sorts'] == 'p') $sql .= ' ORDER BY shop_price ASC';
			else if($get['sorts'] == 'pd') $sql .= ' ORDER BY shop_price DESC';
			else if($get['sorts'] == 'd') $sql .= ' ORDER BY volume DESC';
			else $sql .= ' ORDER BY seqorder DESC,id DESC';
		} else $sql .= ' ORDER BY seqorder DESC,id DESC';
		
		$sql = 'SELECT id FROM '.$this->db->dbprefix.'shop_product WHERE 1 = 1'.$sql;
		$offset = $this->uri->segment(2, 0);
		$page_size = 48; 
		$page = array(
			'page_base' => CTL_FOLDER.'search',
			'offset'   => $offset,
			'per_page' => $page_size,
			'sql' => $sql,
			'total_rows' => $total
		);
		$query = $this->common_model->get_pages_records($page);
		$str = '';
		foreach($query['query'] as $row)
		{
			$str .= $row->id.',';
		}
		$str = rtrim($str,',');
		
		$data = array(
			'site_title'		=> '商品搜索-'.$this->config->item('sys_site_title'),
			'query'		=> array(),
			'paginate'		=> $query['paginate'],
			'nav' => ' &gt; 商品搜索',
			'total' => $total,
			'news' => $this->common_model->get_records('SELECT id,title FROM '.$this->db->dbprefix."shop_news ORDER BY seqorder DESC,id DESC LIMIT 30")
		);
		
		$sql = ' ORDER BY seqorder DESC,id DESC';
		if(isset($get['sorts']) && $get['sorts'])
		{
			if($get['sorts'] == 'p') $sql = ' ORDER BY shop_price ASC';
			else if($get['sorts'] == 'pd') $sql = ' ORDER BY shop_price DESC';
			else if($get['sorts'] == 'd') $sql = ' ORDER BY volume DESC';
		}
		
		if($str) $data['query'] = $this->common_model->get_records('SELECT id,title,small_pic_path,shop_price,dc_price,volume,nick,love,num_iid FROM '.$this->db->dbprefix.'shop_product WHERE id IN('.$str.')'.$sql);
				
		if(isset($get['q']) && ! empty($get['q']))
		{
			$data['site_title'] = $get['q'].'-'.$this->config->item('sys_site_title');
			$data['nav'] = ' &gt; 搜索'.$get['q'];
		}
		
		$cat = get_cache('catalog');
		if(isset($get['cid']) && $get['cid'] > 0)
		{
			foreach($cat as $row)
			{
				if($get['cid'] == $row->id)
				{
					$cur_cat = $row;
					$data['site_title'] = $row->cat_name.'-'.$this->config->item('sys_site_title');
					if(isset($row->btitle) && $row->btitle) $data['site_title'] = str_replace('{title}',$row->cat_name,str_replace('{site_title}',$this->config->item('sys_site_title'),$row->btitle));
					if($row->keyword) $data['page_keyword'] = $row->keyword;
					if($row->description) $data['page_description'] = $row->description;
					break;
				}
			}
			if(isset($cur_cat))
			{
				$str='';
				foreach($cat as $row)
				{
					if(strpos($cur_cat->queue,','.$row->id.',') !== FALSE)
					{
						$str.=' &gt; <a href="'.my_site_url(CTL_FOLDER.'search').'?cid='.$row->id.'">'.$row->cat_name.'</a>';
					}
				}
				$data['nav'] = $str;
				
				if($cur_cat->is_has_chd)
				{
					$a = array();
					foreach($cat as $row)
					{
						if($row->parent_id == $cur_cat->id) $a[] = $row;
					}
					if($a) $data['subc'] = $a;
					unset($a);
				}
				else if($cur_cat->parent_id > 0)
				{
					$a = array();
					foreach($cat as $row)
					{
						if($row->parent_id == $cur_cat->parent_id) $a[] = $row;
					}
					if($a) $data['subc'] = $a;
					unset($a);
				}
				unset($cur_cat);
			}
		}
		$data['get'] = $get;
		unset($get);
		$this->load->view(TPL_FOLDER.'search',$data);
	}
}
?>