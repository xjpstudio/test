<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<script type="text/javascript" src="{root_path}js/My97DatePicker/WdatePicker.js" charset="gb2312"></script>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo $url;?>">文章列表</a> &gt; 添加文章</td>
  </tr>
</table>
<div id="TabAdd" style="display:none">
  <ul>
    <li><a href="#TabAdd-1"><span>基本信息</span></a></li>
    <li><a href="#TabAdd-2"><span>文章内容</span></a></li>
  </ul>
  <form action="<?php echo site_url(CTL_FOLDER."news/save_copy_record");?>" method="post" enctype="multipart/form-data" name="dialog_edit_form" id="dialog_edit_form">
    <div id="TabAdd-1">
      <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
        <tr>
          <td width="133"><font color="#FF0000">*</font>文章分类：</td>
          <td width="592"><select name="catalog_id">
              <option value="">-选择分类-</option>
              <?php foreach($catalog_list as $row) {?>
              <option value="<?php echo $row->queue;?>" <?php if($edit_data['catalog_id']==$row->queue) echo "selected";?>><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
              <?php }?>
            </select></td>
        </tr>
        <tr>
          <td width="133"><font color="#FF0000">*</font>文章标题：</td>
          <td width="592"><input Name="title" type="text" size="50" value="<?php echo $edit_data['title'];?>" dataType="Require" msg="该项必须填写" maxlength="100" /></td>
        </tr>
        <tr>
          <td width="133">网页标题：</td>
          <td width="592"><input name="btitle" type="text" size="50" maxlength="100" value="<?php echo $edit_data['btitle'];?>" /> 标签说明：网站标题{site_title}，文章标题{title}</td>
        </tr>
        <tr>
          <td width="133">meta关键词：</td>
          <td width="592"><input type="text" name="keyword" maxlength="100" size="50" value="<?php echo $edit_data['keyword'];?>" /><br>关键字之间使用半角逗号（,）分隔，不超过100个字符</td>
        </tr>
        <tr>
          <td>meta描述：</td>
          <td><textarea name="description" cols="50" rows="5"><?php echo $edit_data['description'];?></textarea></td>
        </tr>
        <tr>
          <td>摘要：</td>
          <td><textarea name="summary" id="summary" cols="50" rows="5"><?php echo $edit_data['summary'] ;?></textarea></td>
        </tr>
        <tr>
          <td width="133">作者：</td>
          <td width="592"><input Name="author" type="text" size="10" maxlength="50" value="<?php echo $edit_data['author'];?>">
          </td>
        </tr>
        <tr>
          <td width="133">来源：</td>
          <td width="592"><input Name="source" type="text" size="10" maxlength="50" value="<?php echo $edit_data['source'];?>">
          </td>
        </tr>
        <tr>
          <td width="133"><font color="#FF0000">* </font>发布日期：</td>
          <td><input name="create_date" onClick="WdatePicker({'dateFmt':'yyyy-MM-dd HH:mm:ss'})" type="text" size="40" value="<?php echo date("Y-m-d H:i:s",$edit_data['create_date']);?>" readonly="readonly" />
          </td>
        </tr>
        <tr>
          <td>上传图片：</td>
          <td><img src="{tpl_path}images/loading.gif" rel="<?php echo get_real_path($edit_data['pic_path']);?>" border="0" class="jq_pic_loading" /><br />
            <input type="text" value="<?php echo $edit_data['pic_path'];?>" name="pic_path" id="pic_path" size="25" maxlength="255" />
            <input name="pic" type="file" id="pic" size="15" dataType="Filter" accept="<?php echo str_replace("|",",",UP_IMAGES_EXT);?>" require="false" msg="图片格式有误">
            <input type="button" class="button-style2" onclick="GetFileDialog('pic_path')" value="选择文件" /><br>上传图片格式：<?php echo UP_IMAGES_EXT;?>
          </td>
        </tr>
        <tr>
          <td><font color="#FF0000">*</font>排序号：</td>
          <td><input name="seqorder" type="text" id="seqorder" size="4" value="<?php echo $edit_data['seqorder'];?>"  datatype="Integer" msg="该项必须填写数字" />
          </td>
        </tr>
      </table>
    </div>
    <div id="TabAdd-2">
      <textarea name="content" id="content" style="width:780px; height:450px;visibility:hidden;"><?php echo htmlspecialchars($edit_data['content']);?></textarea>
    </div>
    <input name="url" type="hidden" value="<?php echo $url;?>" />
    <input type="button" name="sbmit" style=" margin-left:160px; margin-bottom:10px; margin-top:10px" onclick="subForm(this.form,this)" value="添加" class="button-style" />
  </form>
</div>
<script language="javascript">
KindEditor.ready(function(K){
	editor = K.create('textarea[name="content"]',editor_opt);
});
$(document).ready(function(){
	$("#TabAdd").tabs();
	$("#TabAdd").show();
});
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
