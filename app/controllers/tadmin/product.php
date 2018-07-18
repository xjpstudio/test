<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends Controller
{
	function Product()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
	}
	
	function index()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		$sql = '';
		if(isset($get['cid'])&&$get['cid']!='')
		{
			$sql .= " AND catalog_id like '%,".$get['cid'].",%'";
		}
		if(isset($get['sid'])&&$get['sid']!='')
		{
			$sql .= " AND sid = ".$get['sid'];
		}
		if(isset($get['s_keyword'])&&$get['s_keyword']!='')
		{
			$sql .= " AND title like '%".$get['s_keyword']."%'";
		}
		
		$sqlt = 'SELECT COUNT(*) AS num FROM '.$this->db->dbprefix.'shop_product WHERE 1=1'.$sql;
		$query = $this->common_model->get_record($sqlt);
		$total = $query->num;
		unset($query);
		
		$sql = 'SELECT id FROM '.$this->db->dbprefix.'shop_product WHERE 1 = 1'.$sql.' ORDER BY seqorder DESC, id DESC';
		
		$page = array(
			'per_page' => 60,
			'page_base' => CTL_FOLDER."product/index",
			'sql'  => $sql,
			'total_rows' => $total
		);
		$query = $this->common_model->get_page_records($page);
		
		$str = '';
		foreach($query['query'] as $row)
		{
			$str .= $row->id.',';
		}
		$str = rtrim($str,',');
		
		$data = array(
			'query'		=> array(),
			'paginate'	=> $query['paginate'],
			'shop' => $this->common_model->get_records('SELECT id,title FROM '.$this->db->dbprefix.'shop ORDER BY seqorder DESC,id DESC')
		);
		
		if($str) $data['query'] = $this->common_model->get_records('SELECT id,small_pic_path,title,shop_price,dc_price,create_date,seqorder,click_url,catalog_id FROM '.$this->db->dbprefix.'shop_product WHERE id IN('.$str.') ORDER BY seqorder DESC, id DESC');
		
		$this->load->view(TPL_FOLDER."product_list",$data);
	}
	
	function temp()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		$sql = '';
		if(isset($get['cid'])&&$get['cid']!='')
		{
			$sql .= " AND catalog_id like '%,".$get['cid'].",%'";
		}
		if(isset($get['s_keyword'])&&$get['s_keyword']!='')
		{
			$sql .= " AND title like '%".$get['s_keyword']."%'";
		}
		
		$sqlt = 'SELECT COUNT(*) AS num FROM '.$this->db->dbprefix.'shop_product_temp WHERE 1=1'.$sql;
		$query = $this->common_model->get_record($sqlt);
		$total = $query->num;
		unset($query);
		
		$sql = 'SELECT id FROM '.$this->db->dbprefix.'shop_product_temp WHERE 1 = 1'.$sql.' ORDER BY id DESC';
		
		$page = array(
			'per_page' => 60,
			'page_base' => CTL_FOLDER."product/temp",
			'sql'  => $sql,
			'total_rows' => $total
		);
		$query = $this->common_model->get_page_records($page);
		
		$str = '';
		foreach($query['query'] as $row)
		{
			$str .= $row->id.',';
		}
		$str = rtrim($str,',');
		
		$data = array(
			'query'		=> array(),
			'paginate'	=> $query['paginate']
		);
		
		if($str) $data['query'] = $this->common_model->get_records('SELECT id,pic_path,title,shop_price,dc_price,click_url,catalog_id,nick,volume,create_date FROM '.$this->db->dbprefix.'shop_product_temp WHERE id IN('.$str.') ORDER BY id DESC');
		
		$this->load->view(TPL_FOLDER."temp_list",$data);
	}
	
	function id_caiji()
	{
		$this->load->view(TPL_FOLDER."id_caiji");
	}

	function sell_add()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		$data = array('shop' => $this->common_model->get_records('SELECT id,title FROM '.$this->db->dbprefix.'shop ORDER BY seqorder DESC,id DESC'));
		if(isset($get['num_iid']) && $get['num_iid'] > 0)
		{
			if($item = get_product($get['num_iid']))
			{
				$data['item'] = $item;
				$this->load->view(TPL_FOLDER."sell_add1",$data);
			}
			else
			{
				$this->load->view(TPL_FOLDER."sell_add",$data);
			}
		}
		else if(isset($get['url']) && $get['url'])
		{
			if($num_iid = $this->_get_taobao_id($get['url']))
			{
				if($item = get_product($num_iid))
				{
					$data['item'] = $item;
					$this->load->view(TPL_FOLDER."sell_add1",$data);
				}
				else
				{
					$this->load->view(TPL_FOLDER."sell_add",$data);
				}
			}
			else
			{
				$this->load->view(TPL_FOLDER."sell_add",$data);
			}
		}
		else
		{
			$this->load->view(TPL_FOLDER."sell_add",$data);
		}
	}
	
	function save_sell_add()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("num_iid","商品ID","trim|is_natural_no_zero");
		$this->form_validation->set_rules("title","商品标题","trim|required");
		$this->form_validation->set_rules("click_url","商品链接","trim|required");
		$this->form_validation->set_rules("seqorder","排序号","integer");
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		
		$num_iid = trim($this->input->post("num_iid",true));
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop_product WHERE num_iid = ?',array($num_iid));
		if($query) echo_msg('<li>该商品已经添加，请不要重复添加</li>');
		unset($query);
		
		$big_pic=do_upload(array('up_path'=>UP_IMAGES_PATH,'form_name'=>"big_pic",'suffix'=>UP_IMAGES_EXT));
		$pic_path = $this->input->post('pic_path',true);
		if( ! $big_pic['status']) echo_msg($big_pic['upload_errors']);
		if( ! file_exists($big_pic['file_path']) && ! $pic_path) echo_msg('<li>请上传商品图片</li>'); 
		$big_pic_path = $big_pic['file_path'];
		unset($big_pic);
		if($big_pic_path)
		{
			if(create_thumb($big_pic_path))
			{
				$small_pic_path = str_replace(".","_thumb.",$big_pic_path);
			} else $small_pic_path = $big_pic_path;
		}
		else 
		{
			$small_pic_path = $big_pic_path = $pic_path;
		}
		unset($pic_path);
		if($pic_path = $this->input->post('small_pic_path')) $small_pic_path = $pic_path;
		unset($pic_path);
		
		$more_pic_id = $this->input->post("more_pic_id");
		$more_pic_array=array();
		if(is_array($more_pic_id))
		{
			foreach($more_pic_id as $value)
			{
				$more_pic=do_upload(array('up_path'=>UP_IMAGES_PATH,'form_name'=>"more_pic".$value,'suffix'=>UP_IMAGES_EXT));
				if($more_pic['status'] && $more_pic['file_path'] != '')
				{
					$more_pic_array[] = array('pic_path'=>$more_pic['file_path']);
				}
				else if($pic_path = $this->input->post("pic_path".$value))
				{
					$more_pic_array[] = array('pic_path'=>$pic_path);
				}
				unset($more_pic);
			}
		}
		unset($more_pic_id);
		
		//分类
		$catalog_id = $this->input->post('catalog_id');
		if(is_array($catalog_id))
		{
			$catalog_id = array_unique(explode(',',implode(",",$catalog_id)));
			$catalog_id = implode(',',$catalog_id);
		}
		if($catalog_id) $catalog_id = ','.$catalog_id.',';

		$data=array(
			'num_iid'=>$num_iid,
			'click_url' => $this->input->post("click_url"),
			'title'=>$this->input->post("title",true),
			'sid'=>$this->input->post("sid",true),
			'nick'=>$this->input->post("nick",true),
			'btitle'=>$this->input->post("btitle"),
			'keyword'=>$this->input->post("keyword",true),
			'description'=>$this->input->post("description",true),
			'volume'=>$this->input->post("volume",TRUE),
			'love'=>$this->input->post("love",TRUE),
			'catalog_id'=>$catalog_id,
			'content'=>filter_script($this->input->post("content")),
			'shop_price'=>$this->input->post("shop_price",TRUE),
			'dc_price'=>$this->input->post("dc_price",TRUE),
			'small_pic_path'=>$small_pic_path,
			'big_pic_path'=>$big_pic_path,
			'seqorder'=>$this->input->post("seqorder",TRUE),
			'create_date' => time()
		);
		if(stripos($big_pic_path,'_sum.jpg') !== FALSE)
		{
			$data['small_pic_path'] = str_ireplace('_sum.jpg','_230x230.jpg',$big_pic_path);
			$data['big_pic_path'] = str_ireplace('_sum.jpg','',$big_pic_path);
		}
		
		$this->db->trans_begin();
		$this->db->insert("shop_product",$data);
		$mid = $this->db->insert_id();
		
		if( ! empty($more_pic_array))
		{
			foreach($more_pic_array as $pic_row)
			{
				$pic_row['product_id']=$mid;
				$this->db->insert("shop_product_image",$pic_row);
			}
		}
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			echo_msg('<li>商品添加失败</li>');
		}
		else
		{
			$this->db->trans_commit();
			echo_msg('<li>商品添加成功， 你可以继续添加。</li>',my_site_url(CTL_FOLDER.'product/sell_add'),'yes');
		}
	}
	
	function sort_record()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('rd_id','商品ID','required');
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		$rd_id=$this->input->post("rd_id");
		foreach($rd_id as $row)
		{
			$sort_value=$this->input->post("sort".$row,true);
			if(preg_match('/^[0-9]{1,10}$/',$sort_value))
			{
				$this->db->update("shop_product",array('seqorder'=>$sort_value),array('id'=>$row));
			}
		}
		echo_msg('<li>排序成功</li>','','yes');
	}
	
	function to_catalog()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('rd_id','商品ID','required');
		$this->form_validation->set_rules('to_catalog_id','移动到的分类','required');
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		$rd_id=$this->input->post("rd_id");
		$catalog_id = $this->input->post('to_catalog_id');
		$rd_id = implode(',',$rd_id);
		$query = $this->common_model->get_record('SELECT queue FROM '.$this->db->dbprefix."shop_product_catalog WHERE id = ?",array($catalog_id));
		$queue = trim($query->queue,',');
		
		$query = $this->common_model->get_records('SELECT id,catalog_id FROM '.$this->db->dbprefix."shop_product WHERE id in({$rd_id})");
		foreach($query as $row)
		{
			if($row->catalog_id)
			{
				$catalog_id = array_unique(explode(',',trim($row->catalog_id,',').','.$queue));
				$catalog_id = implode(',',$catalog_id);
				$catalog_id = ','.$catalog_id.',';
				$this->db->update('shop_product',array('catalog_id'=>$catalog_id),array('id'=>$row->id));
			}
			else
			{
				$catalog_id = ','.$queue.',';
				$this->db->update('shop_product',array('catalog_id'=>$catalog_id),array('id'=>$row->id));
			}
		}
		echo_msg('<li>转移成功</li>','','yes');
	}

	function del_record()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			echo_msg('<li>ID有误</li>');
		}
		$this->db->where_in("id",$rd_id);
		$this->db->delete("shop_product");
		if($this->db->affected_rows())
		{
			$this->db->where_in("product_id",$rd_id);
			$this->db->delete("shop_product_image");
			
			$this->db->where_in("product_id",$rd_id);
			$this->db->delete("shop_comment");
			
			$tx_msg="<li>记录删除成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>记录删除失败.</li>";
			echo_msg($tx_msg);
		}
	}
	
	function del_record_temp()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			echo_msg('<li>ID有误</li>');
		}
		$this->db->where_in("id",$rd_id);
		$this->db->delete("shop_product_temp");
		if($this->db->affected_rows())
		{
			$tx_msg="<li>记录删除成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>记录删除失败.</li>";
			echo_msg($tx_msg);
		}
	}
	
	function clear()
	{
		$this->db->truncate('shop_product');
		$this->db->truncate('shop_product_image');
		$this->db->truncate('shop_comment');
		$tx_msg="<li>成功清除所有商品.</li>";
		echo_msg($tx_msg,my_site_url(CTL_FOLDER.'product'),'yes');
	}
	
	function clear_temp()
	{
		$this->db->truncate('shop_product_temp');
		$tx_msg="<li>成功清除所有未审核商品.</li>";
		echo_msg($tx_msg,my_site_url(CTL_FOLDER.'product/temp'),'yes');
	}
	
	function sell_edit()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		$id = 0;
		if(isset($get['id']) && ! empty($get['id'])) $id = $get['id'];
		
		$data = array('shop' => $this->common_model->get_records('SELECT id,title FROM '.$this->db->dbprefix.'shop ORDER BY seqorder DESC,id DESC'));
		if( ! $id) echo_msg('<li>操作有误</li>');
		$query = $this->common_model->get_record('SELECT * FROM '.$this->db->dbprefix.'shop_product WHERE id = ?',array($id));
		if( ! $query) echo_msg('<li>修改的商品不存在</li>'); 
		$data['product'] = $query;
		unset($query);
		
		$query = $this->common_model->get_records('SELECT * FROM '.$this->db->dbprefix.'shop_product_image WHERE product_id = ?',array($id));
		$data['pic'] = $query;
		unset($query);
		
		$data['url'] = $get['url'];
		$this->load->view(TPL_FOLDER."sell_edit",$data);
	}
	
	function save_sell_edit()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("id","商品ID","is_natural_no_zero");
		$this->form_validation->set_rules("num_iid","商品ID","trim|is_natural_no_zero");
		$this->form_validation->set_rules("title","商品标题","trim|required");
		$this->form_validation->set_rules("click_url","商品链接","trim|required");
		$this->form_validation->set_rules("seqorder","排序号","integer");
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		
		$id = $this->input->post('id',true);
		$num_iid = trim($this->input->post("num_iid",true));
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop_product WHERE id = ?',array($id));
		if( ! $query) echo_msg('<li>修改的商品不存在</li>');
		unset($query);
		
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop_product WHERE id != ? AND num_iid = ?',array($id,$num_iid));
		if($query) echo_msg('<li>该ID的商品已经存在，不能重复添加</li>');
		unset($query);
		
		$big_pic=do_upload(array('up_path'=>UP_IMAGES_PATH,'form_name'=>"big_pic",'suffix'=>UP_IMAGES_EXT));
		$pic_path = $this->input->post('pic_path',true);
		if( ! $big_pic['status']) echo_msg($big_pic['upload_errors']);
		if( ! file_exists($big_pic['file_path']) && ! $pic_path) echo_msg('<li>请上传商品图片</li>'); 
		$big_pic_path = $big_pic['file_path'];
		unset($big_pic);
		$o_big_pic_path = $this->input->post('o_big_pic_path');
		$o_small_pic_path = $this->input->post('o_small_pic_path');
		if($big_pic_path)
		{
			if(create_thumb($big_pic_path))
			{
				$small_pic_path = str_replace(".","_thumb.",$big_pic_path);
			} else $small_pic_path = $big_pic_path;
		}
		else if($o_big_pic_path == $pic_path)
		{
			$small_pic_path = $o_small_pic_path;
			$big_pic_path = $pic_path;
		}
		else 
		{
			$small_pic_path = $big_pic_path = $pic_path;
		}
		unset($pic_path);
		
		$more_pic_id = $this->input->post("more_pic_id");
		$more_pic_array=array();
		if(is_array($more_pic_id))
		{
			foreach($more_pic_id as $value)
			{
				$more_pic=do_upload(array('up_path'=>UP_IMAGES_PATH,'form_name'=>"more_pic".$value,'suffix'=>UP_IMAGES_EXT));
				if($more_pic['status'] && $more_pic['file_path'] != '')
				{
					$more_pic_array[] = array('pic_path'=>$more_pic['file_path']);
				}
				else if($pic_path = $this->input->post("pic_path".$value))
				{
					$more_pic_array[] = array('pic_path'=>$pic_path);
				}
				unset($more_pic);
			}
		}
		unset($more_pic_id);
		
		//分类
		$catalog_id = $this->input->post('catalog_id');
		if(is_array($catalog_id))
		{
			$catalog_id = array_unique(explode(',',implode(",",$catalog_id)));
			$catalog_id = implode(',',$catalog_id);
		}
		if($catalog_id) $catalog_id = ','.$catalog_id.',';

		$data=array(
			'click_url' => $this->input->post("click_url"),
			'title'=>$this->input->post("title",true),
			'num_iid'=>$num_iid,
			'sid'=>$this->input->post("sid",true),
			'nick'=>$this->input->post("nick",true),
			'btitle'=>$this->input->post("btitle"),
			'keyword'=>$this->input->post("keyword",true),
			'description'=>$this->input->post("description",true),
			'volume'=>$this->input->post("volume",TRUE),
			'love'=>$this->input->post("love",TRUE),
			'catalog_id'=>$catalog_id,
			'content'=>filter_script($this->input->post("content")),
			'shop_price'=>$this->input->post("shop_price",TRUE),
			'dc_price'=>$this->input->post("dc_price",TRUE),
			'small_pic_path'=>$small_pic_path,
			'big_pic_path'=>$big_pic_path,
			'seqorder'=>$this->input->post("seqorder",TRUE)
		);
		if(stripos($big_pic_path,'_sum.jpg') !== FALSE)
		{
			$data['small_pic_path'] = str_ireplace('_sum.jpg','_230x230.jpg',$big_pic_path);
			$data['big_pic_path'] = str_ireplace('_sum.jpg','',$big_pic_path);
		}
		
		$this->db->trans_begin();
		$this->db->update("shop_product",$data,array('id'=>$id));
		
		if( ! empty($more_pic_array))
		{
			foreach($more_pic_array as $pic_row)
			{
				$pic_row['product_id']=$id;
				$this->db->insert("shop_product_image",$pic_row);
			}
		}
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			echo_msg('<li>商品修改失败</li>');
		}
		else
		{
			$this->db->trans_commit();
			echo_msg('<li>商品修改成功</li>',$this->input->post('url'),'yes');
		}
	}
	
	function pass()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			echo_msg('<li>ID有误</li>');
		}
		$rd_id = implode(',',$rd_id);
		$query = $this->common_model->get_records('SELECT * FROM '.$this->db->dbprefix.'shop_product_temp WHERE id IN('.$rd_id.')');
		foreach($query as $row)
		{
			if($this->_add_product($row))
			{
				$this->db->query('DELETE FROM '.$this->db->dbprefix.'shop_product_temp WHERE id = '.$row->id);
			}
		}
		echo_msg('<li>审核提交成功，审核通过的商品请到所有商品栏目查看。</li>','','yes');
	}
	
	function _add_product(&$v)
	{
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop_product WHERE num_iid = ?',array($v->num_iid));
		if($query) return true;
		$data=array(
			'num_iid' => $v->num_iid,
			'click_url' => $v->click_url,
			'nick'=>$v->nick,
			'title'=>$v->title,
			'btitle'=>'{title}-{site_title}',
			'props_name'=>$v->props_name,
			'volume'=>$v->volume,
			'catalog_id'=>$v->catalog_id,
			'content'=>$v->content,
			'shop_price'=>$v->shop_price,
			'dc_price'=>$v->dc_price,
			'small_pic_path'=>$v->pic_path,
			'big_pic_path'=>$v->pic_path,
			'create_date'=>time()
		);		
		$this->db->insert("shop_product",$data);
		return true;
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