<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."news");?>">文章列表</a> &gt; <a href="<?php echo site_url(CTL_FOLDER."news_catalog");?>">分类列表</a> &gt; 分类修改</td>
  </tr>
</table>
<fieldset>
<legend>分类修改</legend>
<form action="<?php echo site_url(CTL_FOLDER."news_catalog/save_record");?>" method="post" name="dialog_edit_form" id="dialog_edit_form">
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td width="135"><font color="#FF0000">*</font>所属分类：</td>
      <td width="592"><select name="parent_id" id="parent_id">
          <option value="0">==根目录==</option>
          <?php 
			foreach($catalog_list as $row) {
				if(strpos($row->queue,','.$edit_data['id'].',') === FALSE)
				{
			?>
          <option value="<?php echo $row->id;?>" <?php if($edit_data['parent_id']==$row->id) echo "selected";?>><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
          <?php
			 	}
			}?>
        </select> &nbsp;&nbsp; <label style="color:#F00"><input type="checkbox" name="is_push" value="1" <?php if($edit_data['is_push'] == 1) echo 'checked';?> />首页显示</label></td>
    </tr>
    <tr>
      <td width="135"><font color="#FF0000">*</font>分类标题：</td>
      <td width="592"><input Name="cat_name" type="text" size="30" value="<?php echo $edit_data['cat_name'];?>" dataType="Require" msg="该项必须填写"></td>
    </tr>
    <tr>
          <td>网页标题：</td>
          <td><input name="btitle" type="text" size="50" maxlength="100" value="<?php echo $edit_data['btitle'];?>" /> 标签说明：网站标题{site_title}，分类标题{title}</td>
        </tr>
    <tr>
        <td valign="top">meta关键词：</td>
        <td><input type="text" name="keyword" value="<?php echo $edit_data['keyword'];?>" maxlength="100" size="80" />
          <br>
          一般不超过100个字符</td>
      </tr>
      <tr>
        <td valign="top">meta描述：</td>
        <td><textarea name="description" cols="80" rows="3" dataType="Limit" max="200" msg="字数不超过200" require="false"><?php echo $edit_data['description'];?></textarea>
          <br>
          一般不超过200个字符</td>
      </tr>
    <tr>
      <td><font color="#FF0000">*</font>分类排序：</td>
      <td><input name="seqorder" type="text" id="seqorder" size="4" value="<?php echo $edit_data['seqorder'];?>"  datatype="Integer" msg="该项必须填写数字" />
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input name="rd_id" type="hidden" value="<?php echo $edit_data['id'];?>" />
        <input name="old_parent_id" type="hidden" value="<?php echo $edit_data['parent_id'];?>" />
        <input name="is_has_chd" type="hidden" value="<?php echo $edit_data['is_has_chd'];?>" />
        <input type="button" onclick="subForm(this.form,this)" name="sbmit" value="修改" class="button-style2" /></td>
    </tr>
  </table>
</form>
</fieldset>
<?php $this->load->view(TPL_FOLDER."footer");?>
