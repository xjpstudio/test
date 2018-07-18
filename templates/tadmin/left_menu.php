<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理菜单</title>
<link rel="stylesheet" href="{root_path}js/jquery/jquery-tree/jquery.treeview.css" />
<script type="text/javascript" src="{root_path}js/jquery/jquery.js"></script>
<script src="{root_path}js/jquery/jquery-tree/jquery.treeview.js" type="text/javascript"></script>
<script language="javascript">
	$(document).ready(function(){
		$("#browser").treeview({
			collapsed: false
		});
	});
</script>
<link rel="stylesheet" href="{tpl_path}style/style.css">
<style type="text/css">
body {
	margin:0px;
}
</style>
</head>

<body>
<ul id="browser" class="filetree">
  <?php foreach($query1->result() as $row1)
		{
			if($row1->is_trash==0)
			{
		?>
  <li><span class="folder"><?php echo $row1->cat_name;?></span>
    <ul>
      <?php foreach($query2->result() as $row2)
		{
			if($row2->parent_id==$row1->id)
			{
			if($row2->is_trash==0)
			{
		?>
      <li><span class="file"><a href="<?php echo ($row2->hplink=="#")?"javascript:void(0)":site_url(CTL_FOLDER.$row2->hplink);?>" target="main"><?php echo $row2->cat_name;?></a></span></li>
      <?php
	   		} 
			}
	   }
	   		
	   ?>
    </ul>
  </li>
  <?php 
		}
	}?>
</ul>
</body>
</html>
