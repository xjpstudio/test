<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends Controller
{
	function User()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->model(CTL_FOLDER."User_model");
	}
	
	function index()
	{
		$offset = $this->uri->segment(4, 0);
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		$sql = 'SELECT u.*,(SELECT COUNT(*) FROM '.$this->db->dbprefix.'shop_comment WHERE user_id = u.id) AS com_num FROM '.$this->db->dbprefix.'shop_user AS u WHERE 1=1';
		if(isset($get['s_date'])&&$get['s_date']!='')
		{
			$sql .= " AND u.create_date >= ".strtotime($get['s_date']);
		}
		if(isset($get['e_date'])&&$get['e_date']!='')
		{
			$sql .= " AND u.create_date <= ".strtotime($get['e_date']);
		}
		if(isset($get['s_keyword'])&&$get['s_keyword']!='')
		{
			$sql .= " AND u.user_name like '%{$get['s_keyword']}%'";
		}
		$sql .= ' ORDER BY u.id DESC';
		$page=array(
			'page_base' => CTL_FOLDER.'user/index',
			'offset'   => $offset,
			'per_page' => 20,
			'sql' => $sql
		);
		$query = $this->common_model->get_page_records($page);
		$data = array(
			'query'		=> $query['query'],
			'paginate'	=> $query['paginate']
		);
		$this->load->view(TPL_FOLDER."user_list",$data);
	}
	
	function get_record()
	{
		$rd_id=$this->input->post("rd_id");
		if(!$rd_id) 
		{
			diem("ID参数有误");
		}
		$edit_data=$this->User_model->get_record($rd_id);
		$data=array(
			'edit_data' => $edit_data
		);
		$this->load->view(TPL_FOLDER."user_view",$data);
	}
	
	function save_record()
	{
		$this->form_validation->set_rules("rd_id","记录ID","trim|integer");
		$tx_msg="";
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg.=$this->form_validation->error_string();
			echo_msg($tx_msg);
		}
		$data = array(
			'wangwang' => $this->input->post('wangwang'),
			'qq' => $this->input->post('qq'),
			'email' => $this->input->post('email')
		);
		if($this->input->post('password')) $data['password'] = md5($this->input->post('password'));
		$this->db->update('shop_user',$data,array('id'=>$this->input->post('rd_id')));
		$tx_msg="<li>记录修改成功.</li>";
		echo_msg($tx_msg,'','yes');
	}
	
	function del_record()
	{
		$this->form_validation->set_rules("rd_id","删除的记录","required");
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg=$this->form_validation->error_string();
			echo_msg($tx_msg);
		}
		if($this->User_model->del_record())
		{
			$tx_msg="<li>记录删除成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>记录删除失败.</li>";
			echo_msg($tx_msg);
		}
	}
}
?>