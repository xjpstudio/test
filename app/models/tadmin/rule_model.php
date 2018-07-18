<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rule_model extends Model
{
	function Rule_model()
	{
		parent::Model();
	}
	
	function add_record()
	{
		$data=array(
			'title'=>$this->input->post("title",true),
			'f_url'=>$this->input->post("f_url"),
			'p_url'=>$this->input->post("p_url"),
			'page_total'=>$this->input->post("page_total"),
			'page_step'=>$this->input->post("page_step"),
			'list_block_s'=>$this->input->post("list_block_s"),
			'list_block_e'=>$this->input->post("list_block_e"),
			'list_link_s'=>$this->input->post("list_link_s"),
			'list_link_e'=>$this->input->post("list_link_e"),
			'detail_s'=>$this->input->post("detail_s"),
			'detail_e'=>$this->input->post("detail_e"),
			'charset'=>$this->input->post("charset")
		);
		$this->db->insert("shop_rule",$data);
		return TRUE;
	}
	
	function get_record($id)
	{
		$query=$this->db->get_where("shop_rule",array('id'=>$id));
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	
	function save_record()
	{
		$rd_id=$this->input->post("rd_id");
		$data=array(
			'title'=>$this->input->post("title",true),
			'f_url'=>$this->input->post("f_url"),
			'p_url'=>$this->input->post("p_url"),
			'page_total'=>$this->input->post("page_total"),
			'page_step'=>$this->input->post("page_step"),
			'list_block_s'=>$this->input->post("list_block_s"),
			'list_block_e'=>$this->input->post("list_block_e"),
			'list_link_s'=>$this->input->post("list_link_s"),
			'list_link_e'=>$this->input->post("list_link_e"),
			'detail_s'=>$this->input->post("detail_s"),
			'detail_e'=>$this->input->post("detail_e"),
			'charset'=>$this->input->post("charset")
		);
		$this->db->update("shop_rule",$data,array('id'=>$rd_id));
		return TRUE;
	}
	
	function save_copy_record()
	{
		$data=array(
			'title'=>$this->input->post("title",true),
			'f_url'=>$this->input->post("f_url"),
			'p_url'=>$this->input->post("p_url"),
			'page_total'=>$this->input->post("page_total"),
			'page_step'=>$this->input->post("page_step"),
			'list_block_s'=>$this->input->post("list_block_s"),
			'list_block_e'=>$this->input->post("list_block_e"),
			'list_link_s'=>$this->input->post("list_link_s"),
			'list_link_e'=>$this->input->post("list_link_e"),
			'detail_s'=>$this->input->post("detail_s"),
			'detail_e'=>$this->input->post("detail_e"),
			'charset'=>$this->input->post("charset")
		);
		
		$this->db->insert("shop_rule",$data);
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
		$this->db->delete("shop_rule");
		if($this->db->affected_rows())
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
?>
