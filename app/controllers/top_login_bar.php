<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 */
class Top_login_bar extends Controller
{
	function Top_login_bar()
	{
		parent::Controller();
	}
	
	function index()
	{
		$this->load->view(TPL_FOLDER.'top_login_bar');
	}
}
?>