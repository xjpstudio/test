<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * user guestbook  shopping Etc.
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 */
class User extends Controller
{
	var $site_title;
	var $user_id = 0;
	
	function User()
	{
		parent::Controller();
		$this->load->database();
		$this->load->model('com_model');
		$this->com_model->check_is_login();
		$this->site_title=$this->config->item('sys_site_title');
		$this->load->library('form_validation');
		if($user_id = $this->session->userdata('shop_user_id')) 
		{
			$this->user_id = $user_id;
		}
	}
	
	function index()
	{
		$data = array(
			'site_title' => '用户中心--'.$this->site_title,
			'user' => $this->common_model->get_record('SELECT * FROM '.$this->db->dbprefix.'shop_user WHERE id = ?',array($this->user_id))
		);
		$this->load->view(TPL_FOLDER.'user',$data);
	}
	
	function edit_user()
	{
		$data = array(
			'site_title' => '修改用户资料--'.$this->site_title,
			'user' => $this->common_model->get_record('SELECT * FROM '.$this->db->dbprefix.'shop_user WHERE id = ?',array($this->user_id))
		);
		$this->load->view(TPL_FOLDER.'edit_user',$data);
	}
	
	function save_edit_user()
	{
		$this->form_validation->set_rules('email','电子邮箱','valid_email');
		if($this->form_validation->run() == FALSE) echo_msg(validation_errors());
		$data = array(
			'email' => $this->input->post('email',true),
			'qq' => $this->input->post('qq',true),
			'wangwang' => $this->input->post('wangwang',true)
		);
		if($password = $this->input->post('password',true))
		{
			$data['password'] = md5($password);
		}
		$this->db->update('shop_user',$data,array('id'=>$this->user_id));
		$tx_msg='<li>个人资料修改成功.</li>';
		echo_msg($tx_msg,my_site_url('user'),'yes');
	}
	
	function save_comment()
	{
		$this->load->config('comment_config');
		if($this->config->item('com_is_open') == 2) echo_msg('<li>评论已经关闭</li>');
		
		$this->form_validation->set_rules('product_id','商品ID','is_natural_no_zero');
		$this->form_validation->set_rules('content','评论内容','required|max_length[200]');
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		
		$product_id = $this->input->post('product_id',true);
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop_product WHERE id = ?',array($product_id));
		if( ! $query) echo_msg('<li>评论的商品不存在</li>');
		
		$data=array(
			'user_name'=>$this->session->userdata('shop_user_name'),
			'user_id'=>$this->user_id,
			'product_id'=>$product_id,
			'is_pass'=>0,
			'ip_address'=>$this->input->ip_address(),
			'content'=>$this->input->post('content',true),
			'create_date'=>time()
		);
		if($this->config->item('com_is_pass') == 2) $data['is_pass'] = 1;
		$this->db->insert('shop_comment',$data);
		echo_msg('<li>评论提交成功</li>','','yes');
	}
	
	function comment()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		$sql = 'SELECT c.*,(SELECT title FROM '.$this->db->dbprefix."shop_product WHERE id = c.product_id) AS title FROM ".$this->db->dbprefix.'shop_comment AS c WHERE c.user_id = '.$this->user_id;
		if(isset($get['is_pass'])&&$get['is_pass']!='')
		{
			$sql .= " AND c.is_pass = {$get['is_pass']}";
		}
		$sql .= ' ORDER BY c.id DESC';
		$page = array(
			'per_page' => 10,
			'page_base' => CTL_FOLDER."user/comment",
			'sql'  => $sql,
			'offset'   => $this->uri->segment($this->com_model->uri_segnum+1,0)
		);
		$query = $this->common_model->get_pages_records($page);
		$num = $this->common_model->get_records("SELECT is_pass,COUNT(*) AS num FROM ".$this->db->dbprefix.'shop_comment WHERE user_id = '.$this->user_id.' GROUP BY is_pass');
		$data = array(
			'site_title' => '我的评论--'.$this->site_title,
			'query'		=> $query['query'],
			'paginate'	=> $query['paginate'],
			'num' => $num
		);
		$this->load->view(TPL_FOLDER."comment",$data);
	}
}
?>