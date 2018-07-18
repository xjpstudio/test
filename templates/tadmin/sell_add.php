<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo my_site_url(CTL_FOLDER.'product');?>">商品列表</a> &gt; 添加商品 </td>
  </tr>
</table>
<fieldset>
<legend>添加商品</legend>
<form action="<?php echo site_url(CTL_FOLDER."product/save_sell_add");?>" method="post" enctype="multipart/form-data">
<div class="ui-tx-tips-div">操作流程：填写淘宝商品ID或商品链接-->点击”获取数据”按钮-->点击添加按钮-->完成<br>提示：如果无法获取数据，请直接全部手工添加。</div>
<div class="ui-tx-block-title">1、填写淘宝商品ID</div>
<table width="100%"  border="0" cellpadding="3" cellspacing="0" >
  <tr>
      <td width="16%" valign="top"><font color="#FF0000">*</font>商品ID：</td>
      <td width="84%"><input name="num_iid" id="num_iid" type="text" size="20" maxlength="20" dataType="Custom" msg="ID格式有误" regexp="^[1-9]+\d*$" /> &nbsp; <input type="button" onclick="get_data()" value="获取数据" class="button-style" /> <br>
      例如：http://detail.tmall.com/item.htm?id=37497291598 链接中的<font color="#FF0000">37497291598</font> 就是商品ID
      </td>
    </tr>
</table>
<div class="ui-tx-block-title">2、商品基本信息</div>
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td width="16%" valign="top"><font color="#FF0000">*</font>商品标题：</td>
      <td width="84%"><input name="title" type="text" size="80" maxlength="100" dataType="Require" msg="该项必须填写" /></td>
    </tr>
    <tr>
      <td valign="top"><font color="#FF0000">*</font>商品链接：</td>
      <td><input name="click_url" id="click_url" type="text" size="80" datatype="Require" msg="该项必须填写" /> <input type="button" onclick="get_data1()" value="获取数据" class="button-style" /> <br>请填写淘宝或天猫商品详细页地址，例如：http://detail.tmall.com/item.htm?id=37497291598</td>
    </tr>
    <tr>
      <td width="16%" valign="top"><font color="#FF0000">*</font>零售价(￥)：</td>
      <td width="84%"><input name="shop_price" type="text" size="10" maxlength="10" dataType="Currency" msg="价格格式有误" /></td>
    </tr>
    <tr>
      <td width="16%" valign="top"><font color="#FF0000">*</font>折扣价(￥)：</td>
      <td width="84%"><input name="dc_price" type="text" size="10" maxlength="10" dataType="Currency" msg="价格格式有误" value="0" /> <font color="#FF0000">如果没有折扣价，请填写数字0</font></td>
    </tr>
    <tr>
          <td><font color="#FF0000">*</font>销量：</td>
          <td><input name="volume" type="text" size="10" value="0" maxlength="10" dataType="Int" msg="销量格式有误" /></td>
        </tr>
        <tr>
          <td><font color="#FF0000">*</font>喜欢数量：</td>
          <td><input name="love" type="text" size="10" maxlength="10" value="0" dataType="Int" msg="喜欢数量格式有误" /></td>
        </tr>
        <tr>
      <td width="16%" valign="top">掌柜昵称：</td>
      <td width="84%"><input name="nick" type="text" size="30" maxlength="100"  /> <a href="http://bbs.soke5.com/thread-27-1-1.html" target="_blank" style="color:#06F">查看掌柜昵称获取教程</a></td>
    </tr>
    <tr>
      <td valign="top"><font color="#FF0000">*</font>商品图片：</td>
      <td><input type="text" name="pic_path" id="pic_path" size="25" maxlength="300"  />
        <input name="big_pic" type="file" id="big_pic" size="20" dataType="Filter" accept="<?php echo str_replace("|",",",UP_IMAGES_EXT);?>" require="false" msg="图片格式有误" />
        <input type="button" name="sfbtn" class="button-style2" onclick="GetFileDialog('pic_path')" style="width:120px" value="选择图片" />
        <br />
        上传的图片格式必须是：<?php echo UP_IMAGES_EXT;?></td>
    </tr>
    <tr>
      <td valign="top">更多图片：</td>
      <td><div class="up_pic_form">
      <ul>
          <li><a href="javascript:extend_upload_input()" title="增加一张图片">[+]</a> <input type="text" name="pic_path1" maxlength="300" size="25" /> <input name="more_pic1" type="file" size="15" dataType="Filter" accept="<?php echo str_replace("|",",",UP_IMAGES_EXT);?>" require="false" msg="图片格式必须是：<?php echo UP_IMAGES_EXT;?>">
            <input type="hidden" value="1" name="more_pic_id[]" />
          </li>
        </ul>
        </div>
        </td>
    </tr>
    <tr>
      <td width="16%" valign="top">商品类目： </td>
      <td width="84%" valign="bottom">
      <div class="cat_list">
          <ul>
            <?php foreach(get_cache('catalog') as $row) {?>
            <li><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id);?><label><input type="checkbox" name="catalog_id[]" value="<?php echo trim($row->queue,',');?>" /><?php echo $row->cat_name;?></label></li>
            <?php }?>
          </ul>
        </div>
      </td>
    </tr>
    <tr>
      <td valign="top">所属店铺：</td>
      <td><select name="sid">
          <option value="0">-选择店铺-</option>
          <?php foreach($shop as $row) {?>
          <option value="<?php echo $row->id;?>"><?php echo $row->title;?></option>
          <?php }?>
        </select></td>
    </tr>
    <tr>
          <td valign="top">网页标题：</td>
          <td><input name="btitle" type="text" size="50" maxlength="100" value="{title}-{site_title}" /> 标签说明：网站标题{site_title}，商品标题{title}</td>
        </tr>
    <tr>
      <td valign="top">meta关键词：</td>
      <td><input type="text" name="keyword" maxlength="100" size="80" /><br>
        一般不超过100个字符</td>
    </tr>
    <tr>
      <td valign="top">meta描述：</td>
      <td><textarea name="description" cols="80" rows="3" dataType="Limit" max="200" msg="字数不超过200" require="false"></textarea><br>
        一般不超过200个字符</td>
    </tr>
    <tr>
      <td valign="top"><font color="#FF0000">*</font>排序号：</td>
      <td><input name="seqorder" type="text" id="seqorder" maxlength="8" size="4" value="0" datatype="Integer" msg="该项必须填写数字" /></td>
    </tr>
    <tr>
      <td colspan="2" style="padding-bottom:5px"><div class="ui-tx-block-title">3、商品描述</div>
       <textarea name="content" id="content" style="width:780px; height:450px;visibility:hidden;"></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="button" onclick="subForm(this.form,this)" value="添加" class="button-style" />
        &nbsp;&nbsp;
        <input type="button" onclick="document.location.href='<?php echo my_site_url(CTL_FOLDER.'product');?>'" value="返回" class="button-style2" /></td>
    </tr>
  </table>
