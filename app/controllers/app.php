<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * goods detail
 * @author		soke5
 * @copyright	Copyright (c) 2013 - 2015 搜客淘宝客.
 * @link		http://bbs.soke5.com
 *
 */
class App extends Controller
{
		
	function App()
	{
		parent::Controller();
		$this->load->database();
	}
	
	function index()
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		$num_iid = 0;
		
		$data = array(
			'site_title'		=> '商家报名--'.$this->config->item('sys_site_title'),
			'nav' => ' &gt; 商家报名'
		);
		if(isset($get['url']) && $get['url'])
		{
			$num_iid = $this->_get_taobao_id($get['url']);
		}
		
		if($num_iid > 0)
		{
			if($item = get_product($num_iid))
			{
				$data['item'] = $item;
			}
		}
		$this->load->view(TPL_FOLDER."app",$data);
	}
	
	function save_app()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("click_url","商品链接","trim|required");
		$this->form_validation->set_rules("title","商品名称","trim|required");
		$this->form_validation->set_rules("shop_price","原价","trim|required");
		$this->form_validation->set_rules("dc_price","折扣价","trim|required");
		$this->form_validation->set_rules("volume","销量","trim|integer");
		$this->form_validation->set_rules("num_iid","商品ID","trim|integer");
		$this->form_validation->set_rules("pic_path","图片地址","trim|required");
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		
		$shop_price = $this->input->post('shop_price',true);
		$num_iid = $this->input->post('num_iid',true);
		if($shop_price == 0) echo_msg('<li>原价必须填写</li>');
		
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop_product_temp WHERE num_iid = ?',array($num_iid));
		if($query) echo_msg('<li>该商品已经存在，请不要重复提交。</li>'); 
		
		$query = $this->common_model->get_record('SELECT id FROM '.$this->db->dbprefix.'shop_product WHERE num_iid = ?',array($num_iid));
		if($query) echo_msg('<li>该商品已经存在，请不要重复提交。</li>'); 
		
		$data = array(
			'num_iid' => $num_iid,
			'click_url' => $this->input->post('click_url',true),
			'title' => $this->input->post('title',true),
			'nick' => $this->input->post('nick',true),
			'volume' => $this->input->post('volume',true),
			'catalog_id' => $this->input->post('catalog_id',true),
			'shop_price' => $shop_price,
			'props_name' => '',
			'dc_price' => $this->input->post('dc_price',true),
			'pic_path'=>$this->input->post("pic_path",TRUE),
			'content' => filter_script($this->input->post('content')),
			'create_date' => time()
		);
		$this->db->insert('shop_product_temp',$data);
		echo_msg('<li>报名提交成功，请耐心等待审核。</li>',my_site_url('app'),'yes');
	}
	
	function _get_taobao_id($url)
	{
		$id_arr = array (
			'id',
			'item_num_id',
			'default_item_id',
			'item_id',
			'itemId',
			'mallstItemId'
		);
		$url = explode('?',$url);
		if(isset($url[1]))
		{
			parse_str($url[1],$a);
			foreach($a as $k => $v)
			{
				if (in_array($k, $id_arr))
				{
					return $v;
				}
			}
		}
		return 0;
	}
}
?>