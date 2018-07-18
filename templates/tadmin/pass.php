<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo $url;?>">待审核商品</a> &gt; 审核商品 </td>
  </tr>
</table>
<fieldset>
<legend>审核商品</legend>
<form action="<?php echo site_url(CTL_FOLDER."app/save_pass");?>" method="post" enctype="multipart/form-data">
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td width="16%" valign="top"><font color="#FF0000">*</font>商品标题：</td>
      <td width="84%"><input name="title" type="text" size="80" maxlength="100" dataType="Require" msg="该项必须填写" value="<?php echo $product->title;?>" /></td>
    </tr>
    <tr>
      <td valign="top">商品链接：</td>
      <td style="color:#F00"><?php echo $product->item_url;?></td>
    </tr>
    <tr>
      <td valign="top"><font color="#FF0000">*</font>佣金链接：</td>
      <td><input name="click_url" type="text" size="80" datatype="Require" msg="该项必须填写"  /><br>获取佣金链接的方法：<a href="http://www.alimama.com/" target="_blank">请登陆淘宝联盟</a>-->联盟产品-->单品/店铺推广-->选择单品链接-->黏贴上面的商品链接-->然后点击搜索-->立即推广。</td>
    </tr>
    <tr>
      <td width="16%" valign="top"><font color="#FF0000">*</font>原价(￥)：</td>
      <td width="84%"><input name="shop_price" type="text" size="10" maxlength="10" dataType="Currency" msg="价格格式有误" value="<?php echo $product->shop_price;?>" /></td>
    </tr>
    <tr>
      <td width="16%" valign="top"><font color="#FF0000">*</font>折扣价(￥)：</td>
      <td width="84%"><input name="dc_price" type="text" size="10" maxlength="10" dataType="Currency" msg="价格格式有误" value="<?php echo $product->dc_price;?>" /> <font color="#FF0000">如果没有折扣价，请填写原价</font></td>
    </tr>
    <tr>
          <td><font color="#FF0000">*</font>销量：</td>
          <td><input name="volume" type="text" size="10" value="<?php echo $product->volume;?>" maxlength="10" dataType="Int" msg="销量格式有误" /></td>
        </tr>
    <tr>
      <td valign="top"><font color="#FF0000">*</font>商品图片：</td>
      <td><img src="{tpl_path}images/loading.gif" rel="<?php echo get_real_path($product->pic_path);?>" border="0" class="jq_pic_loading" /><br />
            <input type="text" value="<?php echo $product->pic_path;?>" name="pic_path" id="pic_path" size="25" maxlength="300" />
            <input name="pic" type="file" id="pic" size="15" dataType="Filter" accept="<?php echo str_replace("|",",",UP_IMAGES_EXT);?>" require="false" msg="图片格式有误" />
            <input type="button" class="button-style2" onclick="GetFileDialog('pic_path')" value="选择文件" /><br>上传图片格式：<?php echo UP_IMAGES_EXT;?>，最佳像素：230x230</td>
    </tr>
    <tr>
      <td width="16%" valign="top">商品类目： </td>
      <td width="84%" valign="bottom"><select name="catalog_id[]" multiple="multiple" size="10" style="width:250px">
          <option value="">-选择分类-</option>
          <?php foreach(get_cache('catalog') as $row) {?>
          <option value="<?php echo trim($row->queue,',');?>" <?php if(strpos($product->catalog_id,','.$row->id.',') !== FALSE) echo "selected";?>><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
          <?php }?>
        </select> 按住Ctrl键 可以同时选择多个分类</td>
    </tr>
    <tr>
      <td valign="top"><font color="#FF0000">*</font>排序号：</td>
      <td><input name="seqorder" type="text" id="seqorder" maxlength="8" size="4" value="0" datatype="Integer" msg="该项必须填写数字" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="button" name="sbmit" onclick="subForm(this.form,this)" value="审核通过" class="button-style2" />
        &nbsp;&nbsp;
        <input type="button" onclick="document.location.href='<?php echo $url;?>'" value="返回" class="button-style2" />
        <input name="id" type="hidden" value="<?php echo $product->id;?>" />
        <input name="num_iid" type="hidden" value="<?php echo $product->num_iid;?>" />
        <input name="url" type="hidden" value="<?php echo $url;?>" /></td>
    </tr>
  </table>
</form>
</fieldset>
<?php $this->load->view(TPL_FOLDER."footer");?>
