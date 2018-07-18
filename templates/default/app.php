<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<link rel="stylesheet" href="{tpl_path}style/sitemap.css" type="text/css" />
<script type="text/javascript" src="{root_path}js/validator.js"></script>
<div class="wrap"> <?php echo get_ads(59);?> </div>
<div class="wrap">
  <div class="ui-tx-nav-bar"><a href="<?php echo ROOT_PATH;?>">首页</a> <?php echo $nav;?></div>
  <div class="sitemap_main">
    <div class="list-box">
      <form action="<?php echo site_url(CTL_FOLDER."app/save_app");?>" method="post" enctype="multipart/form-data">
        <table width="97%" border="0" cellspacing="0" cellpadding="0" style="margin:10px auto" class="app_tb">
          <tr>
            <td class="app_title" style="text-align: center" colspan="2">商家报名</td>
          </tr>
          <tr>
            <td colspan="2" valign="top" style="color:#F00"><b>报名须知：</b>提交的商品必须已设置淘宝客推广，否则不通过。</td>
          </tr>
          <tr>
            <td valign="top"><font color="#FF0000">*</font>商品链接：</td>
            <td><input name="click_url" id="click_url" type="text" size="120" dataType="Url" msg="链接格式有误" class="tx-input" maxlength="255" <?php if(isset($item['detail_url'])) echo 'value="'.$item['detail_url'].'"';?> />
              <input type="button" onclick="get_data()" style="padding:5px" value="点击获取数据" />
              <br>
              请填写淘宝或天猫商品详细页地址，例如：<font color="#FF0000">http://item.taobao.com/item.htm?id=39305121854</font>，然后"点击获取数据"，如果无法获取数据，请手动填写。</td>
          </tr>
          <tr>
            <td valign="top"><font color="#FF0000">*</font>商品ID：</td>
            <td><input name="num_iid" type="text" size="20" maxlength="20" dataType="Custom" msg="ID格式有误" regexp="^[1-9]+\d*$" class="tx-input" <?php if(isset($item['num_iid'])) echo 'value="'.$item['num_iid'].'"';?> />
              <br>
              例如：http://item.taobao.com/item.htm?id=39305121854 链接中的<font color="#FF0000">39305121854</font> 就是商品ID</td>
          </tr>
          <tr>
            <td width="13%" valign="top"><font color="#FF0000">*</font>商品名称：</td>
            <td width="87%"><input name="title" type="text" size="80" maxlength="100" dataType="Require" msg="该项必须填写" class="tx-input" <?php if(isset($item['title'])) echo 'value="'.$item['title'].'"';?> /></td>
          </tr>
          <tr>
            <td width="13%" valign="top"><font color="#FF0000">*</font>原价(￥)：</td>
            <td width="87%"><input name="shop_price" type="text" size="10" maxlength="10" dataType="Currency" msg="价格格式有误" class="tx-input" <?php if(isset($item['shop_price'])) echo 'value="'.$item['shop_price'].'"';?> /></td>
          </tr>
          <tr>
            <td width="13%" valign="top"><font color="#FF0000">*</font>折扣价(￥)：</td>
            <td width="87%"><input name="dc_price" type="text" size="10" maxlength="10" dataType="Currency" msg="价格格式有误" class="tx-input" <?php if(isset($item['dc_price'])) echo 'value="'.$item['dc_price'].'"'; else echo 'value="0"';?> />
              没有折扣价，请填写零</td>
          </tr>
          <tr>
            <td width="13%" valign="top"><font color="#FF0000">*</font>销量：</td>
            <td width="87%"><input name="volume" <?php if(isset($item['volume'])) echo 'value="'.$item['volume'].'"'; else echo 'value="0"';?> type="text" size="10" maxlength="10" dataType="Int" msg="销量格式有误" class="tx-input" /> 没销量，请填写零</td>
          </tr>
          <tr>
            <td width="13%" valign="top">掌柜昵称：</td>
            <td width="87%"><input name="nick" type="text" size="30" maxlength="50" class="tx-input"  <?php if(isset($item['nick'])) echo 'value="'.$item['nick'].'"';?> /> 淘宝或天猫店铺掌柜账号</td>
          </tr>
<?php 
$pic_url = '';
if(isset($item['pic_url']) && $item['pic_url'])
{
  foreach($item['pic_url'] as $v)
  {
	$pic_url = $v;
	break;
  }
}
?>
          <tr>
            <td valign="top"><font color="#FF0000">*</font>图片地址：</td>
            <td><input name="pic_path" type="text" size="120" maxlength="255" dataType="Url" msg="图片地址格式有误" class="tx-input" value="<?php echo $pic_url;?>" />
              <br>
            商品图片地址，例如：http://img03.taobaocdn.com/bao/uploaded/i3/16154039783708004/T1yAqJFdXdXXXXXXXX_!!0-item_pic.jpg</td>
          </tr>
          <tr>
            <td width="13%" valign="top">所属分类：</td>
            <td width="87%" valign="bottom"><select name="catalog_id">
                <option value="">-选择分类-</option>
                <?php foreach(get_cache('catalog') as $row) {?>
                <option value="<?php echo $row->queue;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
                <?php }?>
              </select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="button" onclick="subForm(this.form,this)" value="确定提交" style="padding:5px" /></td>
          </tr>
        </table>
        <textarea name="content" style="display:none"><?php if(isset($item['content'])) echo $item['content'];?></textarea>
      </form>
    </div>
  </div>
</div>
<script language="javascript">
function get_data()
{
	var click_url = document.getElementById("click_url").value;
	if (click_url == '')
	{
		alert('请填写商品链接地址');
		return false;
	}
	document.location.href = '<?php echo my_site_url(CTL_FOLDER.'app');?>?url='+encodeURIComponent(click_url);
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
