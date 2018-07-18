<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."menu");?>">管理菜单列表</a></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:solid 1px #3C4952; margin-bottom:5px; margin-top:5px">
  <tr>
    <td height="24" align="center" ><span style="cursor:pointer" onClick="RqData()"><img src="{tpl_path}images/add.png">添加菜单</span></td>
  </tr>
</table>
<form method="post" name="list_form" id="list_form">
  <table width="34%" cellspacing="0" class="widefat">
    <thead>
      <tr id="trth">
        <th width="9%" ><input type="checkbox" onclick="check_box(this.form.rd_id)" /></th>
        <th width="33%" id="cat_name">标题</th>
        <th width="22%" id="hplink">菜单链接</th>
        <th width="16%">状态</th>
        <th width="12%">排序</th>
        <th width="8%">操作</th>
      </tr>
    </thead>
    <tbody  id="check_box_id">
      <?php foreach($catalog_list as $row) {?>
      <tr>
        <td class="rdId"><input name="rd_id[]" type="checkbox" id="rd_id" value="<?php echo $row->id;?>"></td>
        <td><?php
		if($row->parent_id==0)
		{
			echo "<div class='celltext'>{$row->cat_name}</div>";
		}
		else
		{
			echo "&nbsp;&nbsp;|-<div class='celltext'>{$row->cat_name}</div>";
		}
        ?></td>
        <td><div class='celltext'><?php echo $row->hplink;?></div></td>
        <td>
         <?php 
		if($row->is_trash)
		{
		?>
        <img src="{tpl_path}images/no.gif" onclick="ajax_toggle(this,<?php echo $row->id;?>,'<?php echo site_url(CTL_FOLDER."menu/ajax_toggle");?>')" style="cursor:pointer" />
        <?php
		}
		else
		{
		?>
        <img src="{tpl_path}images/yes.gif" onclick="ajax_toggle(this,<?php echo $row->id;?>,'<?php echo site_url(CTL_FOLDER."menu/ajax_toggle");?>')" style="cursor:pointer" />
        <?php
		}
		?>        </td>
        <td><input name="sort<?php echo $row->id;?>" value="<?php echo $row->seqorder;?>" type="text"  id="sort<?php echo $row->id;?>" size="2" maxlength="10" dataType="Integer" msg="排序号必须为数字" title="数字越大越靠前"></td>
        <td><a href="<?php echo site_url(CTL_FOLDER."menu/edit_record/".$row->id);?>">修改</a></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="padding-top:5px"><select name="action_url" id="action_url">
          <option value="" style="color:#FF0000">-选择操作-</option>
          <option value="<?php echo site_url(CTL_FOLDER."menu/del_record");?>">删除</option>
          <option value="<?php echo site_url(CTL_FOLDER."menu/sort_record");?>">排序</option>
        </select>
        &nbsp;
        <input type="button" name="submit_list_button" class="button-style2" onclick="submit_list_form(this.form,this)" id="submit_list_button" value="执行操作" />  <img src="{tpl_path}images/notice.gif"  title="操作步骤：在左边勾选要操作的记录-->选择需要执行的操作-->点击“执行操作”按钮-->完成" />
      </td>
    </tr>
  </table>
</form>
<div id="dialog_add" style="display:none; position:relative">
  <form action="<?php echo site_url(CTL_FOLDER."menu/add_record");?>" method="post" name="dialog_add_form" id="dialog_add_form">
    <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
      <tr>
        <td width="17%"><font color="#FF0000">*</font>所属菜单：</td>
        <td width="83%"><select name="parent_id" id="parent_id">
        <option value="0">根目录</option>
            <?php foreach($catalog_list as $row) {
				if($row->parent_id==0)
				{
			?>
            <option value="<?php echo $row->id;?>"><?php echo $row->cat_name;?></option>
            <?php 
				}
			}
			?>
          </select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="1" name="is_trash" title="该项对超级管理员无效" /> 隐藏菜单</td>
      </tr>
      <tr>
        <td width="17%"><font color="#FF0000">*</font>菜单标题：</td>
        <td width="83%"><input Name="cat_name" type="text" Id="cat_name" size="30" dataType="Require" msg="该项必须填写">
        </td>
      </tr>
      <tr>
        <td width="17%"><font color="#FF0000">*</font>超链接：</td>
        <td width="83%"><input Name="hplink" type="text" Id="hplink" value="#" size="30" dataType="Require" msg="该项必须填写">
        </td>
      </tr>
      <tr>
        <td><font color="#FF0000">*</font>菜单排序：</td>
        <td><input name="seqorder" type="text" id="seqorder" size="4" value="0" datatype="Integer" msg="该项必须填写数字" />
        </td>
      </tr>
    </table>
  </form>
</div>
<script language="javascript">
$(function(){
	$("div.celltext").edit_table({
		param:{'table':'shop_menu'}
	});
});
function RqData(){
	$('#dialog_add').dialog({  
		hide:'',      
		autoOpen:false,
		width:600,
		height:300,  
		modal:true, //蒙层  
		title:'添加菜单', 
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
			'添加菜单':function(){dialog_add();}  
		}
	});
	$('#dialog_add').dialog('open');
}	

function dialog_add(){
	var form_ob=document.getElementById("dialog_add_form"); 
	if (!Validator.Validate(form_ob,3)) return false;
	$("#dialog_add_form")[0].submit();
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>