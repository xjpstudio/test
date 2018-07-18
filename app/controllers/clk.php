<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * goods detail
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 *
 */
class Clk extends Controller
{
		
	function Clk()
	{
		parent::Controller();
		$this->load->database();
	}
	
	function index()
	{
		$rd_id=$this->uri->segment(2,0);
		$query = $this->common_model->get_record('SELECT num_iid,click_url FROM '.$this->db->dbprefix.'shop_product WHERE id = ?',array($rd_id));
		if ( ! $query) redirect(base_url());
		$data = array('query'=>$query);
		$this->load->config('pid_config');
		$this->load->view(TPL_FOLDER.'clk',$data);
	}
}
?>