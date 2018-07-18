<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload extends Controller
{
	function Upload()
	{
		parent::Controller();
	}

	function index()
	{
		if( ! check_login())
		{
			diem('{"error":1,"message":"登录超时，请重新登录"}');
		}
		parse_str($_SERVER['QUERY_STRING'],$get);
		if( ! isset($get['dir']))
		{
			$this->_up_image();
		}
		else if($get['dir'] == 'image')
		{
			$this->_up_image();
		}
		else if($get['dir'] == 'flash')
		{
			$this->_up_flash();
		}
		else if($get['dir'] == 'media')
		{
			$this->_up_media();
		}
		else if($get['dir'] == 'file')
		{
			$this->_up_file();
		}
		else
		{
			$this->_up_image();
		}
	}
	
	function _up_image()
	{
		$up_img = do_upload(array('up_path'=>UP_IMAGES_PATH,'form_name'=>"imgFile",'suffix'=>UP_IMAGES_EXT));
		$js = '{';
		if( ! $up_img['status'])
		{
			$js .= '"error":1,"message":"'.str_replace(array('<li>','</li>'),array('',''),$up_img['upload_errors']).'"';
		}
		else
		{
			$js .= '"error":0,"url":"'.ROOT_PATH.$up_img['file_path'].'"';
		}
		$js .= '}';
		echo $js;
	}
	
	function _up_flash()
	{
		$up_img = do_upload(array('up_path'=>UP_FILES_PATH,'form_name'=>"imgFile",'suffix'=>'swf|flv'));
		$js = '{';
		if( ! $up_img['status'])
		{
			$js .= '"error":1,"message":"'.str_replace(array('<li>','</li>'),array('',''),$up_img['upload_errors']).'"';
		}
		else
		{
			$js .= '"error":0,"url":"'.ROOT_PATH.$up_img['file_path'].'"';
		}
		$js .= '}';
		echo $js;
	}
	
	function _up_media()
	{
		$up_img = do_upload(array('up_path'=>UP_FILES_PATH,'form_name'=>"imgFile",'suffix'=>'mp3'));
		$js = '{';
		if( ! $up_img['status'])
		{
			$js .= '"error":1,"message":"'.str_replace(array('<li>','</li>'),array('',''),$up_img['upload_errors']).'"';
		}
		else
		{
			$js .= '"error":0,"url":"'.ROOT_PATH.$up_img['file_path'].'"';
		}
		$js .= '}';
		echo $js;
	}
	
	function _up_file()
	{
		$up_img = do_upload(array('up_path'=>UP_FILES_PATH,'form_name'=>"imgFile",'suffix'=>'doc|docx|xls|xlsx|ppt|txt|zip|rar|gz|pdf|csv'));
		$js = '{';
		if( ! $up_img['status'])
		{
			$js .= '"error":1,"message":"'.str_replace(array('<li>','</li>'),array('',''),$up_img['upload_errors']).'"';
		}
		else
		{
			$js .= '"error":0,"url":"'.ROOT_PATH.$up_img['file_path'].'"';
		}
		$js .= '}';
		echo $js;
	}
	
	function file_manage()
	{
		if( ! check_login())
		{
			diem('登录超时，请重新登录');
		}
		
		parse_str($_SERVER['QUERY_STRING'],$get);
		$ext_arr = array('gif', 'jpg', 'jpeg', 'png');
		
		if(isset($get['dir']) && $get['dir']) $dir_name = $get['dir'];
		else $dir_name = ''; 
		
		if($dir_name == 'image')
		{
			$root_path = UP_IMAGES_PATH;
		}
		else if($dir_name)
		{
			$root_path = UP_FILES_PATH;
		}
		else
		{
			$root_path = UP_FILES_ROOT;
		}
		if ( ! file_exists($root_path))
		{
			@mkdir($root_path);
		}
		
		if (isset($get['path']) && $get['path'])
		{
			$current_path = $root_path . rtrim($get['path'],'/').'/';
			$current_dir_path = $get['path'];
			$moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
		} else {
			$current_path = $root_path;
			$current_dir_path = '';
			$moveup_dir_path = '';
		}
		
		//不允许使用..移动到上一级目录
		if (preg_match('/\.\./', $current_path)) {
			diem('Access is not allowed.');
		}
		//目录不存在或不是目录
		if ( ! file_exists($current_path) || ! is_dir($current_path)) {
			diem('Directory does not exist.');
		}
		
		//遍历目录取得文件信息
		$file_list = array();
		if ($handle = @opendir($current_path)) {
			$i = 0;
			while (false !== ($filename = readdir($handle))) {
				if ($filename{0} == '.') continue;
				$file = $current_path . $filename;
				if (is_dir($file)) {
					$file_list[$i]['is_dir'] = true; //是否文件夹
					$file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
					$file_list[$i]['filesize'] = 0; //文件大小
					$file_list[$i]['is_photo'] = false; //是否图片
					$file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
				} else {
					$file_list[$i]['is_dir'] = false;
					$file_list[$i]['has_file'] = false;
					$file_list[$i]['filesize'] = filesize($file);
					$file_list[$i]['dir_path'] = '';
					$file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
					$file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
					$file_list[$i]['filetype'] = $file_ext;
				}
				$file_list[$i]['filename'] = $filename; //文件名，包含扩展名
				$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
				$i++;
			}
			closedir($handle);
		}
		usort($file_list, array($this,'_cmp_func'));
		$result = array();
		//相对于根目录的上一级目录
		$result['moveup_dir_path'] = $moveup_dir_path;
		//相对于根目录的当前目录
		$result['current_dir_path'] = $current_dir_path;
		//当前目录的URL
		$result['current_url'] = '/'.$current_path;
		//文件数
		$result['total_count'] = count($file_list);
		//文件列表数组
		$result['file_list'] = $file_list;
		
		//输出JSON字符串
		header('Content-type: application/json; charset=UTF-8');
		$this->load->library('json');
		echo $this->json->encode($result);
	}
	
	function _cmp_func($a, $b)
	{
		parse_str($_SERVER['QUERY_STRING'],$get);
		
		if(isset($get['order']) && $get['order']) $order = strtolower($get['order']);
		else $order = 'name'; 
		
		if ($a['is_dir'] && !$b['is_dir']) {
			return -1;
		} else if (!$a['is_dir'] && $b['is_dir']) {
			return 1;
		} else {
			if ($order == 'size') {
				if ($a['filesize'] > $b['filesize']) {
					return 1;
				} else if ($a['filesize'] < $b['filesize']) {
					return -1;
				} else {
					return 0;
				}
			} else if ($order == 'type') {
				return strcmp($a['filetype'], $b['filetype']);
			} else {
				return strcmp($a['filename'], $b['filename']);
			}
		}
	}
}
?>