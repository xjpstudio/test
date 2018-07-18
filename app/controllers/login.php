<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * user guestbook  shopping Etc.
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 */
class Login extends Controller
{
	var $site_title;
	
	function Login()
	{
		parent::Controller();
		$this->load->database();
		$this->load->model('com_model');
		$this->site_title=$this->config->item('sys_site_title');
		$this->load->library('form_validation');
	}
	
	function index()
	{
		if($this->session->userdata('shop_user_name')) redirect(CTL_FOLDER.'user');
		parse_str($_SERVER['QUERY_STRING'],$get);
		$data = array(
			'site_title'		=> '用户登录--'.$this->site_title
		);
		if(isset($get['url'])) $data['url'] = $get['url'];
		$this->load->view(TPL_FOLDER.'login',$data);
	}
	
	function logout()
	{
		$this->com_model->destroy_session();
		if(strpos($_SERVER['HTTP_REFERER'],'user') !== FALSE || strpos($_SERVER['HTTP_REFERER'],'user') !== FALSE)
		{
			redirect(site_url('login'));
		}
		else
		{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	function check_user_login()
	{
		if($this->session->userdata('shop_user_name')) redirect(CTL_FOLDER.'user');
		$this->form_validation->set_rules('user_name','用户名','trim|required');
		$this->form_validation->set_rules('password','密码','trim|required');
		$tx_msg='';
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg.=$this->form_validation->error_string();
			echo_msg($tx_msg);
		}
		$user_name = $this->input->post('user_name',true);
		$password = $this->input->post('password',true);
		$user = $this->common_model->get_record('SELECT id,last_login_ip,last_login_time,login_times FROM '.$this->db->dbprefix.'shop_user WHERE user_name = ? AND password = ?',array($user_name,md5($password)));
		if($user)
		{
			$last_login_time = $user->last_login_time;
			$data = array(
				'last_login_ip'  => $this->input->ip_address(),
				'last_login_time'  => time(),
				'login_times' => $user->login_times + 1
			);
			$this->db->update('shop_user',$data,array('id'=>$user->id));
			
			$session_data=array(
				'shop_user_id'=>$user->id,
				'shop_last_login_time'=>$last_login_time,
				'shop_user_name'=>$user_name,
				'shop_user_md5_encode_str'=>md5($user_name.$this->config->item('md5_encode_key'))
			);
			$this->session->set_userdata($session_data);
			
			if($url = $this->input->post('url'))
			{
				redirect($url);
			}
			else if(isset($_SERVER['HTTP_REFERER']))
			{
				redirect($_SERVER['HTTP_REFERER']);
			}
			else
			{
				redirect(CTL_FOLDER.'user');
			}
		}
		else
		{
			echo_msg('<li>账号或者密码有误</li>');
		}
	}
	
	function save_reg()
	{
		if($this->session->userdata('shop_user_name')) redirect(CTL_FOLDER.'user');
		$this->form_validation->set_rules('user_name','用户名','trim|user_name');
		$this->form_validation->set_rules('password1','密码','trim|required|matches[repassword1]');
		$this->form_validation->set_rules('repassword1','重复密码','trim|required');
		if($this->form_validation->run()==FALSE) echo_msg($this->form_validation->error_string());
		
		$user_name = $this->input->post('user_name',true);
		$query=$this->db->get_where('shop_user',array('user_name'=>$user_name));
		if($query->num_rows()>0) echo_msg('<li>该用户已经存在，请返回重新填写.</li>');
		unset($query);
		
		$password = $this->input->post('password1',true);
		$last_login_ip = $this->input->ip_address();
		$last_login_time = time();
		$login_times = 1;
		
		$data = array(
			'user_name' => $user_name,
			'password' => md5($password),
			'create_date' => $last_login_time,
			'last_login_ip' => $last_login_ip,
			'last_login_time' => $last_login_time,
			'login_times' => $login_times
		);
		
		$this->db->insert('shop_user',$data);
		$user_id = $this->db->insert_id();
		
		$session_data=array(
			'shop_user_id'=>$user_id,
			'shop_user_name'=>$user_name,
			'shop_last_login_time'=>$last_login_time,
			'shop_user_md5_encode_str'=>md5($user_name.$this->config->item('md5_encode_key'))
		);
		$this->session->set_userdata($session_data);
		
		$tx_msg='<li>恭喜您，注册成功.</li>';
		if($url = $this->input->post('url'))
		{
			redirect($url);
		}
		else if(isset($_SERVER['HTTP_REFERER']))
		{
			redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			redirect(CTL_FOLDER.'user');
		}
	}
}
?>