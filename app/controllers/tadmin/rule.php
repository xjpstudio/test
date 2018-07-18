<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rule extends Controller
{
	function Rule()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
		$this->load->model(CTL_FOLDER."Rule_model");
		$this->load->library('form_validation');
	}
	function index()
	{
		$sql = 'SELECT * FROM '.$this->db->dbprefix.'shop_rule ORDER BY id DESC';
		$page = array(
			'per_page' => 20,
			'page_base' => CTL_FOLDER."rule/index",
			'sql'  => $sql
		);
		$query = $this->common_model->get_page_records($page);
		$data = array(
			'query'		=> $query['query'],
			'paginate'	=> $query['paginate']
		);
		$this->load->view(TPL_FOLDER."rule_list",$data);
	}
	
	function add_record()
	{
		$this->form_validation->set_rules("title","标题","trim|required");
		$this->form_validation->set_rules("f_url","列表第一页","trim|required");
		$this->form_validation->set_rules("p_url","分页","trim|required");
		$this->form_validation->set_rules("page_total","总页数","integer");
		$this->form_validation->set_rules("page_step","分页步长","integer");
		$this->form_validation->set_rules("list_block_s","列表区内容开始标记","required");
		$this->form_validation->set_rules("list_block_e","列表区内容结束标记","required");
		$this->form_validation->set_rules("list_link_s","列表项开始标记","required");
		$this->form_validation->set_rules("list_link_e","列表项结束标记","required");
		$this->form_validation->set_rules("detail_s","详细页面正文开始标记","required");
		$this->form_validation->set_rules("detail_e","详细页面正文结束标记","required");
		$this->form_validation->set_rules("charset","采集页面编码","required");
		
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		if($this->Rule_model->add_record())
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
		$this->load->view(TPL_FOLDER."rule_add");
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
		$edit_data=$this->Rule_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data,
			'url'=>$get['url']
		);
		$this->load->view(TPL_FOLDER."rule_edit",$data);
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
		$edit_data=$this->Rule_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data,
			'cat'=>$this->_parse_catalog(0)
		);
		$this->load->view(TPL_FOLDER."caiji",$data);
	}
	
	function _parse_catalog($id)
	{
		static $catalog_arr=array();
		$this->db->select('*');
		$this->db->where('parent_id',$id);
		$this->db->order_by('id','asc');
		$query=$this->db->get("shop_news_catalog");
		foreach($query->result() as $row)
		{
			$catalog_arr[]=$row;
			if($row->is_has_chd==1)
			{
				$this->_parse_catalog($row->id);
			}
		}
		return $catalog_arr;
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
		$edit_data=$this->Rule_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data,
			'url'=>$get['url']
		);
		$this->load->view(TPL_FOLDER."rule_copy",$data);
	}
	
	function save_record()
	{
		$this->form_validation->set_rules("title","标题","trim|required");
		$this->form_validation->set_rules("f_url","列表第一页","trim|required");
		$this->form_validation->set_rules("p_url","分页","trim|required");
		$this->form_validation->set_rules("page_total","总页数","integer");
		$this->form_validation->set_rules("page_step","分页步长","integer");
		$this->form_validation->set_rules("list_block_s","列表区内容开始标记","required");
		$this->form_validation->set_rules("list_block_e","列表区内容结束标记","required");
		$this->form_validation->set_rules("list_link_s","列表项开始标记","required");
		$this->form_validation->set_rules("list_link_e","列表项结束标记","required");
		$this->form_validation->set_rules("detail_s","详细页面正文开始标记","required");
		$this->form_validation->set_rules("detail_e","详细页面正文结束标记","required");
		$this->form_validation->set_rules("charset","采集页面编码","required");
		$this->form_validation->set_rules("rd_id","记录ID","trim|integer");
		
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		if($this->Rule_model->save_record())
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
		$this->form_validation->set_rules("page_step","分页步长","integer");
		$this->form_validation->set_rules("list_block_s","列表区内容开始标记","required");
		$this->form_validation->set_rules("list_block_e","列表区内容结束标记","required");
		$this->form_validation->set_rules("list_link_s","列表项开始标记","required");
		$this->form_validation->set_rules("list_link_e","列表项结束标记","required");
		$this->form_validation->set_rules("detail_s","详细页面正文开始标记","required");
		$this->form_validation->set_rules("detail_e","详细页面正文结束标记","required");
		$this->form_validation->set_rules("charset","采集页面编码","required");
		
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		if($this->Rule_model->save_copy_record())
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
		if($this->Rule_model->del_record())
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