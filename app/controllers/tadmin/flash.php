<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Flash extends Controller
{
	function Flash()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
		$this->load->model("tadmin/Flash_model");
		$this->load->library('form_validation');
	}
	function index()
	{
		$data = array(
			'query'	=> $this->common_model->get_records('SELECT * FROM '.$this->db->dbprefix."shop_flash ORDER BY seqorder DESC,id DESC")
		);
		$this->load->view(TPL_FOLDER."flash_list",$data);
	}
	
	function sort_record()
	{
		$this->form_validation->set_rules("rd_id","排序项","required");
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg=validation_errors();
			echo_msg($tx_msg);
		}

		if($this->Flash_model->sort_record())
		{
			$this->_write_cache();
			$tx_msg="<li>记录排序成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>记录排序失败.</li>";
			echo_msg($tx_msg);
		}
	}
	
	function add_record()
	{
		$this->form_validation->set_rules("title","标题","trim|required");
		$tx_msg="";
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg.=validation_errors();
		}
		$up_img=do_upload(array('up_path'=>UP_IMAGES_PATH,'form_name'=>"pic",'suffix'=>UP_IMAGES_EXT));
		if(!$up_img['status'])
		{
			$tx_msg.=$up_img['upload_errors'];
		}
		if($tx_msg!="")
		{
			echo_msg($tx_msg);
		}
		if($this->Flash_model->add_record($up_img))
		{
			$this->_write_cache();
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
		parse_str($_SERVER['QUERY_STRING'],$get);
		if(!$rd_id) 
		{
			$tx_msg="<li>ID参数有误.</li>";
			echo_msg($tx_msg);
		}
		$edit_data=$this->Flash_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data
		);
		$this->load->view(TPL_FOLDER."flash_edit",$data);
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
		$up_img=do_upload(array('up_path'=>UP_IMAGES_PATH,'form_name'=>"pic",'suffix'=>UP_IMAGES_EXT));
		if(!$up_img['status'])
		{
			$tx_msg.=$up_img['upload_errors'];
		}
		if($tx_msg!="")
		{
			echo_msg($tx_msg);
		}
		if($this->Flash_model->save_record($up_img))
		{
			$this->_write_cache();
			$tx_msg="<li>记录修改成功.</li>";
			echo_msg($tx_msg,site_url(CTL_FOLDER.'flash'),'yes');
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
		if($this->Flash_model->del_record())
		{
			$this->_write_cache();
			$tx_msg="<li>记录删除成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>记录删除失败.</li>";
			echo_msg($tx_msg);
		}
	}
	
	function re_cache()
	{
		$this->_write_cache();
		echo_msg('<li>缓存生成成功.</li>','','yes');
	}
	
	function _write_cache()
	{
		$query = $this->common_model->get_records('SELECT title,hplink,pic_path FROM '.$this->db->dbprefix.'shop_flash ORDER BY seqorder DESC,id DESC');
		save_cache('focus',$query);
		unset($query);
	}
}
?>