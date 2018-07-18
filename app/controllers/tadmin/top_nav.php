<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Top_nav extends Controller
{
	function Top_nav()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
	}
	
	function index()
	{
		$data = array(
			'top_nav' => get_cache('top_nav')
		);
		$this->load->view(TPL_FOLDER."top_nav",$data);
	}
	
	function save_top_nav()
	{
		$top_nav = $this->input->post('top_nav');
		if( ! is_array($top_nav))
		{
			$tx_msg="<li>导航不能为空.</li>";
			echo_msg($tx_msg,'','no');
		}
		$a = array();
		foreach($top_nav as $v)
		{
			$t = explode('|',$v);
			$a[] = array('title'=>filter_str($t[0]),'url'=>$t[1],'target'=>$t[2]);
		}
		if(save_cache('top_nav',$a))
		{
			$tx_msg="<li>导航修改成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>导航修改失败.</li>";
			echo_msg($tx_msg,'','no');
		}
	}
}
?>