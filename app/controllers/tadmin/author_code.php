<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Author_code extends Controller
{
	function Author_code()
	{
		parent::Controller();
		check_is_login();
	}
	
	function index()
	{
		$data = array(
			'author_code' => author_code('')
		);
		$this->load->view(TPL_FOLDER."author_code",$data);
	}
	
	function save_author_code()
	{
		$author_code = $this->input->post('author_code');
		if( ! $author_code) echo_msg('<li>请填写授权码，然后再提交.</li>');
		if(author_code($author_code))
		{
			$tx_msg="<li>授权码修改成功.</li>";
			echo_msg($tx_msg,'','yes');
		}
		else
		{
			$tx_msg="<li>授权码修改失败.</li>";
			echo_msg($tx_msg,'','no');
		}
	}
}
?>