</form>
</fieldset>
<script language="javascript">
KindEditor.ready(function(K){
	editor = K.create('textarea[name="content"]',editor_opt);
});
function subForm(f,e)
{
	if (!Validator.Validate(f,3)) return false;
	if(document.getElementById('pic_path').value == '' && document.getElementById('big_pic').value == '')
	{
		alert('请上传商品图片');
		return;
	}
	e.value = '数据处理中..';
	e.disabled = true;
	editor.sync();
	f.submit();
}
var global_loop=1;
function extend_upload_input()
{
	global_loop+=1;
	$(".up_pic_form li:last").after('<li><span style="cursor:pointer; color:#FF0000" title="删除" onclick="remove_ob(this)">[-]</span> <input type="text" class="inputstyle" name="pic_path'+global_loop+'" maxlength="300" size="25" /> <input class="inputstyle" name="more_pic'+global_loop+'" type="file" size="15" dataType="Filter" accept="jpg,gif,png,jpeg" require="false" msg="图片格式必须是：jpg|gif|png|jpeg"><input type="hidden" value="'+global_loop+'" name="more_pic_id[]" /></li>');
}
function get_data()
{
	var num_iid = document.getElementById("num_iid").value;
	num_iid = num_iid.Trim();
	var patrn=/^[1-9]+[0-9]*$/; 
	if ( ! patrn.exec(num_iid))
	{
		alert('填写的商品ID有误');
		return false;
	}
	document.location.href = '<?php echo my_site_url(CTL_FOLDER.'product/sell_add');?>?num_iid='+num_iid;
}
function get_data1()
{
	var click_url = document.getElementById("click_url").value;
	if (click_url == '')
	{
		alert('请填写商品链接地址');
		return false;
	}
	document.location.href = '<?php echo my_site_url(CTL_FOLDER.'product/sell_add');?>?url='+encodeURIComponent(click_url);
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
