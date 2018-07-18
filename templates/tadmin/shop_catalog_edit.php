<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."shop");?>">店铺列表</a> &gt; <a href="<?php echo site_url(CTL_FOLDER."shop_catalog");?>">分类列表</a> &gt; 分类修改</td>
  </tr>
</table>
<fieldset>
<legend>分类修改</legend>
<form action="<?php echo site_url(CTL_FOLDER."shop_catalog/save_record");?>" method="post">
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td width="114"><font color="#FF0000">*</font>分类标题：</td>
      <td width="629"><input Name="cat_name" type="text" size="30" value="<?php echo $edit_data['cat_name'];?>" dataType="Require" msg="该项必须填写" maxlength="50" /></td>
    </tr>
    <tr>
      <td><font color="#FF0000">*</font>分类排序：</td>
      <td><input name="seqorder" type="text" id="seqorder" size="4" value="<?php echo $edit_data['seqorder'];?>"  datatype="Integer" msg="该项必须填写数字" maxlength="10" />
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input name="rd_id" type="hidden" value="<?php echo $edit_data['id'];?>" />
        <input type="button" onclick="subForm(this.form,this)" name="sbmit" value="修改" class="button-style2" /></td>
    </tr>
  </table>
</form>
</fieldset>
<?php $this->load->view(TPL_FOLDER."footer");?>
