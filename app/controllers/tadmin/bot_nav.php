<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bot_nav extends Controller
{
	function Bot_nav()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
	}
	
	function index()
	{
		$data = array(
			'bot_nav' => get_cache('bot_nav')
		);
		$this->load->view(TPL_FOLDER."bot_nav",$data);
	}
	
	function save_bot_nav()
	{
		$bot_nav = $this->input->post('bot_nav');
		if( ! is_array($bot_nav))
		{
			$tx_msg="<li>导航不能为空.</li>";
			echo_msg($tx_msg,'','no');
		}
		$a = array();
		foreach($bot_nav as $v)
		{
			$t = explode('|',$v);
			$a[] = array('title'=>filter_str($t[0]),'url'=>$t[1],'target'=>$t[2]);
		}
		if(save_cache('bot_nav',$a))
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