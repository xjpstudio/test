<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends Controller
{
	function Ajax()
	{
		parent::Controller();
		if( ! check_login())
		{
			diem('{"err":"nologin"}');
		}
		$this->load->database();
		$this->load->config('is_desc');
	}
	
	function tongbu()
	{
		$id = $this->input->post("id");
		if( ! $id) diem('{"msg":"no"}');
		$query = $this->common_model->get_record('SELECT num_iid FROM '.$this->db->dbprefix.'shop_product WHERE id = ?',array($id));
		if($query)
		{
			if($item = get_product($query->num_iid))
			{
				$this->_update_product($item);
			}
		}
		echo '{"msg":"yes"}';
	}
	
	function _update_product(&$v)
	{
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop_product WHERE num_iid = ?',array($v['num_iid']));
		if($query)
		{
			$data = array(
				'title'=>$v['title'],
				'keyword'=>$v['title'],
				'description'=>$v['title'],
				'volume'=>$v['volume'],
				'shop_price' => $v['shop_price'],
				'dc_price' => $v['dc_price'],
				'content' => $v['content']
			);
			
			if($v['pic_url'])
			{
				foreach($v['pic_url'] as $iv)
				{
					$data['small_pic_path'] = $iv.'_230x230.jpg';
					$data['big_pic_path'] = $iv;
					break;
				}
			}
			$this->db->update('shop_product',$data,array('id'=>$query->id));
			
			if($v['pic_url'] && count($v['pic_url']) > 1)
			{
				$this->db->simple_query('DELETE FROM '.$this->db->dbprefix.'shop_product_image WHERE product_id = '.$query->id);
				
				$i = 1;
				foreach($v['pic_url'] as $iv)
				{
					if($i > 1)
					{
						$data = array(
							'product_id' => $query->id
						);
						$data['pic_path'] = $iv;
						$this->db->insert('shop_product_image',$data);
					}
					$i++;
				}
			}
		}
	}
	
	function add_product()
	{
		$catalog_id = $this->input->post('catalog_id');
		$sid = $this->input->post('sid');
		$is_w = $this->input->post('is_w');
		$num_iid = $this->input->post('num_iid');
		if( ! $num_iid || ! $sid) diem('{"msg":"no"}');
		if($item = get_product($num_iid))
		{
			$this->_add_product($item,$catalog_id,$is_w,$sid);
		}
		echo '{"msg":"yes"}';
	}
	
	function del_more_pic()
	{
		$rd_id = $this->input->post('rd_id',true);
		if( ! is_numeric($rd_id)) diem('2');
		$this->db->where("id",$rd_id);
		$this->db->delete("shop_product_image");
		echo '1';
	}
	
	function _add_product(&$v,$catalog_id,$is_w,$sid=0)
	{
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop_product WHERE num_iid = ?',array($v['num_iid']));
		if( ! $query)
		{
			if($is_w == 1)
			{
				$title = replace_keyword($v['title']);
				$content = replace_keyword($v['content']);
			}
			else 
			{
				$title = $v['title'];
				$content = $v['content'];
			}
			
			$data = array(
				'catalog_id'=>$catalog_id,
				'num_iid' => $v['num_iid'],
				'title'=>$title,
				'sid' => $sid,
				'keyword'=>$title,
				'description'=>$title,
				'click_url'=>$v['detail_url'],
				'nick'=>$v['nick'],
				'volume'=>$v['volume'],
				'shop_price' => $v['shop_price'],
				'dc_price' => $v['dc_price'],
				'hits'=>0,
				'seqorder'=>0,
				'content' => $content,
				'create_date'=>time()
			);
			
			if($v['pic_url'])
			{
				foreach($v['pic_url'] as $iv)
				{
					$data['small_pic_path'] = $iv.'_230x230.jpg';
					$data['big_pic_path'] = $iv;
					break;
				}
			}
			
			$this->db->insert('shop_product',$data);
			
			$max_p_id = $this->db->insert_id();
			if($v['pic_url'] && count($v['pic_url']) > 1)
			{
				$i = 1;
				foreach($v['pic_url'] as $iv)
				{
					if($i > 1)
					{
						$data = array(
							'product_id' => $max_p_id
						);
						$data['pic_path'] = $iv;
						$this->db->insert('shop_product_image',$data);
					}
					$i++;
				}
			}
		}
	}
	
	function get_num_iid()
	{
		$sid=$this->input->post('sid');
		$page_no=$this->input->post('page_no');
		if( ! $sid) diem('{"msg":"no"}');
		
		$query = $this->common_model->get_record('SELECT f_url,p_url FROM '.$this->db->dbprefix.'shop_u_rule WHERE id = ?',array($sid));
		if( ! $query) diem('{"msg":"no"}');
		
		if($page_no == 1) $url = $query->f_url;
		else
		{
			$url = str_replace('{page}',$page_no,$query->p_url);
		}
		unset($query);
		echo '{"iids":"'.get_u_num_iids($url).'"}';
	}
	
	function u_caiji()
	{
		$is_w=$this->input->post('is_w');
		$num_iid=$this->input->post('num_iid');
		$catalog_id=$this->input->post('catalog_id');
		if( ! $num_iid) diem('{"msg":"no"}');
		if($item = get_product($num_iid))
		{
			$this->_add_product($item,$catalog_id,$is_w);
		}
		echo '{"msg":"yes"}';
	}
	
	function get_u_block()
	{
		$f_url = $this->input->post('f_url');
		if( ! $f_url) diem('参数错误');
		$c = get_u_num_iids($f_url);
		if($c) echo '<div style="word-break:break-all;word-wrap:break-word;line-height:25px;">抓取成功!<br>抓取到的商品ID：<br>'.$c.'</div>';
		else echo '抓取失败，请修改规则。';
	}
	
	function get_block()
	{
		$charset = $this->input->post('charset');
		$f_url = $this->input->post('f_url');
		$list_block_s = $this->input->post('list_block_s');
		$list_block_e = $this->input->post('list_block_e');
		if( ! $charset || ! $f_url || ! $list_block_s || ! $list_block_e) diem('参数错误');
		$this->load->library('spider');
		$a = array(
			'charset' => $charset
		);
		$this->spider->init($a);
		$c = $this->spider->get_page_content($f_url);
		if($c) $c = $this->spider->get_block_content($c,$list_block_s,$list_block_e);
		if($c) echo htmlspecialchars($c,ENT_QUOTES);
		else echo '抓取失败，请修改规则。';
	}
	
	function get_list()
	{
		$charset = $this->input->post('charset');
		$f_url = $this->input->post('f_url');
		$list_block_s = $this->input->post('list_block_s');
		$list_block_e = $this->input->post('list_block_e');
		$list_link_s = $this->input->post('list_link_s');
		$list_link_e = $this->input->post('list_link_e');
		if( ! $charset || ! $f_url || ! $list_block_s || ! $list_block_e || ! $list_link_s || ! $list_link_e) diem('参数错误');
		$this->load->library('spider');
		$a = array(
			'url' => $f_url,
			'list_link_s' => $list_link_s,
			'list_link_e' => $list_link_e,
			'charset' => $charset
		);
		$this->spider->init($a);
		$c = $this->spider->get_page_content($f_url);
		if($c) $c = $this->spider->get_block_content($c,$list_block_s,$list_block_e);
		if($c) $c = $this->spider->getSourceList($c);
		if($c) print_r($c);
		else echo '抓取失败，请修改规则。';
	}
	
	function caiji()
	{
		$catalog_id = $this->input->post('catalog_id');
		$rid = $this->input->post('rid');
		$page_no = $this->input->post('page_no');
		$is_w = $this->input->post('is_w');
		if( ! is_numeric($rid)) diem('{"msg":"no"}');
		$query = $this->common_model->get_record('SELECT * FROM '.$this->db->dbprefix.'shop_rule WHERE id = ?',array($rid));
		if( ! $query) diem('{"msg":"no"}');
		if($page_no > $query->page_total) $page_no = $query->page_total;
		if( ! $page_no) $page_no = 1;
		$this->load->library('spider');
		$a = array(
			'url' => $query->f_url,
			'list_link_s' => $query->list_link_s,
			'list_link_e' => $query->list_link_e,
			'charset' => $query->charset
		);
		$this->spider->init($a);
		if($page_no == 1) $url = $query->f_url;
		else $url = str_replace('{page}',$page_no,$query->p_url);
		$c = $this->spider->get_page_content($url);
		if($c) $c = $this->spider->get_block_content($c,$query->list_block_s,$query->list_block_e);
		if($c) $a = $this->spider->getSourceList($c);
		$i = 0;
		foreach($a as $v)
		{
			if($is_w) $title = replace_keyword($v['title']);
			else $title = $v['title'];
			$news = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop_news WHERE title = ?',array($title));
			if( ! $news)
			{
				$c = $this->spider->get_page_content($v['url']);
				$c = $this->spider->get_block_content($c,$query->detail_s,$query->detail_e);
				if($c) $c = $this->spider->remove_html($c);
				if($c) $c = $this->spider->r_to_a($c);
				if($c) 
				{
					if($is_w) $c = replace_keyword($c);
					$this->_add_news($title,$c,$catalog_id);
					$i++;
				}
			}
		}
		if($i > 0)
		{
			if($page_no == 1) $this->db->simple_query('UPDATE '.$this->db->dbprefix.'shop_rule SET mod_date = '.time().',c_total = '.$i.' WHERE id = '.$rid);
			else $this->db->simple_query('UPDATE '.$this->db->dbprefix.'shop_rule SET mod_date = '.time().',c_total = c_total + '.$i.' WHERE id = '.$rid); 
		}
		echo '{"msg":"yes"}';
	}
	
	
	function _add_news($t,$c,$cid)
	{
		$summary = replace_htmlAndjs($c);
		$summary = strcut($summary,200);
		$data=array(
			'title'=>$t,
			'catalog_id'=>$cid,
			'keyword'=>$t,
			'description'=>$summary,
			'author'=>'admin',
			'source'=>'未知',
			'content'=>$c,
			'summary'=>$summary,
			'create_date'=>time()
		);
		$this->db->insert("shop_news",$data);
	}
	
	function _get_taobao_id($url)
	{
		$id_arr = array (
			'id',
			'item_num_id',
			'default_item_id',
			'item_id',
			'itemId',
			'mallstItemId'
		);
		$url = explode('?',$url);
		if(isset($url[1]))
		{
			parse_str($url[1],$a);
			foreach($a as $k => $v)
			{
				if (in_array($k, $id_arr))
				{
					return $v;
				}
			}
		}
		return 0;
	}
}
?>