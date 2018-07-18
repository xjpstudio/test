<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends Model
{
	var $catalog_arr=array();
	function Menu_model()
	{
		parent::Model();
	}
	function add_record()
	{
		$data=array(
			'cat_name'=>$this->input->post("cat_name"),
			'seqorder'=>$this->input->post("seqorder"),
			'hplink'=>$this->input->post("hplink"),
			'is_trash'=>$this->input->post("is_trash")?1:0,
			'parent_id'=>$this->input->post("parent_id")
		);
		$this->db->insert("shop_menu",$data);
		if($this->db->affected_rows())
		{
			return TRUE;	
		}
		else
		{
			return FALSE;
		}
	}
	function save_record()
	{
		$rd_id=$this->input->post("rd_id");
		$data=array(
			'cat_name'=>$this->input->post("cat_name"),
			'seqorder'=>$this->input->post("seqorder"),
			'hplink'=>$this->input->post("hplink"),
			'is_trash'=>$this->input->post("is_trash")?1:0,
			'parent_id'=>$this->input->post("parent_id")
		);
		$this->db->update("shop_menu",$data,array('id'=>$rd_id));
		return TRUE;
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
			$this->db->update("shop_menu",array('seqorder'=>$sort_value),array('id'=>$row));
		}
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
		$this->db->delete("shop_menu");
		$this->db->where_in("parent_id",$rd_id);
		$this->db->delete("shop_menu");
		return TRUE;
	}
	
	
	function get_record($id)
	{
		$query=$this->db->get_where("shop_menu",array('id'=>$id));
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	
	function get_records()
	{
		$this->parse_catalog(0);
		return $this->catalog_arr;
	}
	
	function parse_catalog($id)
	{
		$this->db->where('parent_id',$id);
		$this->db->order_by('seqorder','asc');
		$this->db->order_by('id','desc');
		$query=$this->db->get("shop_menu");
		foreach($query->result() as $row)
		{
			$this->catalog_arr[]=$row;
			$this->parse_catalog($row->id);
		}
	}
	
	function ajax_toggle()
	{
		$rd_id=$this->input->post('rd_id');
		$query=$this->db->get_where("shop_menu",array('id'=>$rd_id));
		$rs=$query->row_array();
		$data=$rs['is_trash']?0:1;
		$this->db->update('shop_menu',array('is_trash'=>$data),array('id'=>$rd_id));
		return TRUE;
	}
}
?>