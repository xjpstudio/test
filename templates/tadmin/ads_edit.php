<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."ads");?>">广告列表</a> &gt; 广告修改</td>
  </tr>
</table>
<fieldset>
<legend>广告修改</legend>
<form action="<?php echo site_url(CTL_FOLDER."ads/save_record");?>" method="post" enctype="multipart/form-data" name="dialog_edit_form" id="dialog_edit_form">
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td colspan="2" align="center"><font style="color:#FF0000">注：你可以选择上传广告图片并添加广告链接，或者填写js广告代码，例如阿里妈妈广告代码,一旦填写js广告代码，则上传的广告将会被忽略</font></td>
    </tr>
    <tr>
      <td width="135"><font color="#FF0000">*</font>广告类型：</td>
      <td width="578"><input name="is_pic" type="radio" value="1" <?php if($edit_data['is_pic']==1) echo "checked";?>>
        图片
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="is_pic" value="0" <?php if($edit_data['is_pic']==0) echo "checked";?>>
        Flash </td>
    </tr>
    <tr>
      <td width="135"><font color="#FF0000">*</font>广告图片标题：</td>
      <td width="578"><input Name="title" type="text" Id="title" size="30" value="<?php echo $edit_data['title'];?>" dataType="Require" msg="该项必须填写">
      </td>
    </tr>
  </table>
  <fieldset>
  <legend>上传广告</legend>
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td width="135">广告尺寸(像素)：</td>
      <td width="578">宽
        <input name="width" type="text" size="5"  value="<?php echo $edit_data['width'];?>" dataType="Integer" msg="宽度必须是数字" require="false">
        x 高
        <input name="height" type="text" size="5"  value="<?php echo $edit_data['height'];?>" dataType="Integer" msg="高度必须是数字" require="false">
      </td>
    </tr>
    <tr>
      <td width="135">链接地址：</td>
      <td width="578"><input Name="hplink" type="text" Id="hplink" size="50"  value="<?php echo $edit_data['hplink'];?>"></td>
    </tr>
    <tr>
      <td>上传文件：</td>
      <td><?php 
		  if($edit_data['is_pic']==1)
		  {
		  ?>
        <img src="{root_path}images/loading.gif" rel="<?php echo get_real_path($edit_data['file_path']);?>" border="0" class="jq_pic_loading" /><br />
        <?php 
		}
		?>
        <input type="text" value="<?php echo $edit_data['file_path'];?>" name="pic_path" id="pic_path" size="25" />
        <input name="pic" type="file" id="pic" size="20" dataType="Filter" accept="jpg,png,gif,swf" require="false" msg="文件格式必须是：jpg|png|gif|swf" title="上传的文件格式必须是：jpg|png|gif|swf,且单个文件不能超过 <?php echo ini_get("upload_max_filesize");?>">
        <input type="button" name="sfbtn" class="button-style2" onclick="GetFileDialog('pic_path')" value="选择文件" />
      </td>
    </tr>
  </table>
  </fieldset>
  <fieldset>
  <legend>添加js广告代码</legend>
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td width="135">js广告代码：</td>
      <td width="578"><textarea name="js_code" cols="50" rows="6"><?php echo $edit_data['js_code'];?></textarea></td>
    </tr>
  </table>
  </fieldset>
  <input name="rd_id" type="hidden" value="<?php echo $edit_data['id'];?>" />
  <input type="button" name="sbmit" style=" margin-left:160px; margin-bottom:10px; margin-top:10px" onclick="subForm(this.form,this)" value="修改" class="button-style2" />
</form>
</fieldset>
<?php $this->load->view(TPL_FOLDER."footer");?>
