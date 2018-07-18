<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| price_range config
| -------------------------------------------------------------------
*/
$config['price_range'] = array(
	array('id' => 1,'s'=>1 ,'e'=>50,'t'=>'1-50元'),
	array('id' => 2,'s'=>50 ,'e'=>100,'t'=>'50-100元'),
	array('id' => 3,'s'=>100 ,'e'=>200,'t'=>'100-200元'),
	array('id' => 4,'s'=>200 ,'e'=>500,'t'=>'200-500元'),
	array('id' => 5,'s'=>500 ,'e'=>1000,'t'=>'500-1000元'),
	array('id' => 6,'s'=>1000 ,'e'=>3000,'t'=>'1000-3000元'),
	array('id' => 7,'s'=>3000 ,'e'=>5000,'t'=>'3000-5000元'),
	array('id' => 8,'s'=>5000 ,'e'=>10000,'t'=>'5000-1万元'),
	array('id' => 9,'s'=>10000 ,'e'=>99999999,'t'=>'1万元以上')
);
?>
