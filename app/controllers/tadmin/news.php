<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class News extends Controller
{
	function News()
	{
		parent::Controller();
		check_is_login();
		$this->load->model("tadmin/News_model");
		$this->load->library('form_validation');
		$this->load->database();
	}

	function index()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		$sql = '';
		if(isset($get['s_catalog_id'])&&$get['s_catalog_id']!='')
		{
			$sql .= " AND n.catalog_id like '%,".$get['s_catalog_id'].",%'";
		}
		if(isset($get['s_keyword'])&&$get['s_keyword']!='')
		{
			$sql .= " AND n.title like '%".$get['s_keyword']."%'";
		}
		
		$sqlt = 'SELECT COUNT(*) AS num FROM '.$this->db->dbprefix.'shop_news AS n WHERE 1=1'.$sql;
		$query = $this->common_model->get_record($sqlt);
		$total = $query->num;
		unset($query);
		
		$sql .= ' ORDER BY n.seqorder DESC,n.id DESC';
		$sql = 'SELECT n.id,n.pic_path,n.title,n.create_date,n.seqorder,n.hits,n.is_create,(SELECT cat_name FROM '.$this->db->dbprefix.'shop_news_catalog WHERE queue = n.catalog_id) AS cat_name FROM '.$this->db->dbprefix.'shop_news AS n WHERE 1 = 1'.$sql;
		$page = array(
			'per_page' => 20,
			'page_base' => CTL_FOLDER."news/index",
			'sql'  => $sql,
			'total_rows' => $total
		);
		$query = $this->common_model->get_page_records($page);
		$data = array(
			'query'		=> $query['query'],
			'paginate'	=> $query['paginate'],
			'catalog_list'	=> $this->News_model->get_catalog_records()
		);
		$this->load->view(TPL_FOLDER."news_list",$data);
	}
	
	function add_record_view()
	{
		$data = array(
			'catalog_list'	=> $this->News_model->get_catalog_records()
		);
		$this->load->view(TPL_FOLDER."news_add",$data);
	}
	
	function sort_record()
	{
		$this->form_validation->set_rules("rd_id","排序项","required");
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg=validation_errors();
			echo_msg($tx_msg);
		}

		if($this->News_model->sort_record())
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
		
		if($this->News_model->add_record($up_img))
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
		parse_str($_SERVER['QUERY_STRING'],$get);
		if(!$rd_id) 
		{
			$tx_msg="<li>ID参数有误.</li>";
			echo_msg($tx_msg);
		}
		$edit_data=$this->News_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data,
			'url'=>$get['url'],
			'catalog_list'=>$this->News_model->get_catalog_records()
		);
		$this->load->view(TPL_FOLDER."news_edit",$data);
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
		$edit_data=$this->News_model->get_record($rd_id);
		$data=array(
			'edit_data'=>$edit_data,
			'url'=>$get['url'],
			'catalog_list'=>$this->News_model->get_catalog_records()
		);
		$this->load->view(TPL_FOLDER."news_copy",$data);
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
		
		if($this->News_model->save_record($up_img))
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
		if($this->News_model->save_copy_record($up_img))
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
		if($this->News_model->del_record())
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
	
	function to_catalog()
	{
		$this->form_validation->set_rules("rd_id","移动的项","required");
		if($this->form_validation->run()==FALSE)
		{
			$tx_msg=validation_errors();
			echo_msg($tx_msg);
		}
		if($this->News_model->to_catalog())
		{
			
			$tx_msg="<li>记录转移到分类成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>记录转移到分类失败.</li>";
			echo_msg($tx_msg);
		}
	}
}
?>