<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends Controller
{
	function Main()
	{
		parent::Controller();
		check_is_login();
	}
	function index()
	{
		$this->load->view(TPL_FOLDER."main");
	}
	function top()
	{	
		$this->load->view(TPL_FOLDER."top");
	}
	function bottom()
	{	
		$this->load->view(TPL_FOLDER."bottom");
	}
	function menu()
	{	
		$this->load->database();
		$this->db->order_by('seqorder','asc');
		$this->db->order_by('id','desc');
		$query1=$this->db->get_where("shop_menu",array('parent_id'=>0,'is_trash'=>0));
		$this->db->order_by('seqorder','asc');
		$this->db->order_by('id','desc');
		$query2=$this->db->get_where("shop_menu",array('parent_id >'=>0,'is_trash'=>0));
		$data=array(
			'query1' => $query1,
			'query2' => $query2
		);
		$this->load->view(TPL_FOLDER."left_menu",$data);
	}
	
	function welcome()
	{	
		$tpl_data=array(
			'sys_user_name'=>$this->session->userdata("shop_sys_user_name"),
			'sys_last_login_time'=>$this->session->userdata("shop_sys_last_login_time"),
			'sys_last_login_ip'=>$this->session->userdata("shop_sys_last_login_ip"),
			'sys_user_role'=>$this->session->userdata("shop_sys_user_role"),
			'sys_hits'=>$this->session->userdata("shop_sys_hits")
		);
		$this->load->view(TPL_FOLDER."welcome",$tpl_data);
	}
	
	function clear_cache()
	{
		$this->load->helper('file');
		delete_files($this->config->item('apicache_path'),TRUE);
		echo 1;
	}
	
	function clear_cache1()
	{
		$this->load->helper('file');
		delete_files($this->config->item('cache_path'),TRUE);
		echo 1;
	}
}
?>