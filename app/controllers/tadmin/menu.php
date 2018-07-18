<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends Controller
{
	
	function Menu()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
		$this->load->model("tadmin/menu_model");
		$this->load->library('form_validation');
	}
	function index()
	{
		$data=array(
			'catalog_list'=>$this->menu_model->get_records()
		);
		$this->load->view(TPL_FOLDER."menu_list",$data);
	}
	
	function add_record()
	{
		$this->form_validation->set_rules("cat_name","分类名称","trim|required");
		$tx_msg="";
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg.=validation_errors();
		}
		
		if($tx_msg!="")
		{
			echo_msg($tx_msg);
		}
		if($this->menu_model->add_record())
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
	
	function sort_record()
	{
		$this->form_validation->set_rules("rd_id","排序项","required");
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg=validation_errors();
			echo_msg($tx_msg);
		}

		if($this->menu_model->sort_record())
		{
			$tx_msg="<li>记录排序成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>记录排序失败.</li>";
			echo_msg($tx_msg);
		}
	}
	
	function edit_record()
	{
		$rd_id=$this->uri->segment(4,0);
		if(!$rd_id) 
		{
			$tx_msg="<li>ID参数有误.</li>";
			echo_msg($tx_msg);
		}
		$edit_data=$this->menu_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data,
			'catalog_list'=>$this->menu_model->get_records()
		);
		$this->load->view(TPL_FOLDER."menu_edit",$data);
	}
	
	function save_record()
	{
		$this->form_validation->set_rules("cat_name","分类名称","trim|required");
		$this->form_validation->set_rules("rd_id","记录ID","trim|integer");
		$tx_msg="";
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg.=validation_errors();
		}
		
		if($tx_msg!="")
		{
			echo_msg($tx_msg);
		}
		if($this->menu_model->save_record())
		{
			$tx_msg="<li>记录修改成功.</li>";
			echo_msg($tx_msg,site_url(CTL_FOLDER."/menu"),'yes');
		}
		else
		{
			$tx_msg="<li>记录修改失败.</li>";
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
		if($this->menu_model->del_record())
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
	
	function ajax_toggle()
	{
		$this->form_validation->set_rules("rd_id","0","trim|required");
		if($this->form_validation->run()==FALSE)
		{
			diem("0");
		}
		if($this->menu_model->ajax_toggle())
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
	}

}
?>