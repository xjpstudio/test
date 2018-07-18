<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends Model
{
	function User_model()
	{
		parent::Model();
	}
	
	function get_record($id)
	{
		$query=$this->db->get_where("shop_user",array('id'=>$id));
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	
	function del_record()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			return FALSE;
		}
		$rd_id = implode(',',$rd_id);
		$this->db->trans_begin();
		$this->db->simple_query('DELETE FROM '.$this->db->dbprefix.'shop_comment WHERE user_id in ('.$rd_id.')');
		$this->db->simple_query('DELETE FROM '.$this->db->dbprefix.'shop_user WHERE id in ('.$rd_id.')');
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		else
		{
			$this->db->trans_commit();
			return TRUE;
		}
	}
}
?>