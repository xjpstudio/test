<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<style type="text/css">
.ui-tx-tips-div{background:#FFFBF2;border:1px solid #F4DDBE; padding:10px; text-align:center; margin:10px 0;}
.ui-tx-tips-div a{ color:#FF0000}
</style>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."rule");?>">采集规则列表</a> &gt; 采集文章 </td>
  </tr>
</table>
<div class="ui-tx-tips-div" style="text-align:left">提示：<br>1、只采集文本，不采集图片，直接外链图片。<br>2、相同标题，将不会重复采集入库。<br>3、采集过程中，请不要刷新页面。<br>4、如果发现采集失败，大部分原因都是采集规则没写好。</div>
<fieldset>
<legend>采集设置</legend>
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" style="margin:10px 0; line-height:30px">
  <tr>
    <td align="left"><strong>采集规则名称：</strong></td>
    <td align="left"><?php echo $edit_data['title'];?></td>
  </tr>
  <tr>
    <td align="left"><strong>采集总页数：</strong></td>
    <td align="left"><?php echo $edit_data['page_total'];?></td>
  </tr>
   <tr>
    <td align="left"><strong>开启伪原创：</strong></td>
    <td align="left"><input type="checkbox" name="is_w" value="1" /></td>
  </tr>
  <tr>
    <td width="22%" align="left"><strong>入库文章分类：</strong></td>
    <td width="78%" align="left"><select name="catalog_id" id="catalog_id">
              <option value="">-选择分类-</option>
              <?php foreach($cat as $row) {?>
              <option value="<?php echo $row->queue;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
              <?php }?>
            </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="button" value="点击开始采集" onclick="get_data(this)" class="button-style2" style="width:100px"/></td>
  </tr>
</table>
</fieldset>
<fieldset>
<legend>采集进度</legend>
<table width="96%"  border="0" cellpadding="5" cellspacing="0" style="margin:10px; line-height:30px" id="process">
</table>
</fieldset>
<script language="javascript">
var rid = <?php echo $edit_data['id'];?>;
var page_total = <?php echo $edit_data['page_total'];?>;
var pId = 0;
var mitem;
var catalog_id;
$(function(){
	if(page_total > 0)
	{
		for(var i = 1; i <= page_total; i++)
		{
			$('<tr><td width="17%" align="left">第'+i+'页/'+page_total+'</td><td align="center" valign="middle">----------------------------------------------------------------------------------------------------</td><td width="15%" align="right" class="cqueue" page_no="'+i+'"><font color="#FF0000">等待采集</font></td></tr>').appendTo('#process');
		}
	}
});
function get_data(o)
{
	if(page_total == 0)
	{
		alert('操作有误，没有任何数据可采集');
		return ;
	}
	catalog_id = document.getElementById('catalog_id').value;
	if(confirm('确定要开始采集吗'))
	{
		o.disabled = true;
		mitem = $('.cqueue');
		pId = 0;
		ajax_process();
	}
}

function ajax_process()
{
	if(pId > mitem.length-1) 
	{
		$('<tr><td align="center" style="font-weight:bold;color:#009900" colspan="3">全部数据采集完毕</td></tr>').insertBefore('#process tr:eq(0)');
		return ;
	}
	var ppar = 'catalog_id='+catalog_id+'&rid='+rid+'&page_no='+mitem.eq(pId).attr('page_no');
	if($('input[name=is_w]:checked').length == 1) ppar += '&is_w = 1';
	else ppar += '&is_w = 0';
	mitem.eq(pId).html('数据采集中...');
	$.ajax({
		url:"<?php echo my_site_url(CTL_FOLDER.'ajax/caiji');?>",
		data:ppar,
		type:"POST",
		dataType:"json",
		success:function(msg)
		{
			if(typeof(msg.err) == 'undefined')
			{
				if(msg.msg == 'yes')
				{
					mitem.eq(pId).html("<font style=\"color:#009900\">采集完毕</font>");
				}
				else
				{
					mitem.eq(pId).html("<font style=\"color:#FF0000\">采集失败</font>");

				}
				pId++;
				setTimeout(function(){ajax_process();},3000);
			}
			else
			{
				alert('登录超时，请重新登录');
				return;
			}
		}
	});
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
