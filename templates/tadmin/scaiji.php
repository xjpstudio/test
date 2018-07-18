<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo my_site_url(CTL_FOLDER.'shop_move');?>">采集店铺设置</a> &gt; 店铺商品采集</td>
  </tr>
</table>
  <div class="ui-tx-tips-div" style="text-align:left">提示：<br>
  1、由于是整店采，所以无论是否为 淘宝客商品 都会采集，这点需清楚。<br>
  2、只能采集出售中的商品，不采集仓库中的商品。<br>
  3、采集过程中，请不要关闭浏览器，等待程序全部采集完成。<br>
  4、该采集将快速消耗MYSQL数据库空间，所以请密切注意你的数据库空间容量，数据库空间不足时，须升级容量，或者删除部分商品以释放空间。<br>
  5、该采集将快速消耗API调用量，如果发现采集不了，有可能调用量已经用完，这时候你需要等第二天开放平台恢复调用量之后才能重新采集。所以不建议在后台频繁采集，可以每天采一点这样逐渐增加商品。<br>
 6、如果发现采集的商品页数为0，请尝试刷新该页面。<input type="button" onclick="document.location.reload()" value="点击这里刷新" class="button-style" style="width:80px" /><br>
  </div>
  <fieldset>
  <legend>店铺数据统计</legend>
  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" style="margin:10px 0; line-height:30px">
  <tr>
    <td colspan="2" align="left" style="line-height:30px"> 店铺掌柜账号：<?php echo $shop_config['nick'];?><br>
      店铺网址：<?php echo $shop_config['shop_url'];?><br>
      店铺自定义类目数：<b style="color:#FF0000"><?php echo $ctotal;?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;商品总页数：<b style="color:#FF0000"><?php echo $total_page;?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input <?php if(!($shop_config['nick'] && $shop_config['shop_url'] && $total_page)) echo 'disabled="disabled"';?> type="button" value="点击开始采集" onclick="get_data(this)" class="button-style2" style="width:100px"/></td>
  </tr>
</table>
  </fieldset>
  <fieldset>
  <legend>采集进度</legend>
  <table width="96%"  border="0" cellpadding="5" cellspacing="0" style="margin:10px; line-height:30px" id="process">
  </table>
  </fieldset>
  </div>
</div>
<script language="javascript">
var cat_total = <?php echo $ctotal;?>;
var page_total = <?php echo $total_page;?>;
var pId = 0;
var mitem;
$(function(){
	if(cat_total > 0)
	{
		$('<tr><td width="17%" align="left">店铺自定义类目('+cat_total+')</td><td align="center" valign="middle">----------------------------------------------------------------------------------------------------</td><td width="15%" align="right" class="cqueue" id="get_cat"><font color="#FF0000">等待采集</font></td></tr>').appendTo('#process');
	}
	if(page_total > 0)
	{
		for(var i = 1; i <= page_total; i++)
		{
			$('<tr><td width="17%" align="left">店铺商品(第'+i+'页/'+page_total+')</td><td align="center" valign="middle">----------------------------------------------------------------------------------------------------</td><td width="15%" align="right" class="cqueue" id="get_goods" page_no="'+i+'"><font color="#FF0000">等待采集</font></td></tr>').appendTo('#process');
		}
	}
});
function get_data(o)
{
	if(page_total == 0 && cat_total == 0)
	{
		alert('操作有误，没有任何数据可采集');
		return ;
	}
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
	if(pId>mitem.length-1) 
	{
		$('<tr><td align="center" style="font-weight:bold;color:#009900" colspan="3">全部数据采集完毕</td></tr>').insertBefore('#process tr:eq(0)');
		return ;
	}
	var ppar = "mitem="+mitem.eq(pId).attr('id');
	if(typeof(mitem.eq(pId).attr('page_no')) != 'undefined') ppar += '&page_no='+mitem.eq(pId).attr('page_no');
	mitem.eq(pId).html('<img src="'+pic_loading_path+'" /> 数据采集中...');
	$.ajax({
		url:"<?php echo my_site_url(CTL_FOLDER.'ajax/ajax_make');?>",
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
				setTimeout(function(){ajax_process();},4000);
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
