<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Help extends Controller
{
	function Help()
	{
		parent::Controller();
		check_is_login();
	}
	function index()
	{
		
	}
	
	function echo_phpinfo()
	{
		echo phpinfo();
	}
}
?>