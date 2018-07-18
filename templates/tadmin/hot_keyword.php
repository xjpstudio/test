<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：热门搜索关键词</td>
  </tr>
</table>
<div class="ui-tx-tips-div" style="text-align:center">操作提示：添加到当前关键词 --> 拖动排序 --> 提交保存</div>
<fieldset style="margin-bottom:20px">
<legend>添加关键词</legend>
<form name="addForm">
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
   <tr>
        <td width="129"><b>搜索关键词</b>：<br /></td>
        <td width="614"><input type="text" name="q" maxlength="50" size="15" /> 提示：设置关键词，将调用标题含有该关键词的商品，建议简短，不包含空格逗号 或不设关键词</td>
      </tr>
      <tr>
        <td width="129"><strong>商品类目：</strong></td>
        <td width="614"><select name="cid">
      <option value="0">选择分类</option>
      <?php foreach(get_cache('catalog') as $row){
		  ?>
      <option value="<?php echo $row->id;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
      <?php }?>
      </select> 提示：选择分类，就等于调用该分类的商品。</td>
      </tr>
    <tr>
      <td width="129"><font color="#FF0000">*</font><strong>关键词名称：</strong>
      </td>
      <td width="614"><input Name="title" type="text" size="15" dataType="Require" msg="该项必须填写" maxlength="50"> <font style="color:#FF0000">显示出来的名称。</font></td>
    </tr>
    <tr>
      <td width="129">&nbsp;</td>
      <td width="614"><input type="button" name="sbmit" onclick="submit_add_form()" value="添加到当前关键词" class="button-style" style="width:100px" /></td>
    </tr>
  </table>
</form>
</fieldset>

<form method="post" action="<?php echo site_url(CTL_FOLDER.'hot_keyword/save_hot_keyword');?>">
  <fieldset>
  <legend>当前关键词(双击可从当前关键词中删除，拖动可对关键词进行排序)</legend>
  <div class="nav_box">
    <ul id="cnav">
      <?php foreach($hot_keyword as $v){?>
      <li><?php echo $v['title'];?><input type="hidden" name="hot_keyword[]" value="<?php echo $v['title'].'|'.$v['cid'].'|'.$v['q'];?>" />
      </li>
      <?php }?>
    </ul>
  </div>
  <div class="clear"></div>
  <div style="text-align:center; padding:10px">
    <input type="button" onclick="submit_nav(this.form,this)" class="button-style" value="提交保存" />
  </div>
  </fieldset>
</form>
<script language="javascript">
$(document).ready(function(){
	$("#cnav").sortable();
	$("#cnav li").live('dblclick',function(){
		$(this).remove();
	});
}); 

function submit_add_form()
{
	var theform = document.addForm;
	if( ! Validator.Validate(theform,3)) return ;
	var title = theform.title.value;
	title = title.replace(/\|/g,'');
	var cid = theform.cid.value;
	var q = theform.q.value;
	if(q == '' && parseInt(cid) == 0)
	{
		alert('商品类目或者关键词，二者必填其一');
		return;
	}
	if(q) q = q.replace(/\|/g,'');
	var str = title+'|'+cid+'|'+q;
	if( ! checkr(str))
	{
		$('<li>'+title+'<input type="hidden" name="hot_keyword[]" value="'+str+'" /></li>').appendTo('#cnav');
		theform.reset();
	}
	else
	{
		alert('该导航已经存在，请勿重复添加');
	}
}

function submit_nav(f,e)
{
	if($("#cnav li").length == 0)
	{
		alert('至少添加一个关键词');
	}
	else
	{
		if(confirm('确定要修改吗'))
		{
			e.value = '数据处理中..';
			e.disabled = true;
			f.submit();
		}
	}
}
function checkr(v)
{
	var f = false;
	$('#cnav input').each(function(){
		if($(this).val() == v)
		{
			f = true;
		}
	});
	return f;
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
