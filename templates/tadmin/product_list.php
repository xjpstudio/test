<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."product");?>">全部商品</a></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:solid 1px #3C4952; margin-bottom:5px; margin-top:5px">
  <tr>
    <td width="66%" height="24" align="left" ><form method="get">
        <input type="text" name="s_keyword" id="s_keyword" size="15" maxlength="50">
        &nbsp;
        <select name="cid" style="width:150px">
          <option value="">-选择类目-</option>
          <?php foreach(get_cache('catalog') as $row) {?>
          <option value="<?php echo $row->id;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
          <?php }?>
        </select> &nbsp;
        <select name="sid" style="width:100px">
          <option value="">-选择店铺-</option>
          <?php foreach($shop as $row) {?>
          <option value="<?php echo $row->id;?>"><?php echo $row->title;?></option>
          <?php }?>
        </select>
        &nbsp;
        <input type="submit" name="s_sb" value="搜索" class="button-style2">
      </form> &nbsp; <a href="?" style="color:#F00">全部</a></td>
    <td width="34%" align="right"><a href="<?php echo site_url(CTL_FOLDER."shop");?>"><img src="{tpl_path}images/312.gif" /> 采集商品</a>&nbsp; |&nbsp; <a href="<?php echo site_url(CTL_FOLDER."product/sell_add");?>"><img src="{tpl_path}images/add.png" /> 添加商品</a>&nbsp; |&nbsp; <a href="javascript:void(0)" onclick="if(confirm('确定要删除所有商品吗?')) document.location.href='<?php echo my_site_url(CTL_FOLDER.'product/clear');?>'"><img src="{tpl_path}images/icon_trash.gif" /> 一键清空</a></td>
  </tr>
</table>
<form method="post" name="list_form" id="list_form">
  <table width="100%" cellspacing="0" class="widefat">
    <thead>
      <tr id="trth">
        <th width="4%"><input type="checkbox" onclick="check_box(this.form.rd_id)" /></th>
        <th width="9%">缩略图</th>
        <th width="29%">商品标题</th>
        <th width="11%">所属分类</th>
        <th width="12%">价格(￥)</th>
        <th width="9%">排序</th>
        <th width="11%">日期</th>
        <th width="15%">操作</th>
      </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody id="check_box_id">
      <?php foreach($query as $row) {?>
      <tr>
        <td class="rdId"><input name="rd_id[]" type="checkbox" id="rd_id" value="<?php echo $row->id;?>"></td>
        <td><img src="{tpl_path}images/loading.gif" rel="<?php echo get_real_path($row->small_pic_path);?>" border="0" class="jq_pic_loading"  /></td>
        <td><div id="<?php echo $row->id;?>" f="title" class="celltext"><?php echo $row->title;?></div></td>
        <td><?php echo get_product_cat_name($row->catalog_id);?></td>
        <td><?php echo $row->shop_price;?>/<?php echo $row->dc_price;?></td>
        <td><input name="sort<?php echo $row->id;?>" value="<?php echo $row->seqorder;?>" type="text" size="2" maxlength="10" dataType="Integer" msg="排序号必须为数字" title="数字越大越靠前" /></td>
        <td><?php echo date('Y-m-d',$row->create_date);?></td>
        <td><a href="<?php echo site_url(CTL_FOLDER."product/sell_edit");?>?id=<?php echo $row->id;?>&url=<?php echo get_curren_url();?>">修改</a> | <a href="<?php echo my_site_url('item/'.$row->id);?>" target="_blank">站内</a> | <a href="<?php echo $row->click_url;?>" target="_blank">淘宝</a></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="padding-top:5px"><input type="checkbox" onclick="check_box(this.form.rd_id)" />
        全选
        <select name="action_url" id="action_url" onchange="is_show_status()">
          <option value="" style="color:#FF0000">-选择操作-</option>
          <option value="<?php echo site_url(CTL_FOLDER."product/sort_record");?>">排序</option>
          <option value="#">同步淘宝</option>
          <option value="<?php echo site_url(CTL_FOLDER."product/to_catalog");?>">转移到分类</option>
          <option value="<?php echo site_url(CTL_FOLDER."product/del_record");?>">删除</option>
        </select>
        &nbsp; <span style="display:none" id="status_block">
        <select name="to_catalog_id" id="to_catalog_id">
          <option value="">-转移到的分类-</option>
          <?php foreach(get_cache('catalog') as $row) {?>
          <option value="<?php echo $row->id;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
          <?php }?>
        </select>
        </span>
        <input type="button" name="submit_list_button" class="button-style2" onclick="submit_list_form(this.form,this)" id="submit_list_button" value="执行操作" /></td>
      <td align="right"><?php echo $paginate;?></td>
    </tr>
  </table>
</form>
<script language="javascript">
$(function(){
	$("div.celltext").edit_table({
		param:{'table':'shop_product'}
	});
});
function is_show_status()
{
	var selected_text=$("#action_url option:selected").text();
	if(selected_text=='转移到分类')
	{
		$("#status_block").show();
	}
	else
	{
		$("#status_block").hide();
	}
}
var cur_page,total;
function tongbu()
{
	total = $("#check_box_id input:checked").length;
	cur_page = 1;
	ajax_tongbu();
}

function ajax_tongbu()
{
	if(cur_page > total) 
	{
		hide_message();
		return ;
	}
	
	show_message('正同步第 <b>'+cur_page+'</b> 个商品/总共 '+total+' 个',false);
	$.ajax({
		url:"<?php echo my_site_url(CTL_FOLDER.'ajax/tongbu');?>",
		data:'id='+$("#check_box_id input:checked").eq(cur_page-1).val(),
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
				ajax_tongbu();
			}
		},
		error:function()
		{
			cur_page++;
			ajax_tongbu();
		}
	});
}
function submit_list_form(f,e){
	var action_ob=document.getElementById("action_url");
	var selected_text=$("#action_url option:selected").text();
	if ($("#check_box_id input:checked").length==0)
	{
		alert("请勾选要操作的项,然后再提交");
		return false;
	}
	if (!Validator.Validate(f,2)) return false;
	if (action_ob.value=="") 
	{
		alert("请选择要执行的操作,然后再提交");
		return false;
	}
	if(selected_text=='转移到分类')
	{
		if($("#to_catalog_id").val()=='')
		{
			alert("请选择要转到的分类,然后再提交");
			return false;
		}
	}
	if(selected_text=='同步淘宝')
	{
		tongbu();
		return ;
	}
	if (confirm('确定要执行该操作吗？')){
		f.action=action_ob.value;
		e.value = '数据处理中..';
		e.disabled = true;
		f.submit();
	}
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>