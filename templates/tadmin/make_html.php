<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：静态页面生成管理</td>
  </tr>
</table>
<fieldset>
<legend>生成静态页面项</legend>
<form name="mform">
  <table width="97%" border="0" cellpadding="5" cellspacing="0" style="margin:10px; line-height:25px" id="process">
    <?php foreach($news_catalog as $row){
  $per_page = 10;
  $page = ceil($row->num / ($per_page * 20));
  ?>
    <tr>
      <td width="5%"><input data-url="<?php echo my_site_url('make_html/make_news_pages');?>" total="<?php echo $page;?>" name="nid" type="checkbox" value="<?php echo $row->id;?>" checked="checked" /></td>
      <td width="76%" align="left"><?php
		if($row->deep_id == 0) echo '[分页]'.$row->cat_name;
		else echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).'[分页]'.$row->cat_name;
        ?></td>
      <td width="19%" align="right"> 等待... </td>
    </tr>
    <?php }?>
    <?php foreach($news_catalog as $row){
  $per_page = 50;
  $page = ceil($row->num / $per_page);
  ?>
    <tr>
      <td width="5%"><input data-url="<?php echo my_site_url('make_html/make_news');?>" total="<?php echo $page;?>" name="nid" type="checkbox" value="<?php echo $row->id;?>" checked="checked" /></td>
      <td width="76%" align="left"><?php
		if($row->deep_id == 0) echo '[详细页]'.$row->cat_name;
		else echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).'[详细页]'.$row->cat_name;
        ?></td>
      <td width="19%" align="right"> 等待... </td>
    </tr>
    <?php }?>
    <tr>
      <td width="5%"><input data-url="<?php echo my_site_url('make_html/sitemap_baidu');?>" total="1" name="nid" type="checkbox" value="" checked="checked" /></td>
      <td width="76%" align="left">百度地图</td>
      <td width="19%" align="right"> 等待... </td>
    </tr>
    <tr>
      <td width="5%"><input data-url="<?php echo my_site_url('make_html/google');?>" total="1" name="nid" type="checkbox" value="" checked="checked" /></td>
      <td width="76%" align="left">谷歌地图</td>
      <td width="19%" align="right"> 等待... </td>
    </tr>
    <tr>
      <td height="50" colspan="3" align="center" valign="bottom"><input type="button" id="sbtn" onclick="ajax_make_html(this)" value="点击生成页面" class="button-style2" style="width:100px" />
        &nbsp;&nbsp;&nbsp;
        <input type="checkbox" onclick="check_box(this.form.nid)" />
        全选</td>
    </tr>
  </table>
</form>
</fieldset>
<script language="javascript">
var items;
var itotal = 0;
var pId = 0;
var spId = 1;
function ajax_make_html(e)
{
	items = $('input[name=nid]:checked');
	itotal = items.length;
	if(itotal == 0)
	{
		alert('操作有误，请先选择要生成的项。');
		return ;
	}
	if(confirm('确定要开始生成吗?'))
	{
		e.disabled = true;
		pId = 0;
		ajax_process();
	}
}

function ajax_process()
{
	if(pId > itotal-1) 
	{
		$('<tr><td align="center" style="font-weight:bold;color:#009900" colspan="3">本次页面生成完毕</td></tr>').insertBefore('#process tr:eq(0)');
		document.getElementById('sbtn').disabled = false;
		return ;
	}
	var it = items.eq(pId);
	var ppar = 'cid='+it.val()+'&pid='+spId;
	it.parent().siblings(':eq(1)').html('进行中...');
	$.ajax({
		url:it.attr('data-url'),
		data:ppar,
		type:"POST",
		dataType:"json",
		success:function(msg)
		{
			if(typeof(msg.err) == 'undefined')
			{
				spId++;
				if(parseInt(it.attr('total')) >= spId)
				{
					setTimeout(function(){ajax_process();},2000);
				}
				else
				{
					it.parent().siblings(':eq(1)').html('<font color="#009900">生成完毕</font>');
					pId++;
					spId = 1;
					setTimeout(function(){ajax_process();},2000);
				}
			}
			else
			{
				it.parent().siblings(':eq(1)').html('<font color="#FF0000">生成失败</font>');
				pId++;
				spId = 1;
				setTimeout(function(){ajax_process();},2000);
			}
		}
	});
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
