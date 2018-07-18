<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends Model
{
	function Admin_model()
	{
		parent::Model();
	}
	function add_record()
	{
		$user_name=$this->input->post("user_name");
		$query=$this->db->get_where("shop_admin",array('user_name'=>$user_name));
		if($query->num_rows()>0)
		{
			return FALSE;
		}
		$data=array(
			'user_name'=>$user_name,
			'password'=>md5($this->input->post("password")),
			'email'=>$this->input->post("email"),
			'create_date'=>time()
		);
		$this->db->insert("shop_admin",$data);
		return TRUE;
	}
	
	function get_records()
	{
		return $this->db->get("shop_admin");
	}
	function get_record($id)
	{
		$query=$this->db->get_where("shop_admin",array('id'=>$id));
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
		$this->db->where_in("id",$rd_id);
		$this->db->where('user_name !=',$this->session->userdata("shop_sys_user_name"));
		$this->db->delete("shop_admin");
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
		$user_name=$this->input->post("user_name");
		$query=$this->db->get_where("shop_admin",array('id !='=>$rd_id,'user_name'=>$user_name));
		if($query->num_rows()>0)
		{
			return FALSE;
		}
		$data=array(
			'user_name'=>$user_name,
			'email'=>$this->input->post("email")
		);
		if($this->input->post("password"))
		{
			$data['password']=md5($this->input->post("password"));
		}
		$this->db->update("shop_admin",$data,array('id'=>$rd_id));
		return TRUE;
	}
	
	function modify_email_do()
	{
		$data=array('email'=>$this->input->post("admin_email"));
		$this->db->update("shop_admin",$data,array('user_name'=>$this->session->userdata("shop_sys_user_name")));
		return TRUE;
	}
	
	function get_admin_email()
	{
		$query=$this->db->get_where("shop_admin",array('user_name'=>$this->session->userdata("shop_sys_user_name")));
		$row=$query->row();
		return $row->email;
	}

	function update_password($old_password,$new_password)
	{
		$this->db->where('user_name',$this->session->userdata("shop_sys_user_name"));
		$this->db->where('password',$old_password);
		$query=$this->db->get("shop_admin");
		if($query->num_rows()>0)
		{
			$this->db->update('shop_admin',array('password'=>$new_password),array('user_name'=>$this->session->userdata("shop_sys_user_name")));
			return true;
		}
		else
		{
			return false;
		}
	}
}
//end of file :Admin_model.php