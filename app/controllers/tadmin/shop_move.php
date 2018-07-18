<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shop_move extends Controller
{
	function Shop_move()
	{
		parent::Controller();
		check_is_login();
	}
	function index()
	{
		$this->load->config('shop_config');
		$data = array(
			'shop_config' => $this->config->item('shop_config')
		);
		$this->load->view(TPL_FOLDER."shop_config",$data);
	}
	function save_shop()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("shop_url","淘宝店铺地址","trim|require");
		$this->form_validation->set_rules("nick","店铺掌柜账号","trim|require");
		$this->form_validation->set_rules("discount","折扣百分数","trim|require");
		if($this->form_validation->run()==FALSE) echo_msg(validation_errors());
		$is_w = $this->input->post('is_w')?1:2;
		$this->load->helper('file');
		$this->load->helper('string');
		$string=read_file(APPPATH.'config/shop_config'.EXT);
		$reg = '/\$config\[\'shop_config\'\][^\r\n]+;/is';
		preg_match_all( $reg ,$string , $out  );
		if(isset($out[0][0]))
		{
			$str = '$config[\'shop_config\'] = array(';
			$str .= "'shop_url'=>'".strip_quotes($this->input->post('shop_url'))."','nick'=>'".strip_quotes($this->input->post('nick'))."','is_w'=>'".$is_w."','discount'=>'".strip_quotes($this->input->post('discount'))."'";
			$str .= ');';
			$string = str_replace($out[0][0],$str,$string);
		}
		write_file(APPPATH.'config/shop_config'.EXT, $string);
		unset($out);
		redirect(CTL_FOLDER.'shop_move/scaiji');
	}
	function scaiji()
	{
		$this->load->config('shop_config');
		$shop_config = $this->config->item('shop_config');
		$total_page = 0;
		if($shop_config['shop_url']) $total_page = get_total_page($shop_config['shop_url']);
		$this->load->library('TopClient','','top');
		$this->load->library('top/SellercatsListGetRequest','','req');
		$this->req->setFields("cid");
		$this->req->setNick($shop_config['nick']);
		$resp = $this->top->execute($this->req);
		if($resp && isset($resp['seller_cats']['seller_cat'])) $ctotal = count($resp['seller_cats']['seller_cat']);
		else $ctotal = 0;
		$data = array(
			'total_page' => $total_page,
			'ctotal' => $ctotal,
			'shop_config' => $shop_config
		);
		$this->load->view(TPL_FOLDER.'scaiji',$data);
	}
}
?>
