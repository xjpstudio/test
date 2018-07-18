<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shop_catalog_model extends Model
{
	function Shop_catalog_model()
	{
		parent::Model();
	}
	
	function add_record()
	{
		$data=array(
			'cat_name'=>filter_str($this->input->post("cat_name")),
			'seqorder'=>$this->input->post("seqorder")
		);
		$this->db->insert("shop_catalog",$data);
		return TRUE;
	}
	
	function save_record()
	{
		$rd_id=$this->input->post("rd_id");
		$data=array(
			'cat_name'=>filter_str($this->input->post("cat_name")),
			'seqorder'=>$this->input->post("seqorder")
		);
		$this->db->update("shop_catalog",$data,array('id'=>$rd_id));
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
			$this->db->update("shop_catalog",array('seqorder'=>$sort_value),array('id'=>$row));
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
		$this->db->delete("shop_catalog");
		
		if($this->db->affected_rows())
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	function get_record($id)
	{
		$query=$this->db->get_where("shop_catalog",array('id'=>$id));
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	
	function get_records()
	{
		return $this->common_model->get_records('SELECT * FROM '.$this->db->dbprefix.'shop_catalog ORDER BY seqorder DESC,id DESC');
	}
}
?>