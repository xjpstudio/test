<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_catalog extends Controller
{
	function News_catalog()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
		$this->load->model("tadmin/News_catalog_model");
		$this->load->library('form_validation');
	}
	
	function index()
	{
		$data=array(
			'catalog_list'=>$this->News_catalog_model->get_records()
		);
		$this->load->view(TPL_FOLDER."news_catalog_list",$data);
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
		if($this->News_catalog_model->add_record())
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
	
	function sort_record()
	{
		$this->form_validation->set_rules("rd_id","排序项","required");
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg=validation_errors();
			echo_msg($tx_msg);
		}

		if($this->News_catalog_model->sort_record())
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
	
	function edit_record()
	{
		$rd_id=$this->uri->segment(4,0);
		if(!$rd_id) 
		{
			$tx_msg="<li>ID参数有误.</li>";
			echo_msg($tx_msg);
		}
		$edit_data=$this->News_catalog_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data,
			'catalog_list'=>$this->News_catalog_model->get_records()
		);
		$this->load->view(TPL_FOLDER."news_catalog_edit",$data);
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
		if($this->News_catalog_model->save_record())
		{
			$this->_write_cache();
			$tx_msg="<li>记录修改成功.</li>";
			echo_msg($tx_msg,site_url(CTL_FOLDER."news_catalog"),'yes');
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
		if($this->News_catalog_model->del_record())
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
		save_cache('ncatalog',$this->_parse_ncatalog(0));
		unset($query);
	}
	
	function _parse_ncatalog($id)
	{
		static $m_arr=array();
		$this->db->where('parent_id',$id);
		$this->db->order_by('seqorder','desc');
		$this->db->order_by('id','desc');
		$query=$this->db->get("shop_news_catalog");
		foreach($query->result() as $row)
		{
			$m_arr[]=$row;
			if($row->is_has_chd==1)
			{
				$this->_parse_ncatalog($row->id);
			}
		}
		return $m_arr;
	}
}
?>