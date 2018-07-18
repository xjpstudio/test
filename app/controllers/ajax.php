<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * goods detail
 * @author		Soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 *
 */
class Ajax extends Controller
{
	function Ajax()
	{
		parent::Controller();
		$this->load->database();
	}
	
	function get_rgoods()
	{
		$sql = 'SELECT id,title,dc_price,shop_price,small_pic_path FROM '.$this->db->dbprefix.'shop_product WHERE id >= (SELECT floor(RAND() * (SELECT MAX(id) FROM '.$this->db->dbprefix.'shop_product))) ORDER BY id LIMIT 10';
		$data = array(
			'query' => $this->common_model->get_records($sql)
		);
		$this->load->view(TPL_FOLDER.'get_rgoods',$data);
	}
	
	function get_desc()
	{
		$rd_id=$this->uri->segment(3,0);
		$query = $this->common_model->get_record('SELECT content FROM '.$this->db->dbprefix.'shop_product WHERE id = ?',array($rd_id));
		if ( ! $query) echo '没有商品描述...';
		echo $query->content;
	}
	
	function add_news_hits()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		if( ! isset($get['id'])) diem('0');
		$id = $get['id'];unset($get);
		if( ! is_numeric($id)) diem('0');
		$this->db->simple_query('UPDATE '.$this->db->dbprefix.'shop_news SET hits = hits + 1 WHERE id ='.$id);
		$query = $this->common_model->get_record('SELECT hits FROM '.$this->db->dbprefix.'shop_news WHERE id = ?',array($id));
		if ($query)
		{
			diem($query->hits);
		}
		diem('0');
	}
	
	function add_love()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		if( ! isset($get['id'])) diem('0');
		$id = $get['id'];unset($get);
		if( ! is_numeric($id)) diem('0');
		$this->db->simple_query('UPDATE '.$this->db->dbprefix.'shop_product SET love = love + 1 WHERE id ='.$id);
		$query = $this->common_model->get_record('SELECT love FROM '.$this->db->dbprefix.'shop_product WHERE id = ?',array($id));
		if ($query)
		{
			diem($query->love);
		}
		diem('0');
	}
	
	function get_comment()
	{
		$curr_page = $this->input->post('curr_page',TRUE);
		$product_id = $this->input->post('product_id',TRUE);
		if( ! preg_match( '/^[1-9]\d*$/',$product_id) ||  ! preg_match( '/^[1-9]\d*$/',$curr_page)) diem('暂无评论...');
		$query = $this->common_model->get_record('SELECT COUNT(*) AS num FROM '.$this->db->dbprefix.'shop_comment WHERE is_pass = 1 AND product_id = ?',array($product_id));
		if( ! $query->num) diem('暂无评论...');
		$total = $query->num;
		$page_size = 10;
		$page_total = ceil($total / $page_size);
		if( ! $curr_page) $curr_page = 1;
		if($curr_page > $page_total) $curr_page = $page_total;
		$offset = ($curr_page - 1) * $page_size;
		$page_str = $this->_get_page_nav($total,$curr_page,$page_size,'get_comment');
		$query = $this->common_model->get_records('SELECT user_name,content,reply,create_date FROM '.$this->db->dbprefix.'shop_comment WHERE is_pass = 1 AND product_id = ? ORDER BY id DESC LIMIT '.$offset.','.$page_size,array($product_id));
		$data = array(
			'page_str' => $page_str,
			'query' => $query
		);
		echo $this->load->view(TPL_FOLDER.'get_comment',$data,TRUE);
	}
	
	function _get_page_nav($t,$c,$p,$f)
	{
		$str = '';
		if( ! $c) $c = 1;
		if($t > 0 && $p > 0)
		{
			$page_total = ceil($t / $p) ;
			if($c > $page_total) $c = $page_total;
			if($page_total > 1)
			{
				if(($s = $c - 4) <= 0) $s = 1;
				if(($e = $c + 4) > $page_total) $e = $page_total;
				if($c > 1) $str .= '<a href="#tr" onclick="'.$f.'(1)">&lsaquo;首页 </a> ';
				if($c > 1) $str .= '<a href="#tr" onclick="'.$f.'('.($c-1).')">上一页</a> ';
				for($i = $s; $i <= $e ; $i++)
				{
					if($i == $c) $str .= ' <span>'.$i.'</span> ';
					else $str .= '<a href="#tr" onclick="'.$f.'('.$i.')">'.$i.'</a> ';
				}
				if($c < $page_total) $str .= '<a href="#tr" onclick="'.$f.'('.($c+1).')">下一页</a> ';
				if($c < $page_total) $str .= '<a href="#tr" onclick="'.$f.'('.$page_total.')">尾页 &rsaquo;</a>';
			}
		}
		return $str;
	}
}
?>