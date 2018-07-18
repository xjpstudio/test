<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：网站顶部导航</td>
  </tr>
</table>
<div class="ui-tx-tips-div" style="text-align:center">操作提示：添加到当前导航 --> 拖动排序 --> 提交保存</div>

<fieldset style="margin-bottom:20px">
<legend>添加导航</legend>
<form name="addForm">
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" style="margin:10px 0">
    <tr>
      <td width="91"><font color="#FF0000">*</font>导航链接：</td>
      <td width="652"><input type="text" size="50" maxlength="300" name="url" id="url" dataType="Require" msg="该项必填" />&nbsp;
          <select onchange="change_link(this)">
            <option value="">===调用栏目===</option>
            <?php foreach(get_cache('catalog') as $row){?>
            <option value="<?php echo my_site_url('search');?>?cid=<?php echo $row->id;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
            <?php }?>
            <option value="">===文章===</option>
            <?php foreach(get_cache('ncatalog') as $row){?>
            <option value="<?php echo create_link('p'.$row->id);?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
            <?php }?>
           
            <option value="<?php echo my_site_url('sitemap');?>">网站地图</option>
          </select>
          <br />
          <font style=" color:#FF0000">注:请从下拉菜单中选择链接或者直接黏贴链接地址</font></td>
    </tr>
    <tr>
      <td width="91"><font color="#FF0000">*</font>导航名称：</td>
      <td width="652"><input name="title" id="title" type="text" size="15" dataType="Require" msg="该项必须填写" maxlength="50" /></td>
    </tr>
    <tr>
      <td width="91"><font color="#FF0000">*</font>目标：</td>
      <td width="652"><select name="target">
          <option value="_blank">新窗口 (_blank)</option>
          <option value="_top">整页 (_top) </option>
          <option value="_self" selected="selected">本窗口 (_self) </option>
          <option value="_parent">父窗口 (_parent) </option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="91">&nbsp;</td>
      <td width="652"><input type="button" name="sbmit" onclick="submit_add_form()" value="添加到当前导航" class="button-style" style="width:100px" /></td>
    </tr>
  </table>
</form>
</fieldset>
<form method="post" action="<?php echo site_url(CTL_FOLDER.'top_nav/save_top_nav');?>">
  <fieldset>
  <legend>当前导航(双击可从当前导航中删除，拖动可对导航进行排序)</legend>
  <div class="nav_box">
    <ul id="cnav">
      <?php foreach($top_nav as $v){?>
      <li><?php echo $v['title'];?>
        <input type="hidden" name="top_nav[]" value="<?php echo $v['title'].'|'.$v['url'].'|'.$v['target'];?>" />
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

function change_link(v)
{
	if(v.value)
	{
		document.getElementById('url').value = v.value;
		document.getElementById('title').value = $(v).find('option:selected').html().replace(/&nbsp;/g,'');
	}
}

function submit_add_form()
{
	var theform = document.addForm;
	if( ! Validator.Validate(theform,3)) return ;
	var title = theform.title.value;
	title = title.replace(/\|/g,'');
	var url = theform.url.value;
	var target = theform.target.value;
	var str = title+'|'+url+'|'+target;
	if( ! checkr(str))
	{
		$('<li>'+title+'<input type="hidden" name="top_nav[]" value="'+str+'" /></li>').appendTo('#cnav');
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
		alert('至少添加一个网站导航');
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
