<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ads extends Controller
{
	function Ads()
	{
		parent::Controller();
		check_is_login();
		$this->load->model("tadmin/Ads_model");
		$this->load->library('form_validation');
		$this->load->database();
	}
	function index()
	{
		$data = array(
			'query'	=> $this->Ads_model->get_records()
		);
		$this->load->view(TPL_FOLDER."ads_list",$data);
	}
	
	function add_record()
	{
		$this->form_validation->set_rules("title","标题","trim|required");
		$tx_msg="";
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg.=validation_errors();
		}
		$up_img=do_upload(array('up_path'=>UP_IMAGES_PATH,'form_name'=>"pic",'suffix'=>"swf|flv|jpg|gif|png"));
		if(!$up_img['status'])
		{
			$tx_msg.=$up_img['upload_errors'];
		}
		if($tx_msg!="")
		{
			echo_msg($tx_msg);
		}
		if($this->Ads_model->add_record($up_img))
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
	
	function edit_record()
	{
		$rd_id=$this->uri->segment(4,0);
		if(!$rd_id) 
		{
			$tx_msg="<li>ID参数有误.</li>";
			echo_msg($tx_msg);
		}
		$edit_data=$this->Ads_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data
		);
		$this->load->view(TPL_FOLDER."ads_edit",$data);
	}
	
	function save_record()
	{
		$this->form_validation->set_rules("title","标题","trim|required");
		$this->form_validation->set_rules("rd_id","记录ID","trim|integer");
		$tx_msg="";
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg.=validation_errors();
		}
		$up_img=do_upload(array('up_path'=>UP_IMAGES_PATH,'form_name'=>"pic",'suffix'=>"swf|flv|jpg|gif|png"));
		if(!$up_img['status'])
		{
			$tx_msg.=$up_img['upload_errors'];
		}
		if($tx_msg!="")
		{
			echo_msg($tx_msg);
		}
		if($this->Ads_model->save_record($up_img))
		{
			$tx_msg="<li>记录修改成功.</li>";
			echo_msg($tx_msg,site_url(CTL_FOLDER."ads"),'yes');
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
		if($this->Ads_model->del_record())
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