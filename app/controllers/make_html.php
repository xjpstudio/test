<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * make html 
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 */
class Make_html extends Controller
{
	var $site_title;
	var $a_dir;
	
	function Make_html()
	{
		parent::Controller();
		$this->load->database();
		$this->load->model('com_model');
		$this->load->helper('file');
		$this->site_title = $this->config->item('sys_site_title');
		$this->a_dir = ROOT_PATH.'a/';
	}
	
	function make_news_pages()
	{
		$cid = $this->input->post('cid',TRUE);
		$pid = $this->input->post('pid',TRUE);
		$err = '{"err":"no"}';
		if( ! is_numeric($cid) || ! is_numeric($pid)) diem($err);
		$per_page = 10;
		$p_num = 20;
		$cat = $this->common_model->get_record('SELECT cat_name,keyword,description,btitle FROM '.$this->db->dbprefix."shop_news_catalog WHERE id = ".$cid);
		if( ! $cid) diem($err);
		
		$query = $this->common_model->get_record('SELECT COUNT(*) AS total FROM '.$this->db->dbprefix."shop_news WHERE catalog_id like '%,".$cid.",%'");
		$total_rows = $query ->total;
		unset($query);
		$offset = ($pid - 1) * $p_num * $per_page;
		$page=array(
			'page_base' => $this->a_dir.'p',
			'per_page' => $per_page,
			'total_rows' => $total_rows,
			'sql' => 'SELECT id,title,create_date,summary,pic_path,hits FROM '.$this->db->dbprefix."shop_news WHERE catalog_id like '%,".$cid.",%' ORDER BY seqorder DESC,id DESC",
			'catalog_id' => $cid
		);
		for($i = 1; $i <= $p_num; $i++)
		{
			if($offset <= $total_rows)
			{
				$page['offset']=$offset;
				$query=$this->common_model->get_html_page_records($page);
				
				$nav_arr=array(
					'tb'=>'shop_news_catalog',
					'nav_title'=>'资讯频道',
					'catalog_id' =>$cid
				);
				$nav = $this->_get_nav($nav_arr);
				$data = array(
					'site_title'		=> $nav['nav_title'].'-'.$this->site_title,
					'nav'		=> $nav['nav_str'],
					'news'		=> $query['query'],
					'paginate'		=> $query['paginate']
				);
				if($cat->btitle) $data['site_title'] = str_replace('{title}',$cat->cat_name,str_replace('{site_title}',$this->site_title,$cat->btitle));
				if($cat->keyword) $data['page_keyword'] = $cat->keyword;
				if($cat->description) $data['page_description'] = $cat->description;
				
				$html_data=$this->load->view(TPL_FOLDER."news_channel",$data,true);
				write_file(create_link('p'.$cid.($offset ? $offset : ''),'x'),$html_data);
				$offset += $per_page;
			}
		}
		echo '{"msg":"yes"}';
	}
	
	function make_news()
	{
		$cid = $this->input->post('cid',TRUE);
		$pid = $this->input->post('pid',TRUE);
		$err = '{"err":"no"}';
		if( ! is_numeric($cid) || ! is_numeric($pid)) diem($err);
		$per_page = 50;
		$offset = ($pid - 1) * $per_page;
		$sql = 'SELECT * FROM '.$this->db->dbprefix."shop_news WHERE 1=1";
		$sql .= " AND catalog_id LIKE '%,{$cid},%'";
		$sql .= ' LIMIT '.$offset.','.$per_page;
		$news = $this->common_model->get_records($sql);
		
		foreach($news as $row)
		{
			$nav_arr=array(
				'tb'=>'shop_news_catalog',
				'nav_title'=>$row->title,
				'catalog_id' =>$row->catalog_id
			);
			$nav = $this->_get_nav($nav_arr);
			$data = array(
				'site_title'		=> $nav['nav_title'].'-'.$this->site_title,
				'nav'		=> $nav['nav_str'],
				'news'		=> $row,
				'page_keyword'		=> $row->keyword,
				'page_description'		=> $row->description,
				'content_link' => $this->_content_link($row->id,$row->catalog_id,'shop_news')
			);
			if($row->btitle) $data['site_title'] = str_replace('{title}',$row->title,str_replace('{site_title}',$this->site_title,$row->btitle));
			$html_data=$this->load->view(TPL_FOLDER."news_detail",$data,true);
			write_file(create_link($row->id,'x'),$html_data);
			$this->db->simple_query('UPDATE '.$this->db->dbprefix."shop_news SET is_create = 1 WHERE id = ".$row->id);
		}
		echo '{"msg":"yes"}';
	}
	
