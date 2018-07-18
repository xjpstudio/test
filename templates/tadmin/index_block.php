<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<style type="text/css">
.nav_box ul li {
	width:750px;
	float:none;
	display:block;
	height: 40px;
	text-align:left;
}
</style>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：编辑首页版块</td>
  </tr>
</table>
<div class="ui-tx-tips-div" style="text-align:center">操作提示：添加商品或店铺版块 到 当前首页版块 --> 拖动排序 --> 提交保存</div>
<div id="TabAdd" style="display:none; margin:10px 0">
  <ul>
    <li><a href="#TabAdd-1"><span>调用商品</span></a></li>
    
  </ul>
    <div id="TabAdd-1">
      <form name="addForm">
    <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
      <tr>
        <td width="108"><font color="#FF0000">*</font><strong>版块名称：</strong></td>
        <td width="621"><input Name="title" type="text" size="15" dataType="Require" msg="该项必须填写" maxlength="50"></td>
      </tr>
      <tr>
        <td width="108"><strong>商品类目：</strong>
          </td>
        <td width="621"><select name="cid">
      <option value="">选择分类</option>
      <?php foreach(get_cache('catalog') as $row){
		  ?>
      <option value="<?php echo $row->id;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
      <?php }?>
      </select> 提示：选择分类，就等于调用该分类的商品。</td>
      </tr>
      <tr>
        <td width="108"><b>搜索关键词</b>：
          </td>
        <td width="621"><input type="text" name="q" maxlength="50" size="15" /> 提示：设置关键词，将调用标题含有该关键词的商品，建议简短，不包含空格逗号 或不设关键词</td>
      </tr>
      <tr>
        <td><strong>价格范围：</strong></td>
        <td><input type="text" name="sp" maxlength="10" size="10" dataType="Currency" msg="价格格式有误" require="false" /> - <input type="text" name="ep" maxlength="10" size="10" dataType="Currency" msg="价格格式有误" require="false" /></td>
      </tr>
      <tr>
        <td><strong>排序：</strong></td>
        <td><select name="sorts">
      <option value="">选择排序方式</option>
          <option value="p">价格从低到高</option>
          <option value="pd">价格从高到低</option>
          <option value="d">销量从高到低</option>
      </select></td>
      </tr>
      <tr>
        <td><font color="#FF0000">*</font><strong>显示个数：</strong></td>
        <td><input name="num" type="text" size="3" value="10" dataType="Custom" regexp="^[1-9]+\d*$" msg="个数填写有误" maxlength="2" id="num" /></td>
      </tr>
      <tr>
        <td width="108">&nbsp;</td>
        <td width="621"><input type="button" name="sbmit" onclick="submit_add_form()" value="添加到当前版块" class="button-style" style="width:100px" /></td>
      </tr>
    </table>
  </form>
    </div>
    <div id="TabAdd-2">
      <form name="addForms">
    <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
      <tr>
        <td width="105"><font color="#FF0000">*</font><strong>版块名称：</strong></td>
        <td width="624"><input Name="title" type="text" size="15" dataType="Require" msg="该项必须填写" maxlength="50"></td>
      </tr>
      <tr>
        <td width="105"><font color="#FF0000">*</font><strong>店铺分类：</strong></td>
        <td width="624"><select name="cid" dataType="Require" msg="该项必选">
      <option value="">选择分类</option>
      <?php foreach($shop_catalog as $row){?>
      <option value="<?php echo $row->id;?>"><?php echo $row->cat_name;?></option>
      <?php }?>
      </select> 提示：选择分类，就等于调用该分类的店铺。</td>
      </tr>
      <tr>
        <td><font color="#FF0000">*</font><strong>显示个数：</strong></td>
        <td><input name="num" type="text" size="3" value="14" dataType="Custom" regexp="^[1-9]+\d*$" msg="个数填写有误" maxlength="2" id="num" /></td>
      </tr>
      <tr>
        <td width="105">&nbsp;</td>
        <td width="624"><input type="button" name="sbmit" onclick="submit_add_forms()" value="添加到当前版块" class="button-style" style="width:100px" /></td>
      </tr>
    </table>
  </form>
    </div>
