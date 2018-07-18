<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends Controller
{
	function Login()
	{
		parent::Controller();
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->model("tadmin/Login_model");
	}
	
	function index()
	{
		$this->load->config('shop_site_config');
		$data = array(
			'site_title' => $this->config->item('sys_site_name')
		);
		$this->load->view(TPL_FOLDER."login",$data);
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect(CTL_FOLDER.'login');
	}

	function check_login()
	{
		if($this->session->userdata("shop_sys_user_name"))
		{
			redirect(CTL_FOLDER."main");
		}
		$this->form_validation->set_rules('user_name','管理员账号','required');
		$this->form_validation->set_rules('password','管理员密码','required');
		
		$tx_msg="";
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg.=validation_errors();
		}
		if($tx_msg!="")
		{
			echo_msg($tx_msg);
		}
		if($this->Login_model->check_user($this->input->post("user_name"),md5($this->input->post("password"))))
		{
			redirect(CTL_FOLDER."main");
		}
		else
		{
			$tx_msg="<li>管理员账号或者密码有误</li>";
			echo_msg($tx_msg);
		}
	}
	
	function find_password()
	{
		$this->load->view(TPL_FOLDER."find_password");
	}
	
	function send_password()
	{
		$this->form_validation->set_rules('user_name','管理员账号','required');
		$this->form_validation->set_rules('email','管理员邮箱','required|valid_email');
		
		$tx_msg="";
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg.=validation_errors();
		}
		if($tx_msg!="")
		{
			echo_msg($tx_msg);
		}
		$rt_id=$this->Login_model->send_password();
		if($rt_id==0)
		{
			$tx_msg="<li>密码修改成功，且新密码已经发送到您的邮箱：".$this->input->post("email")." 请及时查收。</li>";
			echo_msg($tx_msg,site_url(TPL_FOLDER."login"),'yes');
		}
		elseif($rt_id==1)
		{
			$tx_msg="<li>管理员帐号或者邮箱有误，请返回重新提交</li>";
			echo_msg($tx_msg);
		}
		elseif($rt_id==2)
		{
			$tx_msg="<li>新密码没能发送到您的邮箱，密码修改失败</li>";
			echo_msg($tx_msg);
		}
		elseif($rt_id==3)
		{
			$tx_msg="<li>密码发送功能已经被关闭，无法完成密码修改。</li>";
			echo_msg($tx_msg);
		}
	}
	
}
?>