<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<style type="text/css">
#goods {
	width:100%;
	padding:10px 0px
}
#goods div.item {
	width:202px;
	height:300px;
	text-align:left;
	display:inline;
	float:left;
	line-height:22px;
	text-align:center;
	overflow:hidden
}
#goods div.img {
	height:160px;
	padding:2px;
	border:1px solid #E1E1E1;
	width:160px;
	margin:0 auto
}
#goods div.text { width:180px; overflow:hidden;margin:0 auto}
.gra{ color: #06F}
</style>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo my_site_url(CTL_FOLDER.'product');?>">商品列表</a> &gt; 采集商品</td>
  </tr>
</table>
<div class="ui-tx-tips-div">提示：先搜索商品，然后勾选你需要推广的商品，最后点击“添加到推广”。</div>
<fieldset>
<legend>淘客商品搜索</legend>
<form onsubmit="return Validator.Validate(this,1)">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:5px">
  <tr>
    <td height="24" align="left" >
      关键词：<input name="q" dataType="Require" msg="请输入搜索关键词" type="text" size="15" maxlength="30" <?php if(isset($get['q']) && ! empty($get['q'])){?> value="<?php echo $get['q'];?>"<?php }?> /> &nbsp;价格：<input dataType="Currency" msg="价格范围有误" require="false" name="start_price" type="text" size="8" maxlength="10" <?php if(isset($get['start_price']) && ! empty($get['start_price'])){?> value="<?php echo $get['start_price'];?>"<?php }?> /> - <input dataType="Currency" msg="价格范围有误" require="false" name="end_price" type="text" size="8" maxlength="10" <?php if(isset($get['end_price']) && ! empty($get['end_price'])){?> value="<?php echo $get['end_price'];?>"<?php }?> /> &nbsp;
      <select name="sorts">
        <option value="">选择排序方式</option>
        <option value="s" <?php if(isset($get['sorts']) && $get['sorts'] == 's') echo 'selected';?>>人气排序</option>
        <option value="p" <?php if(isset($get['sorts']) && $get['sorts'] == 'p') echo 'selected';?>>价格从低到高</option>
        <option value="pd" <?php if(isset($get['sorts']) && $get['sorts'] == 'pd') echo 'selected';?>>价格从高到低</option>
        <option value="d" <?php if(isset($get['sorts']) && $get['sorts'] == 'd') echo 'selected';?>>销量从高到低</option>
        </select>
      &nbsp;<label><input type="checkbox" name="post_fee" value="1" <?php if(isset($get['post_fee']) && ! empty($get['post_fee'])){?> checked="checked"<?php }?> />包邮</label> &nbsp;<input type="submit" value="搜索" class="button-style2" style="width:50px">
      </td>
  </tr>
  </table>
</form>
</fieldset>
<form method="post" name="list_form" id="list_form">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="padding-top:5px"><input type="checkbox" onclick="check_box(this.form.rd_id)" />
        全选 &nbsp; &nbsp;
        <input type="button" class="button-style" onclick="caiji(this)" value="添加到推广" style="width:100px" />
      </td>
      <td align="right"><?php echo $paginate;?></td>
    </tr>
  </table>
  <div id="goods">
    <?php foreach($query as $row){
		$title = replace_s($row['title']);
		if(isset($row['price_with_rate']) && $row['price_with_rate'] > 0) $price = $row['price_with_rate'];
		else $price = $row['price'];
	?>
    <div class="item">
      <div class="img"> <a href="<?php echo $row['url'];?>" target="_blank" title="<?php echo $title;?>"><img width="160" height="160" src="<?php echo $row['pic_path'];?>" /> </a> </div>
      <div class="text">
      <label class="gra"><input name="rd_id" type="checkbox" id="rd_id" value="<?php echo $row['item_id'];?>|<?php echo $row['sold'];?>|<?php echo $price;?>" />
      <?php echo strcut($title,27);?></label><br>
      原：￥<?php echo $row['price'];?> 折：￥<font color="#FF0000"><?php echo $price;?></font><br>
      成交：<?php echo $row['sold'];?><br>
      <?php echo $row['nick'];?>
      </div>
       </div>
    <?php }?>
    <div style="clear:both"></div>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="padding-top:5px"><input type="checkbox" onclick="check_box(this.form.rd_id)" />
        全选 &nbsp; &nbsp;
        <input type="button" class="button-style" onclick="caiji(this)" value="添加到推广" style="width:100px" />
      </td>
      <td align="right"><?php echo $paginate;?></td>
    </tr>
  </table>
</form>
<div id="dialog_add" style="display:none; position:relative">
<form name="dialog_add_form" id="dialog_add_form">
    <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
      <tr>
        <td width="146">添加到分类：</td>
        <td><select name="catalog_id" id="catalog_id">
        <option value="">==选择分类==</option>
        <?php foreach(get_cache('catalog') as $row) {?> 
        <option value="<?php echo $row->queue;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
        <?php }?>
        </select> &nbsp;&nbsp; <label><input type="checkbox" name="is_w" value="1" checked="checked" />伪原创</label> &nbsp;&nbsp; <a href="<?php echo my_site_url(CTL_FOLDER.'product_catalog');?>" style="color:#F00">+点击这里添加分类</a></td>
      </tr>
    </table>
</form>
</div>
<script language="javascript">
var catalog_id,is_w;
function caiji(o)
{
	if($('input[name=rd_id]:checked').length == 0)
	{
		alert('请勾选要添加的商品');
		return;
	}
	add_product();
}
function add_product()
{
	$('#dialog_add').dialog({  
		hide:'',      
		autoOpen:false,
		width:750,
		height:100,  
		modal:true, //蒙层  
		title:'添加商品', 
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
			'确定':function(){
				catalog_id = document.getElementById("catalog_id").value;
				if($('input[name=is_w]:checked').length == 1) is_w = 1;
				else is_w = 2;
				show_message('数据处理中，请稍等...',false);
				$(this).dialog("close");
				dialog_add();
			}  
		}
	});
	$('#dialog_add').dialog('open');
}
function dialog_add()
{
	var str = '';
	$('input[name=rd_id]:checked').each(function(){
		str += $(this).val()+':';
	});
	if(str != '') str = str.substr(0,str.length - 1);
	$.ajax({
		url:'<?php echo my_site_url(CTL_FOLDER.'ajax/add_product');?>',
		data:'str='+str+'&catalog_id='+catalog_id+'&is_w='+is_w,
		type:'POST',
		dataType:'json',
		success:function(msg)
		{
			hide_message();
			if(typeof(msg.err) == 'undefined')
			{
				alert('商品添加成功，您可以继续添加。');
				return;
			}
			else if(msg.err == 'nologin')
			{
				alert('登录超时，请重新登录');
				return;
			}
		}
	});
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
