<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."menu");?>">菜单列表</a> &gt; 菜单修改</td>
  </tr>
</table>
<fieldset>
<legend>菜单修改</legend>
<form action="<?php echo site_url(CTL_FOLDER."menu/save_record");?>" method="post" name="dialog_edit_form" id="dialog_edit_form" onsubmit="return Validator.Validate(this,3)">
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td width="146"><font color="#FF0000">*</font>所属菜单：</td>
      <td width="849"><select name="parent_id" id="parent_id">
      <option value="0">根目录</option>
          <?php 
		  if($edit_data['parent_id']>0){
			foreach($catalog_list as $row) {
				if($row->id!=$edit_data['id']&&$row->parent_id==0)
				{
			?>
          <option value="<?php echo $row->id;?>" <?php if($edit_data['parent_id']==$row->id) echo "selected";?>><?php echo $row->cat_name;?></option>
          <?php
			 	}
			}
		}?>
        </select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="1" name="is_trash" title="该项对超级管理员无效" <?php if($edit_data['is_trash']==1) echo "checked";?> /> 隐藏菜单</td>
    </tr>
    <tr>
      <td width="146"><font color="#FF0000">*</font>菜单标题：</td>
      <td width="849"><input Name="cat_name" type="text" Id="cat_name" size="30" value="<?php echo $edit_data['cat_name'];?>" dataType="Require" msg="该项必须填写">
      </td>
    </tr>
     <tr>
        <td width="17%"><font color="#FF0000">*</font>超链接：</td>
        <td width="83%"><input Name="hplink" type="text" Id="hplink" value="<?php echo $edit_data['hplink'];?>" size="30" dataType="Require" msg="该项必须填写">
        </td>
      </tr>
    <tr>
      <td><font color="#FF0000">*</font>菜单排序：</td>
      <td><input name="seqorder" type="text" id="seqorder" size="4" value="<?php echo $edit_data['seqorder'];?>"  datatype="Integer" msg="该项必须填写数字" />
      </td>
    </tr>
  </table>
  <input name="rd_id" type="hidden" value="<?php echo $edit_data['id'];?>" />
  <input type="submit" name="sbmit" style=" margin-left:120px; margin-bottom:10px; margin-top:10px" value="修改" class="button-style2" />
</form>
</fieldset>
<?php $this->load->view(TPL_FOLDER."footer");?>
