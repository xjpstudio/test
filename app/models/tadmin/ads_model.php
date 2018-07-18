<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ads_model extends Model
{
	function Ads_model()
	{
		parent::Model();
	}
	function add_record($f_path)
	{
		$data=array(
			'is_pic'=>$this->input->post("is_pic"),
			'title'=>filter_str($this->input->post("title")),
			'width'=>$this->input->post("width"),
			'height'=>$this->input->post("height"),
			'hplink'=>$this->input->post("hplink"),
			'js_code'=>$this->input->post("js_code")
		);
		if($f_path['file_path'])
		{
			$data['file_path']=$f_path['file_path'];
		}
		else
		{
			$data['file_path']=$this->input->post("pic_path");
		}
		$this->db->insert("shop_ads",$data);
		return TRUE;
	}
	function get_records()
	{
		$this->db->where('cid',TPL_FOLDER_NAME);
		$this->db->order_by('id','asc');
		return $this->db->get("shop_ads");
	}
	
	function get_record($id)
	{
		$query=$this->db->get_where("shop_ads",array('id'=>$id));
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	
	function save_record($f_path)
	{
		$rd_id=$this->input->post("rd_id");
		$data=array(
			'is_pic'=>$this->input->post("is_pic"),
			'title'=>filter_str($this->input->post("title")),
			'width'=>$this->input->post("width"),
			'height'=>$this->input->post("height"),
			'hplink'=>$this->input->post("hplink"),
			'js_code'=>$this->input->post("js_code")
		);
		if($f_path['file_path'])
		{
			$data['file_path']=$f_path['file_path'];
		}
		else
		{
			$data['file_path']=$this->input->post("pic_path");
		}
		$this->db->update("shop_ads",$data,array('id'=>$rd_id));
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
		$this->db->delete("shop_ads");
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