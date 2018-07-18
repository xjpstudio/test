<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<style type="text/css">
.ui-tx-tips-div{background:#FFFBF2;border:1px solid #F4DDBE; padding:10px; text-align:center; margin:10px 0;}
.ui-tx-tips-div a{ color:#FF0000}
</style>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."u_rule");?>">U站采集规则列表</a> &gt; 采集U站商品 </td>
  </tr>
</table>
<div class="ui-tx-tips-div" style="text-align:left">提示：<br>
1、销量和折扣价可能采集不到。<br>3、采集过程中，请不要刷新页面。<br>4、如果发现采集失败，大部分原因都是采集规则没写好。<br />
5、U站采集原理：先在U站抓取商品ID，然后根据ID到淘宝或天猫店铺采集对应的商品，所以在U站抓到的商品ID数和实际采集到的商品数可能不一致，因为U站商品更新太快，实际采集过程中，部分商品可能被删除或者已下架。
</div>
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
    <td width="22%" align="left"><strong>采集到分类：</strong></td>
    <td width="78%" align="left"><select name="catalog_id" id="catalog_id">
              <option value="">-选择分类-</option>
              <?php foreach($cat as $row) {?>
              <option value="<?php echo $row->queue;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
              <?php }?>
            </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="button" value="点击开始采集" <?php if( ! ($edit_data['page_total'] > 0)) echo 'disabled="disabled"';?> onclick="get_data(this)" class="button-style2" style="width:100px"/></td>
  </tr>
</table>
</fieldset>
<fieldset>
<fieldset>
  <legend>采集进度</legend>
  <table width="96%"  border="0" cellpadding="5" cellspacing="0" style="margin:10px; line-height:30px" id="process">
  <tr><td align="left" colspan="3"><label><input type="checkbox" name="sel" checked="checked" />全选</label></td></tr>
  <?php for($i = 1;$i <= $edit_data['page_total'];$i++){?>
  <tr><td width="17%" align="left"><label><input type="checkbox" value="<?php echo $i;?>" name="page_no" checked="checked" />第<?php echo $i;?>页/<?php echo $edit_data['page_total'];?></label></td>
  <td align="center" valign="middle">------------------------------------------------------------------------------</td>
  <td width="15%" align="right"><font color="#FF0000">等待采集</font></td></tr>
  <?php }?>
  </table>
  </fieldset>
<script language="javascript">
var page_total = <?php echo $edit_data['page_total'];?>;
var pId = 0;
var catalog_id;
$(function(){
	$('input[name=sel]').click(function(){
		$('input[name=page_no]').each(function(){
			if($(this)[0].checked == true) $(this)[0].checked = false;
			else $(this)[0].checked = true;
		})
	});
});
function get_data(o)
{
	page_total = $('input[name=page_no]:checked').length
	if(page_total == 0)
	{
		alert('至少需勾选一项');
		return ;
	}
	catalog_id = document.getElementById('catalog_id').value;
	if(confirm('确定要开始采集吗'))
	{
		o.disabled = true;
		pId = 0;
		ajax_process();
	}
}

function ajax_process()
{
	if(pId >= page_total) 
	{
		$('<tr><td align="center" style="font-weight:bold;color:#009900" colspan="3">采集完毕</td></tr>').insertBefore('#process tr:eq(0)');
		return ;
	}
	$('input[name=page_no]:checked').eq(pId).parent().parent().next().next().html('<img src="'+pic_loading_path+'" /> 数据采集中...');
	$.ajax({
		url:"<?php echo my_site_url(CTL_FOLDER.'ajax/get_num_iid');?>",
		data:'sid=<?php echo $edit_data['id'];?>&page_no='+$('input[name=page_no]:checked').eq(pId).val(),
		type:"POST",
		dataType:"json",
		success:function(msg)
		{
			if(typeof(msg.err) != 'undefined' && msg.err == 'nologin')
			{
				alert('登录超时，请重新登录');
				return;
			}
			else
			{
				if(typeof(msg.iids) != 'undefined')
				{
					u_caiji(msg.iids);
				}
				else
				{
					$('input[name=page_no]:checked').eq(pId).parent().parent().next().next().html("<font style=\"color:#FF0000\">采集失败</font>");
					pId++;
					setTimeout(function(){ajax_process();},1000);
				}
			}
		},
		error:function()
		{
			$('input[name=page_no]:checked').eq(pId).parent().parent().next().next().html("<font style=\"color:#FF0000\">采集失败</font>");
			pId++;
			setTimeout(function(){ajax_process();},1000);
		}
	});
}

var cur_page,total,num_iid;
function u_caiji(str)
{
	num_iid = str.split(',');
	total = num_iid.length;
	cur_page = 1;
	ajax_u_caiji();
}

function ajax_u_caiji()
{
	if(cur_page > total) 
	{
		hide_message();
		$('input[name=page_no]:checked').eq(pId).parent().parent().next().next().html("<font style=\"color:#009900\">采集完毕</font>");
		pId++;
		setTimeout(function(){ajax_process();},1000);
		return ;
	}
	
	var ppar = 'num_iid='+num_iid[cur_page-1]+'&catalog_id='+catalog_id;
	if($('input[name=is_w]:checked').length == 1) ppar += '&is_w=1';
	show_message('正采集第 '+$('input[name=page_no]:checked').eq(pId).val()+' 页的第 <b>'+cur_page+'</b> 个商品/总共 '+total+' 个',false);
	$.ajax({
		url:"<?php echo my_site_url(CTL_FOLDER.'ajax/u_caiji');?>",
		data:ppar,
		type:"POST",
		dataType:"json",
		success:function(msg)
		{
			if(typeof(msg.err) != 'undefined' && msg.err == 'nologin')
			{
				alert('登录超时，请重新登录');
				return;
			}
			else
			{
				cur_page++;
				ajax_u_caiji();
			}
		},
		error:function()
		{
			cur_page++;
			ajax_u_caiji();
		}
	});
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