	function make_sg_news()
	{
		$id = $this->input->post('id',TRUE);
		$err = '{"err":"no"}';
		if( ! is_numeric($id)) diem($err);
		$sql = 'SELECT * FROM '.$this->db->dbprefix."shop_news WHERE 1=1";
		$sql .= " AND id = {$id}";
		$row = $this->common_model->get_record($sql);
		if( ! $row) diem($err); 
		
		$nav_arr=array(
			'tb'=>'shop_news_catalog',
			'nav_title'=>$row->title,
			'catalog_id' =>$row->catalog_id
		);
		$nav = $this->_get_nav($nav_arr);
		$data = array(
			'site_title'		=> $nav['nav_title'].'-'.$this->site_title,
			'nav'		=> $nav['nav_str'],
			'nav_title'		=> $nav['nav_title'],
			'news'		=> $row,
			'page_keyword'		=> $row->keyword,
			'page_description'		=> $row->description,
			'content_link' => $this->_content_link($row->id,$row->catalog_id,'shop_news')
		);
		if($row->btitle) $data['site_title'] = str_replace('{title}',$row->title,str_replace('{site_title}',$this->site_title,$row->btitle));
		$html_data=$this->load->view(TPL_FOLDER."news_detail",$data,true);
		write_file(create_link($row->id,'x'),$html_data);
		$this->db->simple_query('UPDATE '.$this->db->dbprefix."shop_news SET is_create = 1 WHERE id = ".$row->id);
		echo '{"msg":"yes"}';
	}
	
	function sitemap_baidu()
	{
		$data = array(
			'product'		=> $this->common_model->get_records('SELECT id,create_date FROM '.$this->db->dbprefix.'shop_product ORDER BY seqorder DESC, id DESC LIMIT 500')
		);
		$html_data=$this->load->view(TPL_FOLDER."sitemap_baidu",$data,true);
		write_file('sitemap_baidu.xml',$html_data);
		echo '{"msg":"yes"}';	
	}
	
	function google()
	{
		$data = array(
			'product'		=> $this->common_model->get_records('SELECT id,create_date FROM '.$this->db->dbprefix.'shop_product ORDER BY seqorder DESC, id DESC LIMIT 500')
		);
		$html_data=$this->load->view(TPL_FOLDER."google",$data,true);
		write_file('google.xml',$html_data);
		echo '{"msg":"yes"}';
	}
	
	function _get_nav($arr)
	{
		$defarr = array('nav_str'=>'','nav_title'=>'');
		foreach($arr as $k=>$v)
		{
			$$k = $v;
		}
		unset($arr);
		if( ! isset($catalog_id) || !isset($nav_title) || ! isset($tb)) return $defarr;
		$str='';
		if(strpos($catalog_id,',') !== FALSE)
		{
			$catalog_id = trim($catalog_id,',');
			$query = $this->common_model->get_records('SELECT cat_name,id FROM '.$this->db->dbprefix.$tb.' WHERE id in('.$catalog_id.') ORDER BY deep_id ASC');
			foreach($query as $row)
			{
				$str.=' &gt; <a href="'.create_link('p'.$row->id).'">'.$row->cat_name.'</a>';
			}
			$str .= ' &gt; '.$nav_title;
			return array('nav_str'=>$str,'nav_title'=>$nav_title);
		}
		elseif($catalog_id > 0)
		{
			$query = $this->common_model->get_record('SELECT queue FROM '.$this->db->dbprefix.$tb.' WHERE id = ?',array($catalog_id));
			if( ! $query) return $defarr;
			$queue = $query->queue;
			$queue = trim($queue,',');
			
			$query = $this->common_model->get_records('SELECT cat_name,id FROM '.$this->db->dbprefix.$tb.' WHERE id in('.$queue.') ORDER BY deep_id ASC');
			$i = 1;
			foreach($query as $row)
			{
				if(count($query) == $i)
				{
					$str.=' &gt; '.$row->cat_name;
					$nav_title = $row->cat_name;
				}
				else
				{
					$str.=' &gt; <a href="'.create_link('p'.$row->id).'">'.$row->cat_name.'</a>';
				}
				$i += 1;
			}
			return array('nav_str'=>$str,'nav_title'=>$nav_title);
		}
		else
		{
			$str.=' &gt; <a href="'.create_link('index').'">'.$nav_title.'</a>';
			return array('nav_str'=>$str,'nav_title'=>$nav_title);
		}
	}
	
	function _content_link($id,$c,$t)
	{
		$arr = array('prev'=>'没有了','next'=>'没有了');
		if( ! $id || !$t) return $arr;
		$sql = 'SELECT id,title FROM '.$this->db->dbprefix.$t.' WHERE 1=1';
		if($c) $sql .= " AND catalog_id LIKE '%{$c}%'";
		$sql .= ' ORDER BY seqorder DESC,id DESC';
		$query = $this->db->query($sql);
		$i = 0;
		$rs = $query->result();
		foreach($rs as $row)
		{
			if($row->id == $id)
			{
				if(($i-1) >= 0 && $prev = $query->row($i-1))
				{
					$arr['prev'] = '<a href="'.create_link($prev->id).'" title="'.$prev->title.'">'.strcut($prev->title,48).'</a>';
				} 
				if(($i+1) < count($rs) && $next = $query->row($i+1))
				{
					$arr['next'] = '<a href="'.create_link($next->id).'" title="'.$next->title.'">'.strcut($next->title,48).'</a>';
				} 
				break;
			}
			$i++;
		}
		return $arr;
	}
}
?>