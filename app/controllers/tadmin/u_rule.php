<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class U_rule extends Controller
{
	function U_rule()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
		$this->load->model(CTL_FOLDER."U_rule_model");
		$this->load->library('form_validation');
	}
	
	function index()
	{
		$sql = 'SELECT * FROM '.$this->db->dbprefix.'shop_u_rule ORDER BY id DESC';
		$page = array(
			'per_page' => 30,
			'page_base' => CTL_FOLDER."u_rule/index",
			'sql'  => $sql
		);
		$query = $this->common_model->get_page_records($page);
		$data = array(
			'query'		=> $query['query'],
			'paginate'	=> $query['paginate']
		);
		$this->load->view(TPL_FOLDER."u_rule_list",$data);
	}
	
	function add_record()
	{
		$this->form_validation->set_rules("title","标题","trim|required");
		$this->form_validation->set_rules("f_url","列表第一页","trim|required");
		$this->form_validation->set_rules("p_url","分页","trim|required");
		$this->form_validation->set_rules("page_total","总页数","integer");
		
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		if($this->U_rule_model->add_record())
		{
			$tx_msg="<li>记录添加成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>记录添加失败.</li>";
			echo_msg($tx_msg);
		}
	}
	
	function add_record_view()
	{
		$this->load->view(TPL_FOLDER."u_rule_add");
	}
	
	function edit_record()
	{
		$rd_id=$this->uri->segment(4,0);
		parse_str($_SERVER['QUERY_STRING'],$get);
		if(!$rd_id) 
		{
			$tx_msg="<li>ID参数有误.</li>";
			echo_msg($tx_msg);
		}
		$edit_data=$this->U_rule_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data,
			'url'=>$get['url']
		);
		$this->load->view(TPL_FOLDER."u_rule_edit",$data);
	}
	
	function caiji()
	{
		$rd_id=$this->uri->segment(4,0);
		parse_str($_SERVER['QUERY_STRING'],$get);
		if(!$rd_id) 
		{
			$tx_msg="<li>ID参数有误.</li>";
			echo_msg($tx_msg);
		}
		$edit_data=$this->U_rule_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data,
			'cat'=>$this->_parse_catalog(0)
		);
		$this->load->view(TPL_FOLDER."u_caiji",$data);
	}
	
	function _parse_catalog($id)
	{
		static $pcatalog_arr=array();
		$sql = 'SELECT * FROM '.$this->db->dbprefix.'shop_product_catalog';
		$sql .= ' WHERE parent_id = '.$id;
		$sql .= ' ORDER BY seqorder DESC,id DESC';
		$catalog = $this->common_model->get_records($sql);
		foreach($catalog as $row)
		{
			$pcatalog_arr[]=$row;
			if($row->is_has_chd==1)
			{
				$this->_parse_catalog($row->id);
			}
		}
		return $pcatalog_arr;
	}
	
	function edit_copy_record()
	{
		$rd_id=$this->uri->segment(4,0);
		parse_str($_SERVER['QUERY_STRING'],$get);
		if(!$rd_id) 
		{
			$tx_msg="<li>ID参数有误.</li>";
			echo_msg($tx_msg);
		}
		$edit_data=$this->U_rule_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data,
			'url'=>$get['url']
		);
		$this->load->view(TPL_FOLDER."u_rule_copy",$data);
	}
	
	function save_record()
	{
		$this->form_validation->set_rules("title","标题","trim|required");
		$this->form_validation->set_rules("f_url","列表第一页","trim|required");
		$this->form_validation->set_rules("p_url","分页","trim|required");
		$this->form_validation->set_rules("page_total","总页数","integer");
		$this->form_validation->set_rules("rd_id","记录ID","trim|integer");
		
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		if($this->U_rule_model->save_record())
		{
			$tx_msg="<li>记录修改成功.</li>";
			echo_msg($tx_msg,$this->input->post('url'),'yes');
		}
		else
		{
			$tx_msg="<li>记录修改失败.</li>";
			echo_msg($tx_msg);
		}
	}
	
	function save_copy_record()
	{
		$this->form_validation->set_rules("title","标题","trim|required");
		$this->form_validation->set_rules("f_url","列表第一页","trim|required");
		$this->form_validation->set_rules("p_url","分页","trim|required");
		$this->form_validation->set_rules("page_total","总页数","integer");
		
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		if($this->U_rule_model->save_copy_record())
		{
			$tx_msg="<li>记录添加成功.</li>";
			echo_msg($tx_msg,$this->input->post('url'),'yes');
		}
		else
		{
			$tx_msg="<li>记录添加失败.</li>";
			echo_msg($tx_msg);
		}
	}
	
	function del_record()
	{
		$this->form_validation->set_rules("rd_id","删除的记录","required");
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg=validation_errors();
			echo_msg($tx_msg);
		}
		if($this->U_rule_model->del_record())
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