<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<style type="text/css">
#goods {
	width:100%;
	padding:10px 0px
}
#goods div.item {
	width:202px;
	height:250px;
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
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo my_site_url(CTL_FOLDER.'shop');?>">店铺列表</a> &gt; <?php echo $shop_name;?>-店铺商品采集</td>
  </tr>
</table>
<div class="ui-tx-tips-div" style="text-align:left">提示：<br>
  1、店铺的商品不一定有做淘宝客推广，可以选择性的采集。<br>
  2、有些店铺能采集到折扣价和销量，有些可能采集不到，这点需清楚。<br>
  3、如果发现没商品，请尝试刷新该页面。
  <input type="button" onclick="document.location.reload()" value="点击这里刷新" class="button-style" style="width:80px" />
  <br>
</div>
<form method="post" name="list_form" id="list_form">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="padding-top:5px"><input type="checkbox" onclick="check_box(this.form.rd_id)" />
        全选 &nbsp; &nbsp;
        <input type="button" class="button-style" onclick="caiji(this)" value="添加到推广" style="width:100px" /></td>
      <td align="right"><?php if(isset($paginate)) echo $paginate;?></td>
    </tr>
  </table>
  <?php if(! empty($items)){?>
  <div id="goods">
    <?php foreach($items as $row){?>
    <div class="item">
      <div class="img"> <a href="<?php echo $row['detail_url'];?>" target="_blank" title="<?php echo $row['title'];?>"><img width="160" height="160" src="<?php echo $row['pic_url'];?>" /> </a> </div>
      <div class="text">
        <label class="gra">
          <input name="rd_id" type="checkbox" id="rd_id" value="<?php echo $row['num_iid'];?>" />
          <?php echo strcut($row['title'],27);?></label>
        </div>
    </div>
    <?php }?>
    <div style="clear:both"></div>
  </div>
  <?php }?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="padding-top:5px"><input type="checkbox" onclick="check_box(this.form.rd_id)" />
        全选 &nbsp; &nbsp;
        <input type="button" class="button-style" onclick="caiji(this)" value="添加到推广" style="width:100px" /></td>
      <td align="right"><?php if(isset($paginate)) echo $paginate;?></td>
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
          </select>
          &nbsp;&nbsp;
          <label>
            <input type="checkbox" name="is_w" value="1" checked="checked" />
            伪原创</label>
          &nbsp;&nbsp; <a href="<?php echo my_site_url(CTL_FOLDER.'product_catalog');?>" style="color:#F00">+点击这里添加分类</a></td>
      </tr>
    </table>
  </form>
</div>
<script language="javascript">
var catalog_id,is_w;
var cur_page,total;
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
				$(this).dialog("close");
				total = $('input[name=rd_id]:checked').length;
				cur_page = 1;
				dialog_add();
			}  
		}
	});
	$('#dialog_add').dialog('open');
}

function dialog_add()
{
	if(cur_page > total) 
	{
		hide_message();
		return ;
	}
	var cur_item = $('input[name=rd_id]:checked').eq(cur_page - 1);
	show_message('正采集第 <b>'+cur_page+'</b> 个商品/总共 '+total+' 个',false);
	$.ajax({
		url:"<?php echo my_site_url(CTL_FOLDER.'ajax/add_product');?>",
		data:'catalog_id='+catalog_id+'&is_w='+is_w+'&num_iid='+cur_item.val()+'&sid=<?php echo $sid;?>',
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
				dialog_add();
			}
		},
		error:function()
		{
			cur_page++;
			dialog_add();
		}
	});
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
