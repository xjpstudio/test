<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hot_keyword extends Controller
{
	function Hot_keyword()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
	}
	function index()
	{
		$data = array(
			'hot_keyword' => get_cache('hot_keyword')
		);
		$this->load->view(TPL_FOLDER."hot_keyword",$data);
	}
	
	function save_hot_keyword()
	{
		$hot_keyword = $this->input->post('hot_keyword');
		if( ! is_array($hot_keyword))
		{
			$tx_msg="<li>关键词不能为空.</li>";
			echo_msg($tx_msg,'','no');
		}
		
		$a = array();
		foreach($hot_keyword as $v)
		{
			$t = explode('|',$v);
			$a[] = array('title'=>filter_str($t[0]),'cid'=>$t[1],'q'=>$t[2]);
		}
		if(save_cache('hot_keyword',$a))
		{
			$tx_msg="<li>关键词修改成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>关键词修改失败.</li>";
			echo_msg($tx_msg,'','no');
		}
	}
}
?>