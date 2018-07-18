<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 */
class Qq_login extends Controller
{
	var $site_title;
	
	function Qq_login()
	{
		parent::Controller();
		$this->load->database();
		$this->load->model('com_model');
		$this->site_title=$this->config->item('sys_site_title');
		session_start();
		$this->load->config('qq_config');
	}
	
	function index()
	{
		$qq_config = $this->config->item('qq_config');
		$state = md5(uniqid(rand(), TRUE));
        $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=". $qq_config['appid']. "&redirect_uri=" .str_replace('http://','',site_url(CTL_FOLDER.'qq_login/callback')). "&state=" . $state. "&scope=get_user_info";
		$_SESSION['state'] = $state;
		redirect($login_url);
	}
	
	function callback()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		$access_token = '';
		if(isset($get['state']) && $get['state'] == $_SESSION['state'])
		{
			$qq_config = $this->config->item('qq_config');
			$token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&". "client_id=".$qq_config['appid']. "&redirect_uri=" . urlencode(str_replace('http://','',site_url(CTL_FOLDER.'qq_login/callback'))). "&client_secret=" .$qq_config['appkey']. "&code=" . $get["code"];
			$response = get_content($token_url);
			if(strpos($response, "callback") !== false)
			{
				$lpos = strpos($response, "(");
				$rpos = strrpos($response, ")");
				$response  = substr($response, $lpos + 1, $rpos - $lpos -1);
				$msg = json_decode($response);
				if (isset($msg->error))
				{
					$err = "<li>error:" . $msg->error.'</li>'."<li>msg:" . $msg->error_description.'</li>';
					echo_msg($err,my_site_url(CTL_FOLDER.'login'),'no');
				}
			}
            unset($get);
			parse_str($response, $get);
			if( ! isset($get['access_token']) ||  ! isset($get['expires_in']))
			{
				echo_msg('<li>返回数据有误，请重新登录。</li>',my_site_url(CTL_FOLDER.'login'),'no');
			}
		}
		else
		{
			echo_msg('<li>session超时，请重新登录。</li>',my_site_url(CTL_FOLDER.'login'),'no');
		}
		
		unset($_SESSION['state']);
		
		$graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$get['access_token'];

		$openid = '';
		$str  = get_content($graph_url);
		if (strpos($str, "callback") !== false)
		{
			$lpos = strpos($str, "(");
			$rpos = strrpos($str, ")");
			$str  = substr($str, $lpos + 1, $rpos - $lpos -1);
		}
	
		$user = json_decode($str);
		if (isset($user->error))
		{
			$err = "<li>error:" . $user->error.'</li>'."<li>msg:" . $user->error_description.'</li>';
			echo_msg($err,my_site_url(CTL_FOLDER.'login'),'no');
		}
	
		if( ! isset($user->openid))
		{
			echo_msg('<li>返回参数有误，请重新登录。</li>',my_site_url(CTL_FOLDER.'login'),'no');
		}
		else
		{
			$openid = $user->openid;
			unset($user);
		}
		
		 $user = $this->common_model->get_record('SELECT id,last_login_ip,last_login_time,login_times,user_name FROM '.$this->db->dbprefix."shop_user WHERE qq_id = ?",array($openid));
		if($user)
		{
			$data = array(
				'last_login_ip'  => $this->input->ip_address(),
				'last_login_time'  => time(),
				'login_times' => $user->login_times + 1
			);
			$this->db->update('shop_user',$data,array('id'=>$user->id));
			
			$session_data=array(
				'shop_user_id'=>$user->id,
				'shop_user_name'=>$user->user_name,
				'shop_user_md5_encode_str'=>md5($user->user_name.$this->config->item('md5_encode_key')),
				'shop_last_login_time'=>$user->last_login_time
			);
			$this->session->set_userdata($session_data);
			
			redirect(CTL_FOLDER.'user');
		}
		else
		{
			$get_user_info = "https://graph.qq.com/user/get_user_info?". "access_token=" . $get['access_token']. "&oauth_consumer_key=" .$qq_config['appid']. "&openid=" . $openid. "&format=json";
			$info = get_content($get_user_info);
			$arr = json_decode($info, true);
			if(isset($arr['nickname'])) $nick = $arr['nickname'];
			else $nick = ''; 
			unset($arr);
			
			$ssa = array();
			$ssa['qq_id'] = $openid;
			$ssa['nick'] = urldecode($nick);
			$ssa = serialize($ssa);
			$_SESSION['login_data'] = $ssa;
			redirect(site_url(CTL_FOLDER.'qq_login/qq_reg'));
		}
	}
	
	function qq_reg()
	{
		if($this->com_model->_check_login()) redirect(CTL_FOLDER.'user');
		if(! isset($_SESSION['login_data']) || empty($_SESSION['login_data']))
		{
			echo_msg('<li>session数据丢失，请重新登录</li>',my_site_url(CTL_FOLDER.'login'),'no');
		}
		$a = unserialize($_SESSION['login_data']);
		
		$data = array(
			'site_title' => '快速注册--'.$this->site_title,
			'nick' => $a['nick']
		);
		$this->load->view(TPL_FOLDER.'qq_reg',$data);
	}
	
	function add_user()
	{
		if($this->com_model->_check_login()) redirect(CTL_FOLDER.'user');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_name','用户名','trim|required');
		
		if($this->form_validation->run()==FALSE)
		{
			echo_msg($this->form_validation->error_string());
		}
		
		if(! isset($_SESSION['login_data']) || empty($_SESSION['login_data']))
		{
			echo_msg('<li>session数据丢失，请重新登录</li>',my_site_url(CTL_FOLDER.'login'),'no');
		}
		
		$login_data = unserialize($_SESSION['login_data']);
		if( ! isset($login_data['qq_id']) || ! isset($login_data['nick'])) echo_msg('<li>session数据丢失，请重新登录</li>',my_site_url(CTL_FOLDER.'login'),'no');
		
		$user_name = $this->input->post('user_name',true);
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix."shop_user WHERE user_name = ?",array($user_name));
		if($query)
		{
			echo_msg('<li>该用户已经存在，请返回重新填写.</li>');
		}
		
		$last_login_ip = $this->input->ip_address();
		$last_login_time = time();
		$login_times = 1;
		
		$data = array(
			'user_name' => $user_name,
			'qq_id' => $login_data['qq_id'],
			'create_date' => $last_login_time,
			'last_login_ip' => $last_login_ip,
			'last_login_time' => $last_login_time,
			'login_times' => $login_times
		);
		$this->db->insert('shop_user',$data);
		$user_id = $this->db->insert_id();
		unset($data);unset($login_data);
		
		$session_data=array(
			'shop_user_id'=>$user_id,
			'shop_user_name'=>$user_name,
			'shop_last_login_time'=>$last_login_time,
			'shop_user_md5_encode_str'=>md5($user_name.$this->config->item('md5_encode_key'))
		);
		$this->session->set_userdata($session_data);
		
		unset($_SESSION['login_data']);
		redirect(CTL_FOLDER.'user');
	}
	
	function bind_user()
	{
		if($this->com_model->_check_login()) redirect(CTL_FOLDER.'user');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_name','用户名','trim|required');
		$this->form_validation->set_rules('password','密码','trim|required');
		if($this->form_validation->run()==FALSE)
		{
			echo_msg($this->form_validation->error_string());
		}
		
		if(! isset($_SESSION['login_data']) || empty($_SESSION['login_data']))
		{
			echo_msg('<li>session数据丢失，请重新登录</li>',my_site_url(CTL_FOLDER.'login'),'no');
		}
		
		$login_data = unserialize($_SESSION['login_data']);
		if( ! isset($login_data['qq_id']) || ! isset($login_data['nick'])) echo_msg('<li>session数据丢失，请重新登录</li>',my_site_url(CTL_FOLDER.'login'),'no');
		
		$user_name = $this->input->post('user_name',true);
		$password = $this->input->post('password',true);
		$user = $this->common_model->get_record('SELECT id,last_login_ip,last_login_time,login_times,user_name FROM '.$this->db->dbprefix.'shop_user WHERE user_name = ? AND password = ?',array($user_name,md5($password)));
		if($user)
		{
			$data = array(
				'last_login_ip'  => $this->input->ip_address(),
				'last_login_time'  => time(),
				'qq_id' => $login_data['qq_id'],
				'login_times' => $user->login_times + 1
			);
			$this->db->update('shop_user',$data,array('id'=>$user->id));
			
			unset($_SESSION['login_data']);
			
			$session_data=array(
				'shop_user_id'=>$user->id,
				'shop_user_name'=>$user_name,
				'shop_last_login_time'=>$user->last_login_time,
				'shop_user_md5_encode_str'=>md5($user_name.$this->config->item('md5_encode_key'))
			);
			$this->session->set_userdata($session_data);
			
			redirect(CTL_FOLDER.'user');
		}
		else
		{
			echo_msg('<li>账号或者密码有误，请返回重新填写</li>');
		}
	}
}
?>