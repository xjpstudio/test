<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comment extends Controller
{
	function Comment()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
	}
	
	function index()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		filter_get($get);
		$sql = 'SELECT c.*,(SELECT title FROM '.$this->db->dbprefix."shop_product WHERE id = c.product_id) AS title FROM ".$this->db->dbprefix.'shop_comment AS c WHERE 1=1';
		if(isset($get['is_pass'])&&$get['is_pass']!='')
		{
			$sql .= " AND c.is_pass = {$get['is_pass']}";
		}
		if(isset($get['user_id']) && $get['user_id'] != '')
		{
			$sql .= " AND c.user_id = {$get['user_id']}";
		}
		$sql .= ' ORDER BY c.id DESC';
		$page = array(
			'per_page' => 20,
			'page_base' => CTL_FOLDER."comment/index",
			'sql'  => $sql
		);
		
		$query = $this->common_model->get_page_records($page);
		$num = $this->common_model->get_records("SELECT is_pass,COUNT(*) AS num FROM ".$this->db->dbprefix.'shop_comment GROUP BY is_pass');
		$data = array(
			'query'		=> $query['query'],
			'paginate'	=> $query['paginate'],
			'num' => $num
		);
		$this->load->view(TPL_FOLDER."comment",$data);
	}
	
	function clear()
	{
		$this->db->truncate('shop_comment');
		$tx_msg="<li>成功清除所有评论.</li>";
		echo_msg($tx_msg,my_site_url(CTL_FOLDER.'comment'),'yes');
	}

	function pass()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			echo_msg('<li>ID有误</li>');
		}
		$rd_id = implode(',',$rd_id);
		$this->db->simple_query('UPDATE '.$this->db->dbprefix.'shop_comment SET is_pass = 1 WHERE id in('.$rd_id.')');
		echo_msg('<li>操作提交成功</li>','','yes');
	}
	
	function reply_comment( $id = 0)
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		if( ! $id) 
		{
			$tx_msg="<li>ID参数有误.</li>";
			echo_msg($tx_msg);
		}
		$data=array(
			'query'=> $this->common_model->get_record('SELECT id,reply FROM '.$this->db->dbprefix.'shop_comment WHERE id = ?',array($id)),
			'url' => $get['url']
		);
		$this->load->view(TPL_FOLDER."reply_comment",$data);
	}
	
	function save_reply_comment()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id','评论ID','is_natural_no_zero');
		if($this->form_validation->run()==FALSE) echo_msg($this->form_validation->error_string());
		$data = array(
			'reply' => $this->input->post('reply',TRUE)
		);
		$this->db->update('shop_comment',$data,array('id'=>$this->input->post('id',true)));
		echo_msg('<li>回复提交成功</li>',$this->input->post('url'),'yes');
	}

	function del_comment()
	{
		$rd_id=$this->input->post("rd_id");
		if(!is_array($rd_id))
		{
			echo_msg('<li>ID有误</li>');
		}
		$this->db->where_in("id",$rd_id);
		$this->db->delete("shop_comment");
		echo_msg('<li>记录删除成功</li>','','yes');
	}
}
?>