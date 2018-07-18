<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."product");?>">商品列表</a> &gt; 分类管理</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:solid 1px #3C4952; margin-bottom:5px; margin-top:5px">
  <tr>
    <td width="501" height="24" align="right" ><span style="cursor:pointer" onClick="RqData()"><img src="{tpl_path}images/add.png">添加分类</span></td>
    <td width="496" align="right"  style="padding-right:10px"><a href="<?php echo my_site_url(CTL_FOLDER.'product_catalog/re_cache');?>"><img src="{tpl_path}images/refresh.jpg"  /> 更新分类缓存</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url(CTL_FOLDER."product");?>"><img src="{tpl_path}images/default_icon.gif" border="0"> 管理商品</a></td>
  </tr>
</table>
<form method="post" name="list_form" id="list_form">
  <table width="100%" cellspacing="0" class="widefat">
    <thead>
      <tr id="trth">
        <th width="3%" ><input type="checkbox" onclick="check_box(this.form.rd_id)" /></th>
        <th width="59%" id="cat_name">标题</th>
        <th width="15%">商品数量</th>
        <th width="15%">排序</th>
        <th width="8%">操作</th>
      </tr>
    </thead>
    <tbody id="check_box_id">
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
			echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id)."|-<div class='celltext'>{$row->cat_name}</div>";
		}
        ?></td>
        <td><?php echo $row->num;?></td>
        <td><input name="sort<?php echo $row->id;?>" value="<?php echo $row->seqorder;?>" type="text"  id="sort<?php echo $row->id;?>" size="2" maxlength="10" dataType="Integer" msg="排序号必须为数字" title="排序号必须为数字,数字越大越靠前"></td>
        <td><a href="<?php echo site_url(CTL_FOLDER."product_catalog/edit_record/".$row->id);?>">修改</a></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="padding-top:5px"><input type="checkbox" onclick="check_box(this.form.rd_id)" />
        全选
        <select name="action_url" id="action_url">
          <option value="" style="color:#FF0000">-选择操作-</option>
          <option value="<?php echo site_url(CTL_FOLDER."product_catalog/del_record");?>">删除</option>
          <option value="<?php echo site_url(CTL_FOLDER."product_catalog/sort_record");?>">排序</option>
        </select>
        &nbsp;
        <input type="button" name="submit_list_button" class="button-style2" onclick="submit_list_form(this.form,this)" id="submit_list_button" value="执行操作" />
        <img src="{tpl_path}images/notice.gif" class="tooltips" title="操作步骤：在左边勾选要操作的记录-->选择需要执行的操作-->点击“执行操作”按钮-->完成" /></td>
    </tr>
  </table>
</form>
<div id="dialog_add" style="display:none; position:relative">
  <form action="<?php echo site_url(CTL_FOLDER."product_catalog/add_record");?>" method="post" name="dialog_add_form" id="dialog_add_form">
    <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
      <tr>
        <td width="146"><font color="#FF0000">*</font>所属分类：</td>
        <td width="849"><select name="parent_id" id="parent_id">
            <option value="0">==根目录==</option>
            <?php foreach($catalog_list as $row) {?>
            <option value="<?php echo $row->id;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
            <?php }?>
          </select></td>
      </tr>
      <tr>
        <td width="146"><font color="#FF0000">*</font>分类标题：</td>
        <td width="849"><input Name="cat_name" type="text" Id="cat_name" size="30" dataType="Require" msg="该项必须填写"></td>
      </tr>
      <tr>
          <td>网页标题：</td>
          <td><input name="btitle" type="text" size="50" maxlength="100" value="{title}-{site_title}" /> 标签说明：网站标题{site_title}，分类标题{title}</td>
        </tr>
      <tr>
        <td valign="top">meta关键词：</td>
        <td><input type="text" name="keyword" maxlength="100" size="80" />
          <br>
          一般不超过100个字符</td>
      </tr>
      <tr>
        <td valign="top">meta描述：</td>
        <td><textarea name="description" cols="80" rows="3" dataType="Limit" max="200" msg="字数不超过200" require="false"></textarea>
          <br>
          一般不超过200个字符</td>
      </tr>
      <tr>
        <td><font color="#FF0000">*</font>分类排序：</td>
        <td><input name="seqorder" type="text" id="seqorder" size="4" value="0" datatype="Integer" msg="该项必须填写数字" /></td>
      </tr>
    </table>
  </form>
</div>
<script language="javascript">
$(function(){
	$("div.celltext").edit_table({
		param:{'table':'shop_product_catalog'}
	});
});
function RqData(){
	$('#dialog_add').dialog({  
		hide:'',      
		autoOpen:false,
		width:750,
		height:350,  
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
	$("#TabAdd").tabs();
}	

function dialog_add(){
	var form_ob=document.getElementById("dialog_add_form"); 
	if (!Validator.Validate(form_ob,3)) return false;
	$("#dialog_add_form")[0].submit();
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
