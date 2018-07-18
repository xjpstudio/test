<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_model extends Model
{
	function News_model()
	{
		parent::Model();
	}
	
	function add_record($f_path)
	{
		$data=array(
			'title'=>filter_str($this->input->post("title")),
			'catalog_id'=>$this->input->post("catalog_id"),
			'seqorder'=>$this->input->post("seqorder"),
			'btitle'=>$this->input->post("btitle"),
			'keyword'=>filter_str($this->input->post("keyword")),
			'description'=>filter_str($this->input->post("description")),
			'summary'=>$this->input->post("summary"),
			'author'=>filter_str($this->input->post("author")),
			'source'=>filter_str($this->input->post("source")),
			'content'=>$this->input->post("content"),
			'create_date'=>strtotime($this->input->post("create_date"))
		);
		if($f_path['file_path'])
		{
			$data['pic_path']=$f_path['file_path'];
		}
		else
		{
			$data['pic_path']=$this->input->post("pic_path");
		}
		$this->db->insert("shop_news",$data);
		return TRUE;
	}
	
	function get_record($id)
	{
		$query=$this->db->get_where("shop_news",array('id'=>$id));
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	
	function get_catalog_records()
	{
		return $this->parse_catalog(0);
	}
	
	function sort_record()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			return FALSE;
		}
		foreach($rd_id as $row)
		{
			$sort_value=$this->input->post("sort".$row)?(int)$this->input->post("sort".$row):0;
			$this->db->update("shop_news",array('seqorder'=>$sort_value),array('id'=>$row));
		}
		return TRUE;
	}
	
	function save_record($f_path)
	{
		$rd_id=$this->input->post("rd_id");
		
		$data=array(
			'title'=>filter_str($this->input->post("title")),
			'btitle'=>$this->input->post("btitle"),
			'catalog_id'=>$this->input->post("catalog_id"),
			'seqorder'=>$this->input->post("seqorder"),
			'keyword'=>filter_str($this->input->post("keyword")),
			'description'=>filter_str($this->input->post("description")),
			'author'=>filter_str($this->input->post("author")),
			'source'=>filter_str($this->input->post("source")),
			'summary'=>$this->input->post("summary"),
			'is_create'=>0,
			'create_date'=>strtotime($this->input->post("create_date")),
			'content'=>$this->input->post("content")
		);
		if($f_path['file_path'])
		{
			$data['pic_path']=$f_path['file_path'];
		}
		else
		{
			$data['pic_path']=$this->input->post("pic_path");
		}
		$this->db->update("shop_news",$data,array('id'=>$rd_id));
		return TRUE;
	}
	
	function save_copy_record($f_path)
	{
		$data=array(
			'title'=>filter_str($this->input->post("title")),
			'btitle'=>$this->input->post("btitle"),
			'catalog_id'=>$this->input->post("catalog_id"),
			'seqorder'=>$this->input->post("seqorder"),
			'keyword'=>filter_str($this->input->post("keyword")),
			'description'=>filter_str($this->input->post("description")),
			'author'=>filter_str($this->input->post("author")),
			'source'=>filter_str($this->input->post("source")),
			'summary'=>$this->input->post("summary"),
			'create_date'=>strtotime($this->input->post("create_date")),
			'content'=>$this->input->post("content")
		);
		if($f_path['file_path'])
		{
			$data['pic_path']=$f_path['file_path'];
		}
		else
		{
			$data['pic_path']=$this->input->post("pic_path");
		}
		$this->db->insert("shop_news",$data);
		return TRUE;
	}
	
	function del_record()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			return FALSE;
		}
		$this->db->where_in("id",$rd_id);
		$this->db->delete("shop_news");
		foreach($rd_id as $id)
		{
			@unlink(create_link($id,'x'));
		}
		return TRUE;
	}
	
	function to_catalog()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			return FALSE;
		}
		$data=array(
			'catalog_id'=>$this->input->post('to_catalog_id')
		);
		$this->db->where_in("id",$rd_id);
		$this->db->update('shop_news',$data);
		return TRUE;
	}
	
	function parse_catalog($id)
	{
		static $catalog_arr=array();
		$this->db->where('parent_id',$id);
		$this->db->order_by('seqorder','desc');
		$this->db->order_by('id','desc');
		$query=$this->db->get("shop_news_catalog");
		foreach($query->result() as $row)
		{
			$catalog_arr[]=$row;
			if($row->is_has_chd==1)
			{
				$this->parse_catalog($row->id);
			}
		}
		return $catalog_arr;
	}
}
?>