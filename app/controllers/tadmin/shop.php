<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shop extends Controller
{
	function Shop()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
	}
	
	function index()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		$sql = 'SELECT s.*,(SELECT cat_name FROM '.$this->db->dbprefix."shop_catalog WHERE id = s.cid) AS cat_name FROM ".$this->db->dbprefix.'shop AS s WHERE 1 = 1';
		if(isset($get['cid'])&&$get['cid']!='')
		{
			$sql .= " AND s.cid = ".$get['cid'];
		}
		if(isset($get['s_keyword'])&&$get['s_keyword']!='')
		{
			$sql .= " AND s.title like '%".$get['s_keyword']."%'";
		}
		$sql .= ' ORDER BY s.seqorder DESC, s.id DESC';
		$page = array(
			'per_page' => 30,
			'page_base' => CTL_FOLDER."shop/index",
			'sql'  => $sql
		);
		$query = $this->common_model->get_page_records($page);
		$data = array(
			'query'		=> $query['query'],
			'paginate'	=> $query['paginate'],
			'shop_catalog' => $this->common_model->get_records('SELECT id,cat_name FROM '.$this->db->dbprefix.'shop_catalog ORDER BY seqorder DESC,id DESC')
		);
		$this->load->view(TPL_FOLDER."shop_list",$data);
	}
	
	function shop_move()
	{
		$id = $this->uri->segment(4,0);
		$query = $this->common_model->get_record('SELECT id,title,shop_url FROM '.$this->db->dbprefix.'shop WHERE id = ?',array($id));
		if( ! $query) echo_msg('<li>采集的店铺不存在</li>');
		
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		$page_no = 1;
		$data = array('shop_name'=>$query->title,'sid'=>$id);
		if(isset($get['page_no']) && $get['page_no'] > 0)
		{
			$page_no = $get['page_no'];
		}
		
		$aurl = parse_url($query->shop_url);
		$url = $aurl['scheme'].'://'.$aurl['host'].'/search.htm?pageNum='.$page_no;
		$c = get_url_content($url);
		if($c)
		{
			$c = @iconv("gbk","utf-8//IGNORE",$c);
			$this->load->library('trans');
			$c = $this->trans->t2c($c);
			$c = @preg_replace(array("'([\r\n\t\s]+)'"),array(""), $c);
			preg_match_all('/href="\/\/item\.taobao\.com\/item\.htm\?.*?id=(\d+).*?"[^>]*><img.*?alt="(.*?)".*?src="(.*?)"[^>]*\/?>/i', $c, $a);
			
			$items = array();
			if(isset($a[1]) && ! empty($a[1]))
			{
				foreach($a[1] as $k=>$v)
				{
					if(isset($a[2][$k]) && isset($a[3][$k]))
					{
						$items[$k]['title'] = $a[2][$k];
						$items[$k]['pic_url'] = $a[3][$k];
						$items[$k]['num_iid'] = $v;
						$items[$k]['detail_url'] = 'http://item.taobao.com/item.htm?id='.$v;
					}
				}
			}
			if(empty($items))
			{
				preg_match_all('/href="\/\/detail\.tmall\.com\/item\.htm\?.*?id=(\d+).*?"[^>]*><img.*?alt="(.*?)".*?data\-ks\-lazyload="(.*?)"[^>]*\/?>/i', $c, $a);
				if(isset($a[1]) && ! empty($a[1]))
				{
					foreach($a[1] as $k=>$v)
					{
						if(isset($a[2][$k]) && isset($a[3][$k]))
						{
							$items[$k]['title'] = $a[2][$k];
							$items[$k]['pic_url'] = $a[3][$k];
							$items[$k]['num_iid'] = $v;
							$items[$k]['detail_url'] = 'http://detail.tmall.com/item.htm?id='.$v;
						}
					}
				}
			}
			$data['items'] = $items;
			
			preg_match_all('/<spanclass="page-info">(\d+)\/(\d+)<\/span>/i', $c, $a);
			if( ! isset($a[2][0])) preg_match_all('/<bclass="ui-page-s-len">(\d+)\/(\d+)<\/b>/i', $c, $a);
			if(isset($a[2][0]) && $a[2][0] > 0) $total_page = $a[2][0];
			else $total_page = 0;
			if($page_no > $total_page) $page_no = $total_page;
			$data['paginate'] = $this->_get_page_nav($total_page,$page_no,$id);
		}
		$this->load->view(TPL_FOLDER.'shop_move',$data);
	}
	
	function _get_page_nav($t,$c,$sid)
	{
		$str = '';
		if($t > 1)
		{
			if(($s = $c - 4) <= 0) $s = 1;
			if(($e = $c + 4) > $t) $e = $t;
			if($c > 1) $str .= '<a href="'.my_site_url(CTL_FOLDER.'shop/shop_move/'.$sid).'?page_no=1">&lsaquo;首页 </a> ';
			if($c > 1) $str .= '<a href="'.my_site_url(CTL_FOLDER.'shop/shop_move/'.$sid).'?page_no='.($c-1).'">上一页</a> ';
			for($i = $s; $i <= $e ; $i++)
			{
				if($i == $c) $str .= '<b>'.$i.'</b> ';
				else $str .= '<a href="'.my_site_url(CTL_FOLDER.'shop/shop_move/'.$sid).'?page_no='.$i.'">'.$i.'</a> ';
			}
			if($c < $t) $str .= '<a href="'.my_site_url(CTL_FOLDER.'shop/shop_move/'.$sid).'?page_no='.($c+1).'">下一页</a> ';
			if($c < $t) $str .= '<a href="'.my_site_url(CTL_FOLDER.'shop/shop_move/'.$sid).'?page_no='.$t.'">尾页 &rsaquo;</a>';
		}
		return $str.' 总共 '.$t.' 页';
	}
	
	function shop_add()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		$data = array(
			'shop_catalog' => $this->common_model->get_records('SELECT id,cat_name FROM '.$this->db->dbprefix.'shop_catalog ORDER BY seqorder DESC,id DESC')
		);
		if(isset($get['shop_url']) && $get['shop_url'])
		{
			if($shop = get_shop($get['shop_url']))
			{
				$data['shop'] = $shop;
				$this->load->view(TPL_FOLDER."shop_add1",$data);
			}
			else
			{
				$this->load->view(TPL_FOLDER."shop_add",$data);
			}
		}
		else
		{
			$this->load->view(TPL_FOLDER."shop_add",$data);
		}
	}
	
	function save_shop_add()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("sid","店铺卖家ID","trim|is_natural_no_zero");
		$this->form_validation->set_rules("cid","分类ID","trim|is_natural_no_zero");
		$this->form_validation->set_rules("title","店铺标题","trim|required");
		$this->form_validation->set_rules("seqorder","排序号","integer");
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		
		$sid = trim($this->input->post("sid",true));
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop WHERE sid = ?',array($sid));
		if($query) echo_msg('<li>该店铺已经存在，请不要重复添加</li>');
		unset($query);
		
		$big_pic = do_upload(array('up_path'=>UP_IMAGES_PATH,'form_name'=>"big_pic",'suffix'=>UP_IMAGES_EXT));
		$pic_path = $this->input->post('pic_path',true);
		if( ! $big_pic['status']) echo_msg($big_pic['upload_errors']);
		if( ! file_exists($big_pic['file_path']) && ! $pic_path) echo_msg('<li>请上传商品图片</li>');
		if($big_pic['file_path']) $pic_path = $big_pic['file_path'];
		unset($big_pic);
		
		$data=array(
			'sid'=>$sid,
			'cid'=>$this->input->post("cid",true),
			'title'=>$this->input->post("title",true),
			'shop_url'=>$this->input->post("shop_url",true),
			'pic_path'=>$pic_path,
			'nick'=>'',
			'btitle'=>$this->input->post("btitle"),
			'keyword'=>$this->input->post("keyword",true),
			'description'=>$this->input->post("description",true),
			'seqorder'=>$this->input->post("seqorder",TRUE)
		);
		$this->db->insert("shop",$data);
		$this->_write_cache();
		echo_msg('<li>店铺添加成功，你可以继续添加。</li>',my_site_url(CTL_FOLDER.'shop/shop_add'),'yes');
	}
	
	function sort_record()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('rd_id','ID','required');
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		$rd_id=$this->input->post("rd_id");
		foreach($rd_id as $row)
		{
			$sort_value=$this->input->post("sort".$row,true);
			if(preg_match('/^[0-9]{1,10}$/',$sort_value))
			{
				$this->db->update("shop",array('seqorder'=>$sort_value),array('id'=>$row));
			}
		}
		$this->_write_cache();
		echo_msg('<li>排序成功</li>','','yes');
	}
	
	
	function del_record()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			echo_msg('<li>ID有误</li>');
		}
		$this->db->where_in("id",$rd_id);
		$this->db->delete("shop");
		if($this->db->affected_rows())
		{
			$this->_write_cache();
			$tx_msg="<li>记录删除成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>记录删除失败.</li>";
			echo_msg($tx_msg);
		}
	}
	
	function shop_edit()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		$id = 0;
		if(isset($get['id']) && ! empty($get['id'])) $id = $get['id'];
		
		$data = array(
			'shop_catalog' => $this->common_model->get_records('SELECT id,cat_name FROM '.$this->db->dbprefix.'shop_catalog ORDER BY seqorder DESC,id DESC')
		);
		if( ! $id) echo_msg('<li>操作有误</li>');
		$query = $this->common_model->get_record('SELECT * FROM '.$this->db->dbprefix.'shop WHERE id = ?',array($id));
		if( ! $query) echo_msg('<li>修改的商品不存在</li>'); 
		$data['shop'] = $query;
		unset($query);
		
		$data['url'] = $get['url'];
		$this->load->view(TPL_FOLDER."shop_edit",$data);
	}
	
	function save_shop_edit()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("cid","分类ID","trim|is_natural_no_zero");
		$this->form_validation->set_rules("sid","店铺卖家ID","trim|is_natural_no_zero");
		$this->form_validation->set_rules("title","店铺标题","trim|required");
		$this->form_validation->set_rules("seqorder","排序号","integer");
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		
		$id = $this->input->post('id',true);
		$sid = $this->input->post('sid',true);
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop WHERE id = ?',array($id));
		if( ! $query) echo_msg('<li>修改的店铺不存在</li>');
		unset($query);
		
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop WHERE id != ? AND sid = ?',array($id,$sid));
		if($query) echo_msg('<li>该店铺卖家ID已经存在，不能重复添加</li>');
		unset($query);
		
		$big_pic = do_upload(array('up_path'=>UP_IMAGES_PATH,'form_name'=>"big_pic",'suffix'=>UP_IMAGES_EXT));
		$pic_path = $this->input->post('pic_path',true);
		if( ! $big_pic['status']) echo_msg($big_pic['upload_errors']);
		if( ! file_exists($big_pic['file_path']) && ! $pic_path) echo_msg('<li>请上传商品图片</li>');
		if($big_pic['file_path']) $pic_path = $big_pic['file_path'];
		unset($big_pic);
		
		$data=array(
			'cid'=>$this->input->post("cid",true),
			'sid'=>$sid,
			'title'=>$this->input->post("title",true),
			'shop_url'=>$this->input->post("shop_url",true),
			'btitle'=>$this->input->post("btitle"),
			'keyword'=>$this->input->post("keyword",true),
			'description'=>$this->input->post("description",true),
			'pic_path'=>$pic_path,
			'seqorder'=>$this->input->post("seqorder",TRUE)
		);
		$this->db->update("shop",$data,array('id'=>$id));
		$this->_write_cache();
		echo_msg('<li>店铺修改成功</li>',$this->input->post('url'),'yes');
	}
	
	function re_cache()
	{
		$this->_write_cache();
		echo_msg('<li>缓存生成成功.</li>','','yes');
	}
	
	function _write_cache()
	{
		$query = $this->common_model->get_records('SELECT id,cat_name FROM '.$this->db->dbprefix.'shop_catalog ORDER BY seqorder DESC,id DESC');
		$a = array();
		$i = 0;
		foreach($query as $row)
		{
			$a[$i]['cat_name'] = $row->cat_name;
			$a[$i]['items'] = $this->common_model->get_records('SELECT id,sid,title,shop_url,pic_path FROM '.$this->db->dbprefix.'shop WHERE cid = '.$row->id.' ORDER BY seqorder DESC,id DESC');
			$i++;
		}
		save_cache('shop',$a);
		unset($query);
	}
}
?>