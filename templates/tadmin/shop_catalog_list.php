<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."shop");?>">店铺列表</a> &gt; 分类管理</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:solid 1px #3C4952; margin-bottom:5px; margin-top:5px">
  <tr>
    <td width="327" height="24" align="right" ><span style="cursor:pointer" onClick="RqData()"><img src="{tpl_path}images/add.png">添加分类</span></td>
    <td width="416" align="right"  style="padding-right:10px"><a href="<?php echo my_site_url(CTL_FOLDER.'shop_catalog/re_cache');?>"><img src="{tpl_path}images/refresh.jpg"  /> 更新缓存</a> | <a href="<?php echo site_url(CTL_FOLDER."shop");?>"><img src="{tpl_path}images/default_icon.gif" border="0"> 管理店铺</a></td>
  </tr>
</table>
<form method="post" name="list_form" id="list_form">
  <table width="100%" cellspacing="0" class="widefat">
    <thead>
      <tr id="trth">
        <th width="3%" ><input type="checkbox" onclick="check_box(this.form.rd_id)" /></th>
        <th width="70%" id="cat_name">标题</th>
        <th width="19%">排序</th>
        <th width="8%">操作</th>
      </tr>
    </thead>
    <tbody id="check_box_id">
      <?php foreach($catalog_list as $row) {?>
      <tr>
        <td class="rdId"><input name="rd_id[]" type="checkbox" id="rd_id" value="<?php echo $row->id;?>"></td>
        <td><?php echo $row->cat_name;?></td>
        <td><input name="sort<?php echo $row->id;?>" value="<?php echo $row->seqorder;?>" type="text" size="2" maxlength="10" dataType="Integer" msg="排序号必须为数字"></td>
        <td><a href="<?php echo site_url(CTL_FOLDER."shop_catalog/edit_record/".$row->id);?>">修改</a></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="padding-top:5px"><input type="checkbox" onclick="check_box(this.form.rd_id)" />
        全选 <select name="action_url" id="action_url">
          <option value="" style="color:#FF0000">-选择操作-</option>
          <option value="<?php echo site_url(CTL_FOLDER."shop_catalog/del_record");?>">删除</option>
          <option value="<?php echo site_url(CTL_FOLDER."shop_catalog/sort_record");?>">排序</option>
        </select>
        &nbsp;
        <input type="button" name="submit_list_button" class="button-style2" onclick="submit_list_form(this.form,this)" id="submit_list_button" value="执行操作" /></td>
    </tr>
  </table>
</form>
<div id="dialog_add" style="display:none; position:relative">
  <form action="<?php echo site_url(CTL_FOLDER."shop_catalog/add_record");?>" method="post" name="dialog_add_form" id="dialog_add_form">
    <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
      <tr>
        <td width="164"><font color="#FF0000">*</font>分类标题：</td>
        <td width="551"><input Name="cat_name" type="text" size="30" dataType="Require" msg="该项必须填写" maxlength="50" /></td>
      </tr>
      <tr>
        <td><font color="#FF0000">*</font>分类排序：</td>
        <td><input name="seqorder" type="text" id="seqorder" size="4" value="0" datatype="Integer" msg="该项必须填写数字" maxlength="10" /></td>
      </tr>
    </table>
  </form>
</div>
<script language="javascript">
$(function(){
	$("div.celltext").edit_table({
		param:{'table':'shop_catalog'}
	});
});
function RqData(){
	$('#dialog_add').dialog({  
		hide:'',      
		autoOpen:false,
		width:750,
		height:300,  
		modal:true, //蒙层  
		title:'添加分类', 
		close: function(){ 
			document.getElementById("dialog_add_form").reset();
			//$(this).dialog('destroy');
		},  
		overlay: {  
			opacity: 0.5, 
			background: "black"
		},  
		buttons:{  
			'取消':function(){$(this).dialog("close");},
			'添加分类':function(){dialog_add();}  
		}
	});
	$('#dialog_add').dialog('open');
}	

function dialog_add()
{
	var form_ob=document.getElementById("dialog_add_form"); 
	if (!Validator.Validate(form_ob,3)) return false;
	$("#dialog_add_form")[0].submit();
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
