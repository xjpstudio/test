<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends Model
{
	function Login_model()
	{
		parent::Model();
	}
	
	function check_user($user_name,$password)
	{
		$this->db->where('user_name',$user_name);
		$this->db->where('password',$password);
		$query=$this->db->get("shop_admin");
		if($query->num_rows>0)
		{
			$row=$query->row();
			$data=array(
				'last_login_ip'=>$this->input->ip_address(),
				'last_login_time'=>time(),
				'hits'=>$row->hits+1
			);
			$this->db->where('user_name',$user_name);
			$this->db->update('shop_admin',$data);
			
			$session_data=array(
				'shop_sys_user_id'=>$row->id,
				'shop_sys_user_name'=>$row->user_name,
				'shop_sys_md5_encode_str'=>md5($row->user_name.$this->config->item('md5_encode_key')),
				'shop_sys_last_login_time'=>date("Y-m-d H:i:s",$row->last_login_time),
				'shop_sys_last_login_ip'=>$row->last_login_ip,
				'shop_sys_user_role'=>$row->user_role,
				'shop_sys_hits'=>$data['hits']
			);
			$this->session->set_userdata($session_data);
			return true;
		}
		else
		{
			return false;
		}
		
	}

	function send_password()
	{
		$etpl=get_email_template(1);
		if($etpl->status==0) return 3;
		$this->load->helper('string');
		$data=array(
			'user_name' => $this->input->post("user_name"),
			'email' => $this->input->post("email")
		);
		$query=$this->db->get_where("shop_admin",$data);
		if($query->num_rows()>0)
		{
			$new_password=random_string('alnum', 6);
			$sb=replace_email_template($etpl->title);
			$mg=replace_email_template($etpl->content);
			$mg=str_replace('{tpl_user_name}',$data['user_name'],$mg);
			$mg=str_replace('{tpl_user_password}',$new_password,$mg);
			if($this->_send_email($data['email'],$sb,$mg))
			{
				$this->db->update('shop_admin',array('password'=>md5($new_password)),$data);
				return 0;
			}
			else
			{
				return 2;
			}
		}
		else
		{
			return 1;
		}
	}
	
	function _send_email($to,$sb,$mg)
	{
		$this->config->load('shop_email_config', FALSE, TRUE);
		$this->config->load('shop_site_config', FALSE, TRUE);
		$config['smtp_host'] = $this->config->item('smtp_host');
		$config['smtp_user'] = $this->config->item('smtp_user');
		$config['smtp_pass'] = $this->config->item('smtp_pass');
		$config['protocol'] = 'smtp';
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		
		$this->load->library('email',$config);
		$this->email->from($this->config->item('smtp_email'), $this->config->item('sys_site_name'));
		$this->email->to($to); 
		
		$this->email->subject($sb);
		$this->email->message($mg); 
		if($this->email->send())
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