</div>
<form method="post" action="<?php echo site_url(CTL_FOLDER.'index_block/save_index_block');?>">
  <fieldset style="margin-bottom:20px">
    <legend>当前首页版块(双击可从当前首页版块中删除，拖动可对首页版块进行排序)</legend>
    <div class="nav_box">
      <ul id="cnav">
        <?php foreach($index_block as $v){
	  $str = $v['title'].'|'.$v['q'].'|'.$v['cid'].'|'.$v['sp'].'|'.$v['ep'].'|'.$v['sorts'].'|'.$v['num'];
	  if(isset($v['cat'])) $str .= '|'.$v['cat'];
	  else $str .= '|1'; 
	  ?>
        <li>版块名称：<?php echo $v['title'];?> &nbsp;&nbsp; 关键词：<?php echo $v['q'];?> &nbsp;&nbsp; 商品类目ID：<?php echo $v['cid'];?> &nbsp;&nbsp; 起始价：<?php echo $v['sp'];?> &nbsp;&nbsp; 结束价：<?php echo $v['ep'];?>&nbsp;&nbsp;排序： <?php echo $v['sorts'];?>&nbsp;&nbsp;显示个数： <?php echo $v['num'];?>
          <input type="hidden" name="index_block[]" value="<?php echo $str;?>" />
        </li>
        <?php }?>
      </ul>
    </div>
    <div class="clear"></div>
    <div style="text-align:center">
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
	$("#TabAdd").tabs();
	$("#TabAdd").show();
}); 

function submit_add_form()
{
	var theform = document.addForm;
	if( ! Validator.Validate(theform,3)) return ;
	var title = theform.title.value;
	var cid = theform.cid.value;
	var q = theform.q.value;
	var sp = theform.sp.value;
	var ep = theform.ep.value;
	var sorts = theform.sorts.value;
	var num = theform.num.value;
	title = title.replace(/\|/g,'');
	q = q.replace(/\|/g,'');
	
	if(cid == '' && q == '')
	{
		alert('关键词、商品类目二者至少填写一项');
		return;
	}
	var str = title+'|'+q+'|'+cid+'|'+sp+'|'+ep+'|'+sorts+'|'+num+'|1';
	if( ! checkr(str))
	{
		$('<li>版块名称：'+title+' &nbsp;&nbsp; 关键词：'+q+' &nbsp;&nbsp; 商品类目ID：'+cid+' &nbsp;&nbsp; 起始价：'+sp+' &nbsp;&nbsp; 结束价：'+ep+'&nbsp;&nbsp;排序： '+sorts+'&nbsp;&nbsp;显示个数：'+num+'<input type="hidden" name="index_block[]" value="'+str+'" /></li>').appendTo('#cnav');
		theform.reset();
	}
	else
	{
		alert('该导航已经存在，请勿重复添加');
	}
}

function submit_add_forms()
{
	var theform = document.addForms;
	if( ! Validator.Validate(theform,3)) return ;
	var title = theform.title.value;
	var cid = theform.cid.value;
	var q = '';
	var sp = '';
	var ep = '';
	var sorts = '';
	var num = theform.num.value;
	title = title.replace(/\|/g,'');
	
	var str = title+'|'+q+'|'+cid+'|'+sp+'|'+ep+'|'+sorts+'|'+num+'|2';
	if( ! checkr(str))
	{
		$('<li>版块名称：'+title+' &nbsp;&nbsp; 关键词：'+q+' &nbsp;&nbsp; 商品类目ID：'+cid+' &nbsp;&nbsp; 起始价：'+sp+' &nbsp;&nbsp; 结束价：'+ep+'&nbsp;&nbsp;排序： '+sorts+'&nbsp;&nbsp;显示个数：'+num+'<input type="hidden" name="index_block[]" value="'+str+'" /></li>').appendTo('#cnav');
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
		alert('至少添加一个首页版块');
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
