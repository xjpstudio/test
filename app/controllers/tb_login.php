<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 */
class Tb_login extends Controller
{
	var $site_title;
	
	function Tb_login()
	{
		parent::Controller();
		$this->load->model('com_model');
		$this->load->database();
		$this->site_title = $this->config->item('sys_site_title');
		$this->load->config('top_config');
		session_start();
	}
	
	function index()
	{
		if($this->com_model->_check_login())
		{
			redirect(CTL_FOLDER.'user');
		}
		$key = $this->config->item('appkey');
		redirect('https://oauth.taobao.com/authorize?response_type=code&scope='.urlencode('item,promotion,usergrade').'&client_id='.$key['appkey'].'&redirect_uri='.urlencode(site_url(CTL_FOLDER.'tb_login/callback')));
	}
	
	function callback()
	{
		if($this->com_model->_check_login())
		{
			redirect(CTL_FOLDER.'user');
		}
		parse_str($_SERVER['QUERY_STRING'],$get);
		if( ! isset($get['code']) || ! $get['code']) 
		{
			echo_msg('<li>'.$get['error_description'].'</li>','','no','_blank');
		}
		$key = $this->config->item('appkey');
		$postfields= array(
			'grant_type'     => 'authorization_code',
			'client_id'     => $key['appkey'],
			'client_secret' => $key['secretkey'],
			'code'          => $get['code'],
			'redirect_uri'  => site_url(CTL_FOLDER.'tb_login/callback')
		 );
		 
		 $url = 'https://oauth.taobao.com/token';
		 $token = json_decode($this->_curl($url,$postfields));
		 if( ! isset($token->access_token)) echo_msg('<li>签名验证失败，请重新登录。</li>','','no','_blank');
		
		 $nick = urldecode($token->taobao_user_nick);
		 $taobao_id = $token->taobao_user_id;
		 unset($token);
		 
		 $user = $this->common_model->get_record('SELECT id,last_login_ip,last_login_time,login_times,user_name FROM '.$this->db->dbprefix."shop_user WHERE taobao_id = ?",array($taobao_id));
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
			$ssa = array();
			$ssa['taobao_id'] = $taobao_id;
			$ssa['nick'] = urldecode($nick);
			$ssa = serialize($ssa);
			$_SESSION['login_data'] = $ssa;
			redirect(site_url(CTL_FOLDER.'tb_login/tb_reg'));
		}
	}
	
	function tb_reg()
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
		$this->load->view(TPL_FOLDER.'tb_reg',$data);
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
		if( ! isset($login_data['taobao_id']) || ! isset($login_data['nick'])) echo_msg('<li>session数据丢失，请重新登录</li>',my_site_url(CTL_FOLDER.'login'),'no');
		
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
			'taobao_id' => $login_data['taobao_id'],
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
		if( ! isset($login_data['taobao_id']) || ! isset($login_data['nick'])) echo_msg('<li>session数据丢失，请重新登录</li>',my_site_url(CTL_FOLDER.'login'),'no');
		
		$user_name = $this->input->post('user_name',true);
		$password = $this->input->post('password',true);
		$user = $this->common_model->get_record('SELECT id,last_login_ip,last_login_time,login_times,user_name FROM '.$this->db->dbprefix.'shop_user WHERE user_name = ? AND password = ?',array($user_name,md5($password)));
		if($user)
		{
			$data = array(
				'last_login_ip'  => $this->input->ip_address(),
				'last_login_time'  => time(),
				'taobao_id' => $login_data['taobao_id'],
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
	
	function _curl($url, $postFields = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if (is_array($postFields) && 0 < count($postFields))
		{
			$postBodyString = "";
			foreach ($postFields as $k => $v)
			{
				$postBodyString .= "$k=" . urlencode($v) . "&"; 
			}
			unset($k, $v);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);  
 			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
		}
		$reponse = curl_exec($ch);
		if (curl_errno($ch)){
			throw new Exception(curl_error($ch),0);
		}
		else{
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if (200 !== $httpStatusCode){
				throw new Exception($reponse,$httpStatusCode);
			}
		}
		curl_close($ch);
		return $reponse;
	}
}
?>