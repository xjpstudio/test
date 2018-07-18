<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index_block extends Controller
{
	function Index_block()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
	}
	
	function index()
	{
		$data = array(
			'index_block' => get_cache('index_block'),
			'shop_catalog' => $this->common_model->get_records('SELECT id,cat_name FROM '.$this->db->dbprefix.'shop_catalog ORDER BY seqorder DESC,id DESC')
		);
		$this->load->view(TPL_FOLDER."index_block",$data);
	}
	
	function save_index_block()
	{
		$index_block = $this->input->post('index_block');
		if( ! is_array($index_block))
		{
			$tx_msg="<li>版块不能为空.</li>";
			echo_msg($tx_msg,'','no');
		}
		
		$a = array();
		foreach($index_block as $v)
		{
			$t = explode('|',$v);
			$a[] = array('title'=>filter_str($t[0]),'q'=>filter_str($t[1]),'cid'=>$t[2],'sp'=>$t[3],'ep'=>$t[4],'sorts'=>$t[5],'num'=>$t[6],'cat'=>$t[7]);
		}
		if(save_cache('index_block',$a))
		{
			$tx_msg="<li>首页板块修改成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>首页板块修改失败.</li>";
			echo_msg($tx_msg,'','no');
		}
	}
}
?>