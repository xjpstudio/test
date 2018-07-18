<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * make html page controller note:this class not finish
 * @author		Jade Xia
 * @copyright	Copyright (c) 2010 - 2011 天夏网络.
 * @link		http://www.tianxianet.com 
 */
class Make_html extends Controller
{
	
	function Make_html()
	{
		parent::Controller();
		check_is_login();
		$this->load->database();
	}
	
	function index()
	{
		$data = array(
			'news_catalog' => $this->_parse_catalog(0)
		);
		$this->load->view(TPL_FOLDER.'make_html',$data);
	}
	
	function _parse_catalog($id)
	{
		static $ncatalog_arr=array();
		$sql = 'SELECT c.id,c.cat_name,c.deep_id,c.is_has_chd,(SELECT COUNT(*) FROM '.$this->db->dbprefix."shop_news WHERE instr(catalog_id,c.queue) > 0) AS num FROM ".$this->db->dbprefix.'shop_news_catalog AS c WHERE 1 = 1';
		$sql .= ' AND c.parent_id = '.$id;
		$sql .= ' ORDER BY c.seqorder DESC,c.id DESC';
		$catalog = $this->common_model->get_records($sql);
		foreach($catalog as $row)
		{
			$ncatalog_arr[] = $row;
			if($row->is_has_chd == 1)
			{
				$this->_parse_catalog($row->id);
			}
		}
		return $ncatalog_arr;
	}
}
?>