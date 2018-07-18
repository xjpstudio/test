<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo my_site_url(CTL_FOLDER.'product');?>">商品列表</a> &gt; 大批量采集商品</td>
  </tr>
</table>
<div class="ui-tx-tips-div">提示：<br>
  1、请在下面输入关键词搜索您要采集的商品。<br>
  2、采集过程中，请不要关闭浏览器，等待程序全部采集完成。<br>
  3、该采集将快速消耗MYSQL数据库空间，所以请密切注意你的数据库空间容量，数据库空间不足的时候，须升级容量，或者删除部分商品以释放空间。<br>
  4、该采集将快速消耗API调用量，如果发现采集不了，有可能调用量已经用完，这时候你需要等第二天开放平台恢复调用量之后才能重新采集。所以不建议在后台频繁采集，可以每天采一点这样逐渐增加商品。<br>
</div>
<fieldset>
  <legend>淘客商品采集</legend>
  <form id="sform">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:10px 0">
      <tr>
        <td align="left" style=" line-height:30px"> 关键词：
          <input name="q" dataType="Require" msg="请输入搜索关键词" type="text" size="15" maxlength="30" <?php if(isset($get['q']) && ! empty($get['q'])){?> value="<?php echo $get['q'];?>"<?php }?> />
          &nbsp;价格：
          <input dataType="Currency" msg="价格范围有误" require="false" name="start_price" type="text" size="8" maxlength="10" <?php if(isset($get['start_price']) && ! empty($get['start_price'])){?> value="<?php echo $get['start_price'];?>"<?php }?> />
          -
          <input dataType="Currency" msg="价格范围有误" require="false" name="end_price" type="text" size="8" maxlength="10" <?php if(isset($get['end_price']) && ! empty($get['end_price'])){?> value="<?php echo $get['end_price'];?>"<?php }?> />
          &nbsp;
          <select name="sorts">
            <option value="">选择排序方式</option>
            <option value="s" <?php if(isset($get['sorts']) && $get['sorts'] == 's') echo 'selected';?>>人气排序</option>
            <option value="p" <?php if(isset($get['sorts']) && $get['sorts'] == 'p') echo 'selected';?>>价格从低到高</option>
            <option value="pd" <?php if(isset($get['sorts']) && $get['sorts'] == 'pd') echo 'selected';?>>价格从高到低</option>
            <option value="d" <?php if(isset($get['sorts']) && $get['sorts'] == 'd') echo 'selected';?>>销量从高到低</option>
          </select>
          &nbsp;&nbsp;
          <select name="catalog_id" id="catalog_id">
            <option value="">==投放到分类==</option>
            <?php foreach(get_cache('catalog') as $row) {?>
            <option value="<?php echo $row->queue;?>" <?php if(isset($get['catalog_id']) && $get['catalog_id'] == $row->queue) echo 'selected';?>><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
            <?php }?>
          </select>
          <br>
          <label>
            <input <?php if(isset($get['is_w']) && ! empty($get['is_w'])){?> checked="checked"<?php }?> type="checkbox" name="is_w" value="1" />
            伪原创</label>
          &nbsp;&nbsp; 
          <label>
            <input type="checkbox" name="post_fee" value="1" <?php if(isset($get['post_fee']) && ! empty($get['post_fee'])){?> checked="checked"<?php }?> />
            包邮</label>
          &nbsp;
          <input value="搜索" class="button-style2" type="button" onclick="subForm(this.form,this)" style="width:50px"></td>
      </tr>
    </table>
  </form>
</fieldset>
<script language="javascript">
function subForm(f,e)
{
	if( ! Validator.Validate(f,1)) return;
	if(confirm('确定采集？'))
	{
		e.value = '数据处理中..';
		e.disabled = true;
		f.submit();
	}
}
</script>
<?php if($total_page == 0 && isset($get['q'])){?>
<div class="ui-tx-tips-div" style="text-align:center; font-size:14px" id="process">
<b style="color: #F00">没有商品可采集，请更换搜索关键词重新搜索！</b>
</div>
<?php }?> 
<?php if($total_page == 1){?>
<fieldset>
<legend>采集进度</legend>
<div class="ui-tx-tips-div" style="text-align:center; font-size:14px" id="process">
<b style="color:#390">全部采集完成！</b>
</div>
</fieldset>
<?php }else if($total_page > 1){?>
<fieldset>
<legend>采集进度</legend>
<div class="ui-tx-tips-div" style="text-align:center; font-size:14px;" id="process">
正在采集第 <b style="color:#F00" id="cur_page">2</b> 页，总共 <b style="color:#090"><?php echo $total_page;?></b> 页，每页10个商品，请耐心等待...
</div>
</fieldset>
<script language="javascript">
var total_page = <?php echo $total_page;?>;
var str = $('#sform').serialize();
var pId = 2;
function ajax_process()
{
	if(pId > total_page) 
	{
		$('#process').html('<b style="color:#390">全部采集完成！</b>');
		return ;
	}
	$.ajax({
		url:"<?php echo my_site_url(CTL_FOLDER.'ajax/pcaiji');?>",
		data:str+'&cur_page='+pId,
		type:"POST",
		dataType:"json",
		success:function(msg)
		{
			if(typeof(msg.err) == 'undefined')
			{
				if(msg.msg == 'yes')
				{
					pId++;
					if(pId <= total_page) $('#cur_page').html(pId);
					setTimeout(function(){ajax_process();},1000);
				}
				else
				{
					$('#process').html('<b style="color:#F00">采集失败，请看上面的提示！</b>');
				}
			}
			else
			{
				alert('登录超时，请重新登录');
				return;
			}
		}
	});
}
ajax_process();
</script>
<?php }?>
<?php $this->load->view(TPL_FOLDER."footer");?>