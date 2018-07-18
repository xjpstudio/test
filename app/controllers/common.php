<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common extends Controller
{
	function Common()
	{
		parent::Controller();
	}
	
	function get_validate_code(){
		$data = array(
			'mCheckCodeNum'     =>  4, //验证码位数
			'mCheckImageWidth'  =>  75, //图片宽度
			'mCheckImageHeight' =>  20  //图片高度
		);
        $this->load->library('validate_code',$data);
		$this->validate_code->OutCheckImage();
   	}
	
	function ajax_save()
	{
		if( ! $this->session->userdata("shop_sys_user_name")) diem('0');
		$field_value = filter_str($this->input->post('field_value'));
		$form_value = filter_str(unescape($this->input->post('form_value')));
		$tb = $this->input->post('table');
		$id = $this->input->post('rd_id');
		if( ! $field_value || ! $form_value || ! $tb || ! $id) diem('0');
		$data=array(
			$field_value => $form_value
		);
		$this->load->database();
		$this->db->update($tb,$data,array('id'=>$id));
		diem('1');
	}
}
?>