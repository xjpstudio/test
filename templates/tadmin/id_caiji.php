<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<style type="text/css">
.ui-tx-tips-div{background:#FFFBF2;border:1px solid #F4DDBE; padding:10px; text-align:center; margin:10px 0;}
.ui-tx-tips-div a{ color:#FF0000}
</style>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."product");?>">商品管理</a> &gt; 自定义ID采集</td>
  </tr>
</table>
  <div class="ui-tx-tips-div" style="text-align:left">提示：<br>
  1、输入的商品ID必须是淘宝或天猫商品的ID，例如：http://item.taobao.com/item.htm?id=43923744882 链接中的<font color="#FF0000" style="font-weight:bold">43923744882</font> 就是商品ID。<br />
  2、<font color="#FF0000">多个商品ID之间请用竖线 | 隔开</font>，否则无法识别。例如：43923744882|39898794306<br />
  3、只能采集淘宝或天猫店铺出售中的商品，不采集仓库中的商品。<br>
  4、不建议一次输入太多的ID，否则可能会卡死。<br>
  5、采集过程中，请不要刷新页面，如果发现卡死，请刷新重新采集。<br/>
  </div>
  <fieldset>
  <legend>输入商品ID</legend>
  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" style="margin:10px 0; line-height:30px">
  <tr>
    <td colspan="2" align="left">
    <textarea id="num_iid" cols="100" rows="10" class="ui-tx-input"></textarea>
    </td>
  </tr>
  <tr>
    <td align="left"><strong>开启伪原创：</strong></td>
    <td align="left"><input type="checkbox" name="is_w" value="1" /></td>
  </tr>
  <tr>
    <td width="15%" align="left"><strong>采集到分类：</strong></td>
    <td width="85%" align="left"><select name="catalog_id" id="catalog_id">
              <option value="">-选择分类-</option>
              <?php foreach(get_cache('catalog') as $row) {?>
              <option value="<?php echo $row->queue;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
              <?php }?>
            </select></td>
  </tr>
  <tr>
    <td width="15%">&nbsp;</td>
    <td width="85%"><input type="button" value="点击开始采集" onclick="get_data(this)" class="button-style2" style="width:100px"/></td>
  </tr>
</table>
  </fieldset>
  </div>
</div>
<script language="javascript">
var cur_page,total,num_iid;
var catalog_id;
function get_data(o)
{
	var str = document.getElementById("num_iid").value;
	if(str == '')
	{
		alert('请输入要采集的淘宝或天猫商品ID，多个商品ID之间请用竖线 | 隔开。');
		return false;
	}
	catalog_id = document.getElementById('catalog_id').value;
	if(confirm('确定要开始采集吗'))
	{
		str = str.Trim();
		num_iid = str.split('|');
		total = num_iid.length;
		cur_page = 1;
		o.disabled = true;
		ajax_u_caiji();
	}
}

function ajax_u_caiji()
{
	if(cur_page > total) 
	{
		hide_message();
		alert('采集完毕');
		return ;
	}
	
	var ppar = 'num_iid='+num_iid[cur_page-1]+'&catalog_id='+catalog_id;
	if($('input[name=is_w]:checked').length == 1) ppar += '&is_w=1';
	show_message('正采集第 <b>'+cur_page+'</b> 个商品/总共 '+total+' 个',false);